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

        $data = !empty($searchTerm)
            ? $this->homeService->searchBooks($searchTerm, perPage: 12)
            : $this->homeService->getCategoriesWithRecentBooks(booksLimit: 10);

        $loanedBookIds = auth()->check()
            ? auth()->user()->loans()->whereIn('status', ['PENDING', 'ACTIVE', 'OVERDUE'])->pluck('book_id')->toArray()
            : [];

        return Inertia::render('Home', [
            'searchTerm'          => $searchTerm,
            'searchResults'       => !empty($searchTerm) ? $data : null,
            'categoriesWithBooks' => empty($searchTerm) ? $data : null,
            'savedBookIds'        => auth()->check() ? auth()->user()->readingList()->pluck('books.id')->toArray() : [],
            'loanedBookIds'       => $loanedBookIds,
        ]);
    }
}
