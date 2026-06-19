<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações do Usuário')
                    ->description('Cadastre ou edite os dados de acesso do usuário.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome Completo')
                            ->required()
                            ->string()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(table: 'users', column: 'email', ignoreRecord: true),


                        TextInput::make('password')
                            ->label('Senha')
                            ->password()

                            ->required(fn ($livewire) => $livewire instanceof CreateRecord)
                            ->nullable(fn ($livewire) => !($livewire instanceof CreateRecord))
                            ->string()
                            ->minLength(6)

                            ->validationMessages([
                                'required' => 'O campo senha é obrigatório.',
                                'string'   => 'A senha deve ser um texto válido.',
                                'min'      => 'A senha deve ter pelo menos 6 caracteres.',
                            ])

                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->placeholder(fn ($livewire) => $livewire instanceof CreateRecord ? '' : 'Deixe em branco para manter a senha atual'),

                        Select::make('roles')
                        ->label('Nível de Permissão')
                            ->options([
                                'admin' => 'Administrador',
                                'user'  => 'Leitor',
                            ])
                            ->required()

                            ->loadStateFromRelationshipsUsing(function ($component, $record) {
                                $component->state($record->getRoleNames()->first()); // pega a primeira role ativa dele
                            })

                            ->saveRelationshipsUsing(function ($record, $state) {
                                $record->syncRoles([$state]);
                            })
                    ])
            ]);
    }
}
