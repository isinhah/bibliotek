<?php

namespace App\Http\Controllers;

use App\Services\ReadingListService;
use Illuminate\Http\RedirectResponse;

class ReadingListController extends Controller
{
    public function __construct(
        protected ReadingListService $readingListService
    ) {}

    public function toggle(int $bookId): RedirectResponse
    {
        $result = $this->readingListService->toggleBook($bookId);

        return back()->with('success', $result['message']);
    }
}
