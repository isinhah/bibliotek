<?php

namespace App\Filament\Admin\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

// Campo visual que o administrador vai interagir
class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações da Categoria')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome da Categoria')
                        ->placeholder('Ex: Romance, Ficção Científica, Terror')

                        ->required()
                        ->string()
                        ->maxLength(100)

                        ->unique(
                            table: 'categories',
                            column: 'name',
                            ignoreRecord: true,
                            modifyRuleUsing: fn ($rule) => $rule->whereNull('deleted_at')
                        )

                        ->validationMessages([
                            'required' => 'O campo nome não pode estar vazio.',
                            'string'   => 'O campo nome deve ser um texto válido.',
                            'max'      => 'O campo nome não pode ter mais de 100 caracteres.',
                            'unique'   => 'Essa categoria já existe na nossa biblioteca.',
                        ])
                ])
            ]);
    }
}
