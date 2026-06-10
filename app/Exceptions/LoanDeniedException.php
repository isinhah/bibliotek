<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;

class LoanDeniedException extends Exception
{
    public function render($request): RedirectResponse
    {
        return redirect()->back()
            ->withInput()
            ->with('error', $this->getMessage());
    }
}
