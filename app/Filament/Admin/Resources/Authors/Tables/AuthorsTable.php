<?php

namespace App\Filament\Admin\Resources\Authors\Tables;

use App\Exceptions\AuthorHasBooksException;
use App\Services\AuthorService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;

class AuthorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Autor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('books_count')
                    ->label('Livros Cadastrados')
                    ->counts('books')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->label('Excluído em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name', 'asc')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->actions([
                Action::make('viewBooks')
                    ->label('Livros')
                    ->icon('heroicon-o-book-open')
                    ->color('success')
                    ->tooltip('Ver Livros')
                    ->url(fn ($record) => route('authors.books.index', $record->id))
                    ->openUrlInNewTab(),

                EditAction::make()
                    ->label('Editar')
                    ->tooltip('Editar Autor')
                    ->icon('heroicon-o-pencil-square'),

                DeleteAction::make()
                    ->label('Excluir')
                    ->tooltip('Excluir Autor')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Excluir Autor')
                    ->modalDescription('Tem certeza que deseja excluir o autor?')
                    ->visible(fn ($record) => !$record->trashed())
                    ->action(function ($record, $action) {
                        try {
                            app(AuthorService::class)->delete($record->id);
                            Notification::make()
                                ->title('Excluido com sucesso.')
                                ->success()
                                ->send();
                        } catch (AuthorHasBooksException $e) {
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
