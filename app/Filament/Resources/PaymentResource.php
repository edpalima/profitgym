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
                        'user_membership' => 'User Membership',
                        'products' => 'Products',
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
                        'over_the_counter' => 'Over the Counter',
                        'gcash' => 'GCash',
                    ])
                    ->required(),

                TextInput::make('status')
                    ->default('pending'),

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
                TextColumn::make('type')->sortable()->searchable(),
                TextColumn::make('type_id'),
                TextColumn::make('amount')->money(),
                TextColumn::make('payment_method'),
                TextColumn::make('status')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'completed' => 'success',
                        'failed' => 'danger',
                        default => 'secondary',
                    }),
                TextColumn::make('payment_date')->date(),
                ImageColumn::make('image')->disk('public')->circular(),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
