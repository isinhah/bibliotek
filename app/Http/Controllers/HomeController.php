<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use App\Models\Book;
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

        $topBooks = [];
        if (empty($searchTerm)) {
            $topBooks = Book::select('books.*')
                ->with(['author', 'category'])
                ->leftJoin('loans', 'books.id', '=', 'loans.book_id')
                ->selectRaw('count(loans.id) as total_loans')
                ->groupBy('books.id')
                ->orderBy('total_loans', 'desc')
                ->take(10)
                ->get()
                ->map(function ($book) {
                    $book->cover_url = is_numeric($book->cover_id)
                        ? 'https://covers.openlibrary.org/b/id/' . $book->cover_id . '-M.jpg'
                        : asset('storage/' . $book->cover_id);
                    return $book;
                });
        }

        return Inertia::render('Home', [
            'searchTerm'          => $searchTerm,
            'searchResults'       => !empty($searchTerm) ? $data : null,
            'categoriesWithBooks' => empty($searchTerm) ? $data : null,
            'savedBookIds'        => auth()->check() ? auth()->user()->readingList()->pluck('books.id')->toArray() : [],
            'loanedBookIds'       => $loanedBookIds,
            'topBooks'            => $topBooks,
        ]);
    }
}
