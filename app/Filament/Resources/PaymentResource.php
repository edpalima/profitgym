<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{TextInput, Select, DatePicker, FileUpload};
use Filament\Resources\Resource;
use Filament\Tables\Columns\{TextColumn, BadgeColumn, ImageColumn};
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;
    protected static ?string $navigationGroup = 'Payments';
    protected static ?string $navigationLabel = 'Payments';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->options([
                        'user_memberships' => 'User Membership',
                        'orders' => 'Orders',
                    ])
                    ->required(),

                TextInput::make('type_id')
                    ->numeric()
                    ->required(),

                TextInput::make('amount')
                    ->numeric()
                    ->required(),

                Select::make('payment_method')
                    ->options([
                        'OVER_THE_COUNTER' => 'Over the Counter',
                        'GCASH' => 'GCash',
                    ])
                    ->required(),

                Select::make('status')
                    ->options([
                        'PENDING' => 'PENDING',
                        'CONFIRMED' => 'CONFIRMED',
                        'REJECTED' => 'REJECTED',
                    ])
                    ->default('PENDING')
                    ->label('Payment Status')
                    ->required(),

                DatePicker::make('payment_date'),

                FileUpload::make('image')
                    ->directory('payments')
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')->sortable()->searchable(),
                TextColumn::make('type_id'),
                TextColumn::make('amount')->money(),
                TextColumn::make('payment_method'),
                TextColumn::make('status')
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'PENDING' => 'warning',
                        'CONFIRMED' => 'success',
                        'REJECTED' => 'danger',
                        default => 'secondary',
                    }),
                TextColumn::make('payment_date')->date(),
                ImageColumn::make('image')->disk('public')->circular(),
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
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Payment Status')
                    ->options([
                        'PENDING' => 'PENDING',
                        'CONFIRMED' => 'CONFIRMED',
                        'REJECTED' => 'REJECTED',
                    ]),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
