<?php

namespace App\Filament\Admin\Resources\Categories\Pages;

use App\Exceptions\CategoryAlreadyExistsException;
use App\Filament\Admin\Resources\Categories\CategoryResource;
use App\Services\CategoryService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

// Intercepta a criação do Filament e delega para o CategoryService
class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = app(CategoryService::class);

        try {
            $category = $service->create($data);

            if ($category->wasRecentlyCreated === false) {
                Notification::make()
                    ->title('Categoria restaurada!')
                    ->body('Esta categoria já existia nos registros desativados e foi reativada.')
                    ->warning()
                    ->send();
            }

            return $category;

        } catch (CategoryAlreadyExistsException $e) {
            Notification::make()
                ->title('Erro ao salvar')
                ->body($e->getMessage())
                ->danger()
                ->persistent()
                ->send();

            $this->halt();
        }
    }
}
