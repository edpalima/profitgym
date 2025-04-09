<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserMembershipResource\Pages;
use App\Filament\Resources\UserMembershipResource\RelationManagers;
use App\Models\Membership;
use App\Models\User;
use App\Models\UserMembership;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserMembershipResource extends Resource
{
    protected static ?string $model = UserMembership::class;
    protected static ?string $navigationGroup = 'Membership Management';
    protected static ?string $navigationLabel = 'Applied Memberships';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('user_id')
                ->label('User')
                ->options(User::query()->get()->mapWithKeys(function ($user) {
                    return [$user->id => $user->first_name . ' ' . $user->last_name];
                }))
                ->searchable()
                ->required(),

            Select::make('membership_id')
                ->label('Membership')
                ->options(Membership::pluck('name', 'id'))
                ->searchable()
                ->required(),

            // DatePicker::make('start_date')->required(),
            // DatePicker::make('end_date')->required(),

            Select::make('status')
                ->options([
                    'active' => 'Active',
                    'expired' => 'Expired',
                    'cancelled' => 'Cancelled',
                ])
                ->required(),

            Toggle::make('is_active')
                ->label('Is Active')
                ->default(true),

            // TextInput::make('payment_id')
            //     ->label('Payment ID')
            //     ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User'),
                TextColumn::make('membership.name')->label('Membership'),
                TextColumn::make('start_date')->date(),
                TextColumn::make('end_date')->date(),
                TextColumn::make('status'),
                TextColumn::make('is_active'),
                TextColumn::make('payment_id'),
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
            'index' => Pages\ListUserMemberships::route('/'),
            'create' => Pages\CreateUserMembership::route('/create'),
            'edit' => Pages\EditUserMembership::route('/{record}/edit'),
        ];
    }
}
