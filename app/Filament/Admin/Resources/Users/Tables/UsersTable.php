<?php

namespace App\Filament\Admin\Resources\Users\Tables;

use App\Exceptions\UserHasActiveLoansException;
use App\Services\UserService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),

                TextColumn::make('roles_display')
                    ->label('Permissão')
                    ->getStateUsing(fn ($record) => match ($record->getRoleNames()->first()) {
                        'admin' => 'Administrador',
                        'user'  => 'Leitor',
                        default => 'Não definido'
                    })
                    ->colors([
                        'danger' => fn ($state) => $state === 'Administrador',
                        'success' => fn ($state) => $state === 'Leitor',
                    ]),

                TextColumn::make('created_at')
                    ->label('Cadastrado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('name', 'asc')

            ->filters([
                SelectFilter::make('role')
                    ->label('Filtrar por Permissão')
                    ->options([
                        'admin' => 'Administradores',
                        'user' => 'Leitores',
                    ])
                    ->query(function ($query, array $data) {
                        if (!empty($data['value'])) {
                            $query->role($data['value']);
                        }
                    }),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])

            ->recordActions([
                EditAction::make(),
            ])
            ->actions([
                EditAction::make()
                    ->label('Editar')
                    ->tooltip('Editar Usuário')
                    ->icon('heroicon-o-pencil-square'),

                DeleteAction::make()
                    ->hidden(fn ($record) => $record->id === auth()->id())
                    ->label('Excluir')
                    ->tooltip('Excluir Usuário')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Excluir Usuário')
                    ->modalDescription('Tem certeza que deseja excluir o usuário?')
                    ->action(function ($record, $action) {
                        try {
                            app(UserService::class)->delete($record->id);
                            Notification::make()
                                ->title('Excluido com sucesso.')
                                ->success()
                                ->send();
                        } catch (UserHasActiveLoansException $e) {
                            Notification::make()
                                ->title('Não é possível excluir')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();

                            $action->cancel();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Erro inesperado')
                                ->body('Ocorreu um problema ao excluir o autor.')
                                ->danger()
                                ->send();

                            Log::error($e->getMessage());
                            $action->cancel();
                        }
                    }),
            ]);
    }
}
