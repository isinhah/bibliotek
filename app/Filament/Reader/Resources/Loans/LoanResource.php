<?php

namespace App\Filament\Reader\Resources\Loans;

use App\Enums\LoanStatus;
use App\Filament\Reader\Resources\Loans\Pages\ListLoans;
use App\Models\Loan;
use App\Services\LoanService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookmark;

    protected static ?string $modelLabel = 'Meu Empréstimo';
    protected static ?string $pluralModelLabel = 'Meus Livros';

    protected static string|UnitEnum|null $navigationGroup = 'Empréstimos';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('book.title')
                    ->label('Livro')
                    ->weight('bold')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('status')
                    ->label('Situação')
                    ->badge()
                    ->color(fn (LoanStatus $state): string => match ($state) {
                        LoanStatus::PENDING => 'warning',
                        LoanStatus::ACTIVE => 'success',
                        LoanStatus::RETURNED => 'gray',
                        LoanStatus::OVERDUE => 'danger',
                        LoanStatus::CANCELLED => 'danger',
                    })
                    ->formatStateUsing(fn (LoanStatus $state): string => match ($state) {
                        LoanStatus::PENDING => 'Aguardando Retirada',
                        LoanStatus::ACTIVE => 'Em Leitura',
                        LoanStatus::RETURNED => 'Devolvido',
                        LoanStatus::OVERDUE => 'Atrasado',
                        LoanStatus::CANCELLED => 'Cancelado',
                    }),

                TextColumn::make('due_date')
                    ->label('Prazo')
                    ->date('d/m/Y')

                    ->description(fn (Loan $record): string =>
                    $record->status === LoanStatus::ACTIVE ? 'Vence ' . $record->due_date->diffForHumans() : ''
                    )
                    ->placeholder('--'),

                TextColumn::make('return_date')
                    ->label('Data de Devolução')
                    ->date('d/m/Y')
                    ->placeholder('---'),
            ])
            ->actions([
                Action::make('cancelar_pedido')
                    ->label('Cancelar Pedido')
                    ->tooltip('Cancelar Pedido')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Cancelar Pedido')
                    ->modalDescription('Você tem certeza que deseja cancelar o seu pedido deste livro? Esta ação não poderá ser desfeita.')
                    ->modalSubmitActionLabel('Sim, cancelar pedido')
                    ->modalCancelActionLabel('Não')
                    ->visible(fn (Loan $record) => $record->status === LoanStatus::PENDING)
                    ->action(function (Loan $record) {
                        try {
                            app(LoanService::class)->cancelLoan($record->id);

                            Notification::make()
                                ->title('Pedido Cancelado')
                                ->body('Sua solicitação foi cancelada com sucesso.')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Ação Negada')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLoans::route('/'),
        ];
    }
}
