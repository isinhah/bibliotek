<?php

namespace App\Filament\Admin\Resources\Loans\Tables;

use App\Enums\LoanStatus;
use App\Models\Loan;
use App\Services\LoanService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LoansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Leitor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('book.title')
                    ->label('Livro')
                    ->weight('bold')
                    ->searchable()
                    ->limit(35),

                TextColumn::make('status')
                    ->label('Situação')
                    ->badge()
                    ->color(fn (LoanStatus $state): string => match ($state) {
                        LoanStatus::PENDING => 'warning',
                        LoanStatus::ACTIVE => 'success',
                        LoanStatus::RETURNED => 'gray',
                        LoanStatus::OVERDUE, LoanStatus::CANCELLED => 'danger',
                    })
                    ->formatStateUsing(fn (LoanStatus $state): string => match ($state) {
                        LoanStatus::PENDING => 'Aguardando Retirada',
                        LoanStatus::ACTIVE => 'Emprestado',
                        LoanStatus::RETURNED => 'Devolvido',
                        LoanStatus::OVERDUE => 'Atrasado',
                        LoanStatus::CANCELLED => 'Cancelado',
                    }),

                TextColumn::make('loan_date')
                    ->label('Retirada')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('due_date')
                    ->label('Prazo')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn (Loan $record) => $record->status === LoanStatus::OVERDUE ? 'danger' : null)
                    ->description(fn (Loan $record) =>
                    $record->status === LoanStatus::ACTIVE ? $record->due_date->diffForHumans() : ''
                    ),

                TextColumn::make('return_date')
                    ->label('Devolução')
                    ->date('d/m/Y')
                    ->placeholder('--')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Action::make('confirmPickup')
                    ->label('Confirmar Retirada')
                    ->tooltip('Confirmar Retirada')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar Retirada')
                    ->modalDescription('O leitor veio retirar o livro?')
                    ->visible(fn ($record) => $record->status === LoanStatus::PENDING)
                    ->action(function ($record) {
                        try {
                            app(LoanService::class)->confirmPickup($record->id);
                            Notification::make()->title('Livro entregue!')->success()->send();
                        } catch (\Exception $e) {
                            Notification::make()->title('Erro')->body($e->getMessage())->danger()->send();
                        }
                    }),

                Action::make('returnBook')
                    ->label('Confirmar Recebimento')
                    ->tooltip('Receber Livro')
                    ->icon('heroicon-o-arrow-left-on-rectangle')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar Recebimento')
                    ->modalDescription('Confirmar devolução para o estoque?')
                    ->visible(fn ($record) => in_array($record->status, [LoanStatus::ACTIVE, LoanStatus::OVERDUE]))
                    ->action(function ($record) {
                        try {
                            app(LoanService::class)->returnBook($record->id);
                            Notification::make()->title('Livro recebido!')->success()->send();
                        } catch (\Exception $e) {
                            Notification::make()->title('Erro')->body($e->getMessage())->danger()->send();
                        }
                    }),

                Action::make('cancelLoan')
                    ->label('Cancelar')
                    ->tooltip('Cancelar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Cancelar Empréstimo')
                    ->modalDescription('Tem certeza que deseja cancelar?')
                    ->visible(fn ($record) => $record->status === LoanStatus::PENDING)
                    ->action(function ($record) {
                        try {
                            app(LoanService::class)->cancelLoan($record->id);
                            Notification::make()->title('Cancelado com sucesso.')->success()->send();
                        } catch (\Exception $e) {
                            Notification::make()->title('Erro')->body($e->getMessage())->danger()->send();
                        }
                    }),
            ]);
    }
}
