<?php

namespace App\Filament\Reader\Resources\ReadingLists\Pages;

use App\Filament\Reader\Resources\ReadingLists\ReadingListResource;
use Filament\Resources\Pages\ManageRecords;

class ManageReadingLists extends ManageRecords
{
    protected static string $resource = ReadingListResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
