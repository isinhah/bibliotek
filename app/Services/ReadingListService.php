<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class ReadingListService
{

    public function toggleBook(int $bookId): array
    {
        $user = Auth::user();

        $result = $user->readingList()->toggle($bookId);

        $wasAdded = count($result['attached']) > 0;

        return [
            'success' => true,
            'attached' => $wasAdded,
            'message' => $wasAdded ? 'Livro adicionado à sua lista!' : 'Livro removido da sua lista.'
        ];
    }

    public function removeBook(int $bookId): void
    {
        $user = Auth::user();
        $user->readingList()->detach($bookId);
    }

    public function isBookSaved(int $bookId): bool
    {
        if (!Auth::check()) {
            return false;
        }

        $user = Auth::user();
        return $user->readingList()->where('book_id', $bookId)->exists();
    }
}
