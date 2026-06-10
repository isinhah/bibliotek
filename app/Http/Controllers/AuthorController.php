<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Services\AuthorService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthorController extends Controller
{

    public function __construct(protected AuthorService $authorService) {}

    public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $selectedLetter = $request->query('letter');

        $authors = $this->authorService->listForCatalog($searchTerm, $selectedLetter, 16);

        $authors->appends([
            'search' => $searchTerm,
            'letter' => $selectedLetter
        ]);

        $alphabet = range('A', 'Z');

        return view('authors.index', compact('authors', 'searchTerm', 'alphabet', 'selectedLetter'));
    }

    public function indexAdmin(Request $request)
    {
        $searchTerm = $request->query('search');

        $authors = $this->authorService->listForAdmin($searchTerm, 15);

        $authors->appends([
            'search' => $searchTerm
        ]);

        return view('admin.authors.index', compact('authors'));
    }

    public function books(Author $author): View
    {
        $books = $this->authorService->getBooksPaginated($author, perPage: 12);

        return view('authors.books', compact('author', 'books'));
    }

    public function store(AuthorRequest $request): RedirectResponse
    {
        try {
            $this->authorService->create($request->validated());

            return redirect()->back()
                ->with('success', 'Autor cadastrado com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao salvar autor: ' . $e->getMessage());
        }
    }

    public function update(AuthorRequest $request, int $id): RedirectResponse
    {
        try {
            $this->authorService->update($id, $request->validated());

            return redirect()->route('admin.authors.index')
                ->with('success', 'Autor atualizado com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar autor: ' . $e->getMessage());
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->authorService->delete($id);

            return redirect()->route('admin.authors.index')
                ->with('success', 'Autor e seus respectivos livros foram removidos com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}
