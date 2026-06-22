<?php

namespace App\Filament\Admin\Resources\Books\Tables;

use App\Exceptions\BookHasActiveLoansException;
use App\Services\BookService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;

class BooksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                ->label('ID')
                ->sortable()
                ->searchable(),

                ImageColumn::make('cover_id')
                    ->label('Capa')
                    ->defaultImageUrl(fn ($record) => 'https://covers.openlibrary.org/b/id/' . $record->cover_id . '-M.jpg'),

                TextColumn::make('title')
                ->label('Título do Livro')
                ->searchable()
                ->sortable()
                ->wrap(),

                TextColumn::make('author.name')
                    ->label('Autor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('isbn')
                    ->label('ISBN / Chave')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('stock')
                    ->label('Estoque')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label('Cadastrado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('title', 'asc')
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Filtrar por Categoria')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('author_id')
                    ->label('Filtrar por Autor')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->actions([
                EditAction::make()
                    ->label('Editar')
                    ->tooltip('Editar Livro')
                    ->icon('heroicon-o-pencil-square'),

                DeleteAction::make()
                    ->label('Excluir')
                    ->tooltip('Excluir Livro')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Excluir Livro')
                    ->modalDescription('Tem certeza que deseja excluir o livro?')
                    ->visible(fn ($record) => !$record->trashed())
                    ->action(function ($record, $action) {
                        try {
                            app(BookService::class)->delete($record->id);
                            Notification::make()
                                ->title('Excluido com sucesso.')
                                ->success()
                                ->send();
                        } catch (BookHasActiveLoansException $e) {
                            Notification::make()
                                ->title('Não é possível remover este livro')
                                ->body($e->getMessage())
                                ->danger()
                                ->persistent()
                                ->send();

                            $action->cancel();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Erro inesperado')
                                ->body('Ocorreu um problema ao excluir o livro.')
                                ->danger()
                                ->send();

                            Log::error($e->getMessage());
                            $action->cancel();
                        }
                    }),
            ]);
    }
}
