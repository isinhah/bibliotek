<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService) {}

    public function index(Request $request): View
    {
        $searchTerm = $request->query('search');

        $categories = $this->categoryService->listForAdmin($searchTerm, perPage: 15);
        $categories->appends(['search' => $searchTerm]);

        return view('admin.categories.index', compact('categories'));
    }

    public function indexPublic(): Response
    {
        $categories = $this->categoryService->listForCatalog();

        return Inertia::render('Categories/Index', [
            'categories' => $categories
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $this->categoryService->create($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function update(CategoryRequest $request, int $id): RedirectResponse
    {
        $this->categoryService->update($id, $request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->categoryService->delete($id);

        return redirect()->route('categories.index')
            ->with('success', 'Categoria deletada com sucesso!');
    }
}
