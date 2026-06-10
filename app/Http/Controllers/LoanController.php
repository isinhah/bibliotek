<?php

namespace App\Http\Controllers;

use App\DTOs\FilterLoanDTO;
use App\Http\Requests\StoreLoanRequest;
use App\Services\LoanService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function __construct(
        protected LoanService $loanService
    ) {}

    public function index(Request $request)
    {
        $filterDTO = new FilterLoanDTO(
            status: $request->query('status'),
            search: $request->query('search'),
            perPage: 15
        );

        $loans = $this->loanService->getPaginatedLoans($filterDTO);
        $statusFilter = $filterDTO->status;

        return view('admin.loans.index', compact('loans', 'statusFilter'));
    }

    public function store(StoreLoanRequest $request, int $bookId): RedirectResponse
    {
        $this->loanService->createLoan($request->toDTO($bookId));

        return redirect()->back()
            ->with('success', 'Livro alugado com sucesso! Retire na biblioteca.');
    }

    public function confirmPickup(int $id): RedirectResponse
    {
        $this->loanService->confirmPickup($id);

        return redirect()->back()
            ->with('success', 'Livro entregue ao leitor! Prazo iniciado.');
    }

    public function returnBook(int $id): RedirectResponse
    {
        $this->loanService->returnBook($id);

        return redirect()->back()
            ->with('success', 'Devolução confirmada e estoque atualizado!');
    }

    public function cancel(int $id): RedirectResponse
    {
        $this->loanService->cancelLoan($id);

        return redirect()->back()
            ->with('success', 'Reserva cancelada e livro devolvido ao estoque.');
    }
}
