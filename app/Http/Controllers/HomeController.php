<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function __construct(
        protected HomeService $homeService
    ) {}

    public function index(Request $request): View
    {
        $searchTerm = $request->query('search');

        if (!empty($searchTerm)) {
            $searchResults = $this->homeService->searchBooks($searchTerm, perPage: 12);
            $searchResults->appends(['search' => $searchTerm]);

            return view('home', [
                'searchTerm' => $searchTerm,
                'searchResults' => $searchResults,
                'categoriesWithBooks' => null
            ]);
        }

        $categoriesWithBooks = $this->homeService->getCategoriesWithRecentBooks(booksLimit: 10);

        return view('home', compact('categoriesWithBooks', 'searchTerm'));
    }
}
