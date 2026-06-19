<?php

namespace App\Filament\Admin\Resources\Categories\Pages;

use App\Filament\Admin\Resources\Categories\CategoryResource;
use App\Services\BookService;
use App\Models\Category;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),

            Action::make('importBooks')
                ->label('Importar Livros')
                ->color('success')

                ->requiresConfirmation()
                ->modalHeading('Importar Livros via Open Library')
                ->modalDescription('Escolha a categoria e a quantidade de livros que deseja buscar na API externa.')
                ->modalSubmitActionLabel('Iniciar Importação')

                ->form([
                    Select::make('category_id')
                        ->label('Selecione a Categoria')
                        ->options(Category::query()->pluck('name', 'id'))
                        ->required()
                        ->searchable(),

                    TextInput::make('limit')
                        ->label('Quantidade Limite de Livros')
                        ->numeric()
                        ->default(10)
                        ->required()
                        ->minValue(1)
                        ->maxValue(50),
                ])

                ->action(function (array $data) {
                    try {
                        $categoryId = (int) $data['category_id'];
                        $limit = (int) $data['limit'];

                        $importedCount = app(BookService::class)->importBooksFromApi($categoryId, $limit);

                        Notification::make()
                            ->title('Sincronização realizada!')
                            ->body("A importação foi concluída com sucesso. {$importedCount} novos livros cadastrados.")
                            ->success()
                            ->send();

                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Erro ao conectar na API')
                            ->body($e->getMessage())
                            ->danger()
                            ->persistent()
                            ->send();
                    }
                }),
        ];
    }
}
