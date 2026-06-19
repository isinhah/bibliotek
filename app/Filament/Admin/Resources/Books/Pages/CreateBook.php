<?php

namespace App\Filament\Admin\Resources\Books\Pages;

use App\Exceptions\BookAlreadyExistsException;
use App\Filament\Admin\Resources\Books\BookResource;
use App\Services\BookService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = app(BookService::class);

        try {
            return $service->create($data);
        } catch (BookAlreadyExistsException $e) {
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
