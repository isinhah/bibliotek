<?php

namespace Database\Seeders;

use App\Enums\LoanStatus;
use App\Models\User;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'leitor@leitor.com')->first();

        if (!$user) {
            $this->command->error('Usuário leitor@leitor.com não encontrado.');
            return;
        }

        $books = Book::inRandomOrder()->take(6)->get();

        if ($books->isEmpty()) {
            $this->command->error('Nenhum livro encontrado no banco.');
            return;
        }

        Loan::firstOrCreate([
            'user_id' => $user->id,
            'book_id' => $books->get(0)->id,
            'status'  => LoanStatus::ACTIVE,
        ], [
            'loan_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(14),
            'return_date' => null,
        ]);

        if ($books->has(1)) {
            Loan::firstOrCreate([
                'user_id' => $user->id,
                'book_id' => $books->get(1)->id,
                'status'  => LoanStatus::RETURNED,
            ], [
                'loan_date' => Carbon::now()->subDays(20),
                'due_date' => Carbon::now()->subDays(6),
                'return_date' => Carbon::now()->subDays(7),
            ]);
        }

        if ($books->has(2)) {
            Loan::firstOrCreate([
                'user_id' => $user->id,
                'book_id' => $books->get(2)->id,
                'status'  => LoanStatus::RETURNED,
            ], [
                'loan_date' => Carbon::create(2026, 2, 10, 14, 0, 0),
                'due_date' => Carbon::create(2026, 2, 24, 14, 0, 0),
                'return_date' => Carbon::create(2026, 2, 22, 10, 0, 0),
                'created_at' => Carbon::create(2026, 2, 10, 14, 0, 0),
            ]);
        }

        if ($books->has(3)) {
            Loan::firstOrCreate([
                'user_id' => $user->id,
                'book_id' => $books->get(3)->id,
                'status'  => LoanStatus::RETURNED,
            ], [
                'loan_date' => Carbon::create(2026, 3, 15, 11, 30, 0),
                'due_date' => Carbon::create(2026, 3, 29, 11, 30, 0),
                'return_date' => Carbon::create(2026, 3, 28, 16, 0, 0),
                'created_at' => Carbon::create(2026, 3, 15, 11, 30, 0),
            ]);
        }

        if ($books->has(4)) {
            Loan::firstOrCreate([
                'user_id' => $user->id,
                'book_id' => $books->get(4)->id,
                'status'  => LoanStatus::RETURNED,
            ], [
                'loan_date' => Carbon::create(2026, 4, 5, 9, 15, 0),
                'due_date' => Carbon::create(2026, 4, 19, 9, 15, 0),
                'return_date' => Carbon::create(2026, 4, 18, 14, 0, 0),
                'created_at' => Carbon::create(2026, 4, 5, 9, 15, 0),
            ]);
        }

        if ($books->has(5)) {
            Loan::firstOrCreate([
                'user_id' => $user->id,
                'book_id' => $books->get(5)->id,
                'status'  => LoanStatus::RETURNED,
            ], [
                'loan_date' => Carbon::create(2026, 5, 22, 16, 45, 0),
                'due_date' => Carbon::create(2026, 6, 5, 16, 45, 0),
                'return_date' => Carbon::create(2026, 6, 2, 11, 0, 0),
                'created_at' => Carbon::create(2026, 5, 22, 16, 45, 0),
            ]);
        }

        if ($books->has(6)) {
            Loan::firstOrCreate([
                'user_id' => $user->id,
                'book_id' => $books->get(5)->id,
                'status'  => LoanStatus::RETURNED,
            ], [
                'loan_date' => Carbon::create(2026, 3, 15, 11, 30, 0),
                'due_date' => Carbon::create(2026, 3, 29, 11, 30, 0),
                'return_date' => Carbon::create(2026, 3, 28, 16, 0, 0),
                'created_at' => Carbon::create(2026, 3, 15, 11, 30, 0),
            ]);
        }

        if ($books->has(7)) {
            Loan::firstOrCreate([
                'user_id' => $user->id,
                'book_id' => $books->get(5)->id,
                'status'  => LoanStatus::RETURNED,
            ], [
                'loan_date' => Carbon::create(2026, 3, 15, 11, 30, 0),
                'due_date' => Carbon::create(2026, 3, 29, 11, 30, 0),
                'return_date' => Carbon::create(2026, 3, 28, 16, 0, 0),
                'created_at' => Carbon::create(2026, 3, 15, 11, 30, 0),
            ]);
        }
    }
}
