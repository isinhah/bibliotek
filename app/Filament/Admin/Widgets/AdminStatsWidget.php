<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\LoanStatus;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pedidos Pendentes', Loan::where('status', LoanStatus::PENDING->value)->count())
                ->description('Aguardando separação')
                ->icon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Empréstimos Atrasados', Loan::where('status', LoanStatus::OVERDUE->value)->count())
                ->description('Passou do prazo')
                ->icon('heroicon-m-exclamation-triangle')
                ->color('danger'),

            Stat::make('Acervo Total', Book::count())
                ->description('Livros no sistema')
                ->icon('heroicon-m-book-open')
                ->color('success'),

            Stat::make('Leitores', User::role('user')->count())
                ->description('Usuários ativos')
                ->icon('heroicon-m-users')
                ->color('primary'),
        ];
    }
}
