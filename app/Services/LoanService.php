<?php

namespace App\Services;

use App\DTOs\CreateLoanDTO;
use App\DTOs\FilterLoanDTO;
use App\DTOs\FilterUserLoanDTO;
use App\Enums\LoanStatus;
use App\Exceptions\LoanDeniedException;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class LoanService
{

    public function getPaginatedLoans(FilterLoanDTO $dto): LengthAwarePaginator
    {
        Loan::where('status', LoanStatus::ACTIVE)
            ->where('due_date', '<', now())
            ->whereNull('return_date')
            ->update(['status' => LoanStatus::OVERDUE]);

        $loansQuery = Loan::with(['user', 'book'])->orderBy('due_date', 'asc');

        if (!empty($dto->status)) {
            $loansQuery->where('status', $dto->status);
        }

        if (!empty($dto->search)) {
            $loansQuery->whereHas('user', function ($query) use ($dto) {
                $query->where('name', 'like', '%' . $dto->search . '%');
            });
        }

        return $loansQuery->paginate($dto->perPage);
    }

    public function getUserPaginatedLoans(FilterUserLoanDTO $dto, int $userId): LengthAwarePaginator
    {
        Loan::where('status', LoanStatus::ACTIVE)
            ->where('due_date', '<', now())
            ->whereNull('return_date')
            ->update(['status' => LoanStatus::OVERDUE]);

        $loansQuery = Loan::where('user_id', $userId)
            ->with(['book'])
            ->orderBy('due_date', 'asc');

        if (!empty($dto->status)) {
            $loansQuery->where('status', $dto->status);
        }

        if (!empty($dto->search)) {
            $loansQuery->whereHas('book', function ($query) use ($dto) {
                $query->where('title', 'like', '%' . $dto->search . '%');
            });
        }

        return $loansQuery->paginate($dto->perPage);
    }

    public function createLoan(CreateLoanDTO $dto): Loan
    {
        return DB::transaction(function () use ($dto) {
            $book = Book::lockForUpdate()->findOrFail($dto->bookId);

            if ($book->stock <= 0) {
                throw new LoanDeniedException("Desculpe, este livro está esgotado no momento.");
            }

            $hasOverdue = Loan::where('user_id', $dto->userId)
                ->where('status', LoanStatus::OVERDUE)
                ->exists();

            if ($hasOverdue) {
                throw new LoanDeniedException("Empréstimo negado! Você possui livros em atraso pendentes de devolução.");
            }

            $alreadyHasBook = Loan::where('user_id', $dto->userId)
                ->where('book_id', $dto->bookId)
                ->whereIn('status', [LoanStatus::PENDING, LoanStatus::ACTIVE, LoanStatus::OVERDUE])
                ->exists();

            if ($alreadyHasBook) {
                throw new LoanDeniedException("Você já possui um pedido ou empréstimo em andamento deste mesmo livro.");
            }

            $loan = Loan::create([
                'user_id'   => $dto->userId,
                'book_id'   => $book->id,
                'loan_date' => null,
                'due_date'  => null,
                'status'    => LoanStatus::PENDING,
            ]);

            $book->decrement('stock');

            return $loan;
        });
    }

    public function confirmPickup(int $loanId): Loan
    {
        return DB::transaction(function () use ($loanId) {
            $loan = Loan::findOrFail($loanId);

            if ($loan->status !== LoanStatus::PENDING) {
                throw new LoanDeniedException("Este empréstimo não está aguardando retirada.");
            }

            $loan->update([
                'loan_date' => now(),
                'due_date'  => now()->addDays(30),
                'status'    => LoanStatus::ACTIVE
            ]);

            return $loan;
        });
    }

    public function returnBook(int $loanId): Loan
    {
        return DB::transaction(function () use ($loanId) {
            $loan = Loan::findOrFail($loanId);

            if ($loan->status === LoanStatus::RETURNED) {
                throw new LoanDeniedException("Este empréstimo já foi devolvido anteriormente.");
            }

            $loan->update([
                'return_date' => now(),
                'status'      => LoanStatus::RETURNED
            ]);

            $loan->book()->increment('stock');

            return $loan;
        });
    }

    public function cancelLoan(int $loanId): Loan
    {
        return DB::transaction(function () use ($loanId) {
            $loan = Loan::findOrFail($loanId);

            if ($loan->status !== LoanStatus::PENDING) {
                throw new LoanDeniedException("Não é possível cancelar um empréstimo que já foi retirado ou finalizado.");
            }

            $loan->update([
                'status' => LoanStatus::CANCELLED
            ]);

            $loan->book()->increment('stock');

            return $loan;
        });
    }
}
