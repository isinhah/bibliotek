<?php

namespace App\Filament\Admin\Resources\Books\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações do Livro')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título do Livro')
                            ->placeholder('Ex: O Senhor dos Anéis, Dom Casmurro')
                            ->required()
                            ->string()
                            ->maxLength(255)
                            ->unique(
                                table: 'books',
                                column: 'title',
                                ignoreRecord: true,
                                modifyRuleUsing: fn($rule) => $rule->whereNull('deleted_at')
                            )
                            ->validationMessages([
                                'required' => 'O título do livro é obrigatório.',
                                'max' => 'O título não pode ter mais de 255 caracteres.',
                                'unique' => 'Este livro já está cadastrado na biblioteca.',
                            ]),

                        TextInput::make('isbn')
                            ->label('ISBN')
                            ->placeholder('Deixe em branco para gerar automaticamente')
                            ->nullable()
                            ->string()
                            ->maxLength(50),

                        Select::make('author_id')
                            ->label('Autor')
                            ->relationship(
                                name: 'author', // nome do método na classe Book que chama o Author
                                titleAttribute: 'name'
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->validationMessages([
                                'required' => 'Selecione um autor.',
                            ]),

                        Select::make('category_id')
                            ->label('Categoria')
                            ->relationship(
                                name: 'category',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->whereNull('deleted_at')
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->validationMessages([
                                'required' => 'Selecione uma categoria.',
                            ]),

                        TextInput::make('stock')
                            ->label('Quantidade em Estoque')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->minValue(0)
                            ->validationMessages([
                                'required' => 'Informe a quantidade em estoque',
                                'numeric' => 'O estoque deve ser um número inteiro',
                                'min' => 'O estoque não deve ser negativo'
                            ]),
                    ])
            ]);
    }
}
