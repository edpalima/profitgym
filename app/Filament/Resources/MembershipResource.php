<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembershipResource\Pages;
use App\Filament\Resources\MembershipResource\RelationManagers;
use App\Models\Membership;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\NumberInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MembershipResource extends Resource
{
    protected static ?string $model = Membership::class;

    protected static ?string $navigationGroup = 'Membership Management';
    protected static ?string $navigationLabel = 'Memberships';
    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([ // Name
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                // Price
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('₱')
                    ->label('Price'),

                TextInput::make('duration_value')
                    ->numeric()
                    ->required()
                    ->label('Duration')
                    ->reactive(),

                Select::make('duration_unit')
                    ->options([
                        'days' => 'Days',
                        'weeks' => 'Weeks',
                        'months' => 'Months',
                        'years' => 'Years',
                    ])
                    ->default('days')
                    ->reactive()
                    ->label('Duration Unit'),

                // Description
                Textarea::make('description')
                    ->nullable()
                    ->required()
                    ->maxLength(1000)
                    ->columnSpan('full'),

                // Is Active
                Toggle::make('walk_in_only')
                    ->default(true)
                    ->required()
                    ->label('Walk In Only'),

                // Is Active
                Toggle::make('is_active')
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(true)
                    ->required()
                    ->label('Is Active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('NAME')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('duration_unit')->label('DURATION UNIT')->sortable(),
                Tables\Columns\TextColumn::make('duration_value')->label('DURATION VALUE')->sortable(),
                Tables\Columns\TextColumn::make('price')->label('PRICE')->money('PHP')->sortable(),
                Tables\Columns\TextColumn::make('is_active')->label('IS ACTIVE')->sortable()->formatStateUsing(fn($state) => $state ? 'Yes' : 'No'),
                Tables\Columns\TextColumn::make('walk_in_only')->label('WALK IN ONLY')->sortable()->formatStateUsing(fn($state) => $state ? 'Yes' : 'No'),
                Tables\Columns\TextColumn::make('created_at')->label('CREATED AT')->dateTime('Y-m-d H:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('UPDATED AT')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMemberships::route('/'),
            'create' => Pages\CreateMembership::route('/create'),
            'edit' => Pages\EditMembership::route('/{record}/edit'),
        ];
    }
}
