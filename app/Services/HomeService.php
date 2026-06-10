<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class HomeService
{
    public function searchBooks(?string $searchTerm, int $perPage = 12): LengthAwarePaginator
    {
        return Book::with(['author', 'category'])
            ->where('title', 'like', '%' . $searchTerm . '%')
            ->latest()
            ->paginate($perPage);
    }

    public function getCategoriesWithRecentBooks(int $booksLimit = 10): Collection
    {
        return Category::has('books')
            ->with(['books' => function ($query) use ($booksLimit) {
                $query->with('author')->latest()->take($booksLimit);
            }])
            ->get();
    }
}
