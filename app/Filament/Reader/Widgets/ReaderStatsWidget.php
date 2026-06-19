<?php

namespace App\Filament\Reader\Widgets;

use App\Enums\LoanStatus;
use App\Models\Loan;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReaderStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $userId = auth()->id();

        return [
            Stat::make('Lendo Atualmente', Loan::where('user_id', $userId)->where('status', LoanStatus::ACTIVE->value)->count())
                ->description('Livros com você agora')
                ->icon('heroicon-m-book-open')
                ->color('success'),

            Stat::make('Livros Lidos', Loan::where('user_id', $userId)->where('status', LoanStatus::RETURNED->value)->count())
                ->description('Histórico de leitura')
                ->icon('heroicon-m-check-badge')
                ->color('primary'),

            Stat::make('Aguardando Retirada', Loan::where('user_id', $userId)->where('status', LoanStatus::PENDING->value)->count())
                ->description('Separados na biblioteca')
                ->icon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
