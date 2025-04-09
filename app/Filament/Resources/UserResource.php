<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('first_name')
                ->required()
                ->maxLength(255)
                ->label('First Name'),
            TextInput::make('last_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Last Name'),
            TextInput::make('middle_name')
                    ->nullable()
                    ->maxLength(255)
                    ->label('Middle Name'),

            TextInput::make('address')
                    ->nullable()
                    ->maxLength(255)
                    ->label('Address'),
            TextInput::make('phone_number')
                    ->nullable()
                    ->maxLength(255)
                    ->label('Phone Number'),

            TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->label('Email'),
            TextInput::make('password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->maxLength(255)
                    ->label('Password')
                    ->default(fn () => \Str::random(16)),

                // Role
            Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'member' => 'Member',
                    ])
                    ->default('member')
                    ->required()
                    ->label('Role'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('last_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('role')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('Y-m-d H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
