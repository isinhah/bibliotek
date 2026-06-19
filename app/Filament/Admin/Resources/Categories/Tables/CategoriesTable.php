<?php

namespace App\Filament\Admin\Resources\Categories\Tables;

use App\Exceptions\CategoryHasBooksException;
use App\Services\CategoryService;
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

// Estruturar a listagem
class CategoriesTable
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
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('books_count')
                    ->label('Livros Cadastrados')
                    ->counts('books')
                    ->sortable(),
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
                EditAction::make()
                    ->label('Editar')
                    ->tooltip('Editar Categoria')
                    ->icon('heroicon-o-pencil-square'),

                DeleteAction::make()
                    ->label('Excluir')
                    ->tooltip('Excluir Categoria')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Excluir Categoria')
                    ->modalDescription('Tem certeza que deseja excluir a categoria?')
                    ->visible(fn ($record) => !$record->trashed())
                    ->action(function ($record, $action) {
                        try {
                            app(CategoryService::class)->delete($record->id);
                            Notification::make()
                                ->title('Excluido com sucesso.')
                                ->success()
                                ->send();
                        } catch (CategoryHasBooksException $e) {
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
