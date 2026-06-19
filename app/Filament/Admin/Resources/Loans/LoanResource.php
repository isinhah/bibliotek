<?php

namespace App\Filament\Admin\Resources\Loans;

use App\Filament\Admin\Resources\Loans\Pages\CreateLoan;
use App\Filament\Admin\Resources\Loans\Pages\EditLoan;
use App\Filament\Admin\Resources\Loans\Pages\ListLoans;
use App\Filament\Admin\Resources\Loans\Schemas\LoanForm;
use App\Filament\Admin\Resources\Loans\Tables\LoansTable;
use App\Models\Loan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $slug = 'loans';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookmark;

    protected static ?string $modelLabel = 'Empréstimo';
    protected static ?string $pluralModelLabel = 'Empréstimos';

    protected static string|UnitEnum|null $navigationGroup = 'Movimentações';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return LoanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LoansTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLoans::route('/'),
            'edit' => EditLoan::route('/{record}/edit'),
        ];
    }
}
