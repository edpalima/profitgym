<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Password;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Account';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('User Details')->schema([
                FileUpload::make('photo')
                    ->required()
                    ->image()
                    ->directory('user-photos')
                    ->maxSize(1024)
                    ->label('Photo')
                    ->nullable()
                    ->columnSpanFull(),
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
                    ->required()
                    ->maxLength(255)
                    ->label('Middle Name'),

                TextInput::make('address')
                    ->nullable()
                    ->required()
                    ->maxLength(255)
                    ->label('Address'),
                TextInput::make('phone_number')
                    ->nullable()
                    ->required()
                    ->maxLength(255)
                    ->label('Phone Number'),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->label('Email'),

                // Role
                Select::make('role')
                    ->options([
                        'ADMIN' => 'Admin',
                        'STAFF' => 'Staff',
                        'MEMBER' => 'Member',
                    ])
                    ->default('member')
                    ->required()
                    ->label('Role'),

                TextInput::make('password')
                    ->password()
                    ->required(fn($livewire) => $livewire instanceof CreateUser)
                    ->dehydrateStateUsing(fn($state) => !empty($state) ? Hash::make($state) : null) // Only hash if there's a value
                    ->dehydrated(fn($state) => !empty($state)) // Ignore the field if it's empty
                    ->visible(fn($livewire) => $livewire instanceof CreateUser) // Show only on create
                    ->rule(Password::default())
                    ->maxLength(255),
            ]),

            Section::make('User New Password')->schema([
                Forms\Components\TextInput::make('new_password')
                    ->nullable()
                    ->password()
                    ->dehydrateStateUsing(fn($state) => !empty($state) ? Hash::make($state) : null) // Only hash if there's a value
                    ->dehydrated(fn($state) => !empty($state)), // Ignore the field if it's empty

                Forms\Components\TextInput::make('new_password_confirmation')
                    ->password()
                    ->same('new_password')
                    ->requiredWith('new_password'),
            ])->visible(fn($livewire) => $livewire instanceof EditUser),
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
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count() ?: null;
    }
    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'primary';
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
