<?php

namespace App\Filament\Admin\Resources\Books;

use App\Filament\Admin\Resources\Books\Pages\CreateBook;
use App\Filament\Admin\Resources\Books\Pages\EditBook;
use App\Filament\Admin\Resources\Books\Pages\ListBooks;
use App\Filament\Admin\Resources\Books\Schemas\BookForm;
use App\Filament\Admin\Resources\Books\Tables\BooksTable;
use App\Models\Book;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $slug = 'books';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static ?string $modelLabel = 'Livro';
    protected static ?string $pluralModelLabel = 'Livros';

    protected static string|UnitEnum|null $navigationGroup = 'Catálogo';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BookForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BooksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBooks::route('/'),
            'create' => CreateBook::route('/create'),
            'edit' => EditBook::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
