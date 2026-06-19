<?php

namespace App\Filament\Admin\Resources\Authors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações do Autor')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome do Autor')
                            ->placeholder('Ex: William Shakespeare, J.K Rowling')

                            ->required()
                            ->string()
                            ->maxLength(100)

                            ->unique(
                                table: 'authors',
                                column: 'name',
                                ignoreRecord: true,
                                modifyRuleUsing: fn ($rule) => $rule->whereNull('deleted_at')
                            )

                            ->validationMessages([
                                'required' => 'O campo nome não pode estar vazio.',
                                'string'   => 'O campo nome deve ser um texto válido.',
                                'max'      => 'O campo nome não pode ter mais de 100 caracteres.',
                                'unique'   => 'Esse autor já existe na nossa biblioteca.',
                            ])
                    ])
            ]);
    }
}
