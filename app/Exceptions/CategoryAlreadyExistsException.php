<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;

class CategoryAlreadyExistsException extends Exception
{
    public function render($request): RedirectResponse
    {
        return redirect()->back()
            ->withInput()
            ->with('error', $this->getMessage());
    }
}
