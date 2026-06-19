<?php

namespace App\Filament\Admin\Resources\Loans\Schemas;

use App\Enums\LoanStatus;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LoanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Gerenciamento de Empréstimo')
                    ->description('Altere o status da situação da reserva se necessário.')
                    ->schema([
                        Select::make('status')
                            ->label('Situação / Status')
                            ->options([
                                LoanStatus::PENDING->value => 'Aguardando Retirada',
                                LoanStatus::ACTIVE->value => 'Emprestado',
                                LoanStatus::RETURNED->value => 'Devolvido',
                                LoanStatus::OVERDUE->value => 'Atrasado',
                                LoanStatus::CANCELLED->value => 'Cancelado',
                            ])
                            ->required()
                            ->native(false)
                    ])
            ]);
    }
}
