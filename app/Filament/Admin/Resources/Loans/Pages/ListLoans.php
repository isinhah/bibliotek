<?php

namespace App\Filament\Admin\Resources\Loans\Pages;

use App\Filament\Admin\Resources\Loans\LoanResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListLoans extends ListRecords
{
    protected static string $resource = LoanResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Todos'),

            'pending' => Tab::make('Pendentes')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'PENDING')),

            'active' => Tab::make('Emprestados')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'ACTIVE')),

            'overdue' => Tab::make('Atrasados')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'OVERDUE')),

            'returned' => Tab::make('Devolvidos')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'RETURNED')),
        ];
    }
}
