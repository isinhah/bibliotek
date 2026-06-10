<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookAlreadyExistsException extends Exception
{
    public function render(Request $request): RedirectResponse
    {
        return redirect()->back()
            ->withInput()
            ->with('error', $this->getMessage());
    }
}
