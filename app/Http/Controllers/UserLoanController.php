<?php

namespace App\Http\Controllers;

use App\DTOs\FilterUserLoanDTO;
use App\Services\LoanService;
use Illuminate\Http\Request;

class UserLoanController extends Controller
{

    public function __construct(
        protected LoanService $loanService
    ) {}

    public function index(Request $request)
    {
        $filterDTO = new FilterUserLoanDTO(
            status: $request->query('status'),
            search: $request->query('search'),
            perPage: 15
        );

        $loans = $this->loanService->getUserPaginatedLoans($filterDTO, auth()->id());
        $statusFilter = $filterDTO->status;

        return view('loans.index', compact('loans', 'statusFilter'));
    }
}
