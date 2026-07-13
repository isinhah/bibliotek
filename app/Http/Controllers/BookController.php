<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Requests\BookStockRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Services\BookService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class BookController extends Controller
{

    public function __construct(protected BookService $bookService){}

    public function index(Request $request, int $categoryId): Response
    {
        $category = Category::findOrFail($categoryId);
        $searchTerm = $request->query('search');

        $books = $this->bookService->listByCategory($category, $searchTerm, perPage: 12);
        $books->appends(['search' => $searchTerm]);

        $loanedBookIds = auth()->check()
            ? auth()->user()->loans()->whereIn('status', ['PENDING', 'ACTIVE', 'OVERDUE'])->pluck('book_id')->toArray()
            : [];

        return Inertia::render('Categories/BooksIndex', [
            'category' => $category,
            'books' => $books,
            'searchTerm' => $searchTerm,
            'savedBookIds' => auth()->check() ? auth()->user()->readingList()->pluck('books.id')->toArray() : [],
            'loanedBookIds' => $loanedBookIds,
        ]);
    }

    public function indexAdmin(Request $request): View
    {
        $searchTerm = $request->query('search');

        $books = $this->bookService->listForAdmin($searchTerm, perPage: 15);
        $books->appends(['search' => $searchTerm]);

        $authors = Author::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.books.index', compact('books', 'authors', 'categories'));
    }

    public function store(BookRequest $request): RedirectResponse
    {
        $this->bookService->create($request->validated());

        return redirect()->route('admin.books.index')
            ->with('success', 'Livro cadastrado com sucesso!');
    }

    public function edit(Book $book): View
    {
        $book->load(['author', 'category']);
        return view('books.edit', compact('book'));
    }

    public function updateFull(BookRequest $request, Book $book): RedirectResponse
    {
        try {
            $this->bookService->updateFull($book, $request->validated());

            return redirect()->route('admin.books.index')
                ->with('success', "Livro '{$book->title}' atualizado com sucesso no painel!");
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function update(BookStockRequest $request, Book $book): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $this->bookService->updateStock($book, (int) $validated['stock']);

            return redirect()->route('home')
                ->with('success', "Estoque do livro '{$book->title}' atualizado com sucesso!");
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Não foi possível atualizar o estoque: " . $e->getMessage());
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->bookService->delete($id);

        return redirect()->route('admin.books.index')
            ->with('success', "Livro removido com sucesso!");
    }

    public function importFromAPI(Request $request, int $categoryId): RedirectResponse
    {
        $limit = $request->input('limit') ? (int) $request->input('limit') : 10;

        $quantity = $this->bookService->importBooksFromApi($categoryId, $limit);

        return redirect()->route('categories.index')
            ->with('success', "Sucesso! Foram importados {$quantity} novos livros para esta categoria.");
    }
}
