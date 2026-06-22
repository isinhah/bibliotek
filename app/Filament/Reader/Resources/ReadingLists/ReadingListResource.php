<?php

namespace App\Filament\Reader\Resources\ReadingLists;

use App\Filament\Reader\Resources\ReadingLists\Pages\ManageReadingLists;
use App\Models\Book;
use App\Services\ReadingListService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class ReadingListResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookmark;

    protected static ?string $modelLabel = 'Livro Salvo';
    protected static ?string $pluralModelLabel = 'Ler mais tarde';

    protected static string|null|UnitEnum $navigationGroup = 'Minha Conta';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('usersWhoSaved', fn (Builder $query) => $query->where('user_id', auth()->id()));
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) =>
    $query->whereHas('usersWhoSaved', fn ($q) => $q->where('user_id', auth()->id()))
    )
        ->columns([
            TextColumn::make('title')
                ->label('Título')
                ->searchable()
                ->weight('bold'),

            TextColumn::make('author.name')
                ->label('Autor'),
        ])
        ->actions([
                Action::make('remove')
                    ->label('Remover da Lista')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(function (Book $record) {
                        app(ReadingListService::class)->removeBook($record->id);
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageReadingLists::route('/'),
        ];
    }
}
