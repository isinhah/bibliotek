<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookHasActiveLoansException extends Exception
{
    public function render(Request $request): RedirectResponse
    {
        return redirect()->back()
            ->with('error', $this->getMessage());
    }
}
