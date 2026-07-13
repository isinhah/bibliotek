<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{

    public function __construct(
        protected HomeService $homeService
    ) {}

    public function index(Request $request): Response
    {
        $searchTerm = $request->query('search');

        if (!empty($searchTerm)) {
            $searchResults = $this->homeService->searchBooks($searchTerm, perPage: 12);
            $searchResults->appends(['search' => $searchTerm]);

            return Inertia::render('Home', [
                'searchTerm' => $searchTerm,
                'searchResults' => $searchResults,
                'categoriesWithBooks' => null
            ]);
        }

        $categoriesWithBooks = $this->homeService->getCategoriesWithRecentBooks(booksLimit: 10);

        return Inertia::render('Home', [
            'categoriesWithBooks' => $categoriesWithBooks,
            'searchTerm' => $searchTerm
        ]);
    }
}
