<?php

namespace App\Filament\Admin\Resources\Authors\Pages;

use App\Exceptions\AuthorAlreadyExistsException;
use App\Filament\Admin\Resources\Authors\AuthorResource;
use App\Services\AuthorService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAuthor extends CreateRecord
{
    protected static string $resource = AuthorResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = app(AuthorService::class);

        try {
            $author = $service->create($data);

            if ($author->wasRecentlyCreated === false) {
                Notification::make()
                    ->title('Autor restaurado!')
                    ->body('Este autor já existia nos registros desativados e foi reativado.')
                    ->warning()
                    ->send();
            }

            return $author;

        } catch (AuthorAlreadyExistsException $e) {
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
