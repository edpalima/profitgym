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
                    ->disabled()
                    ->required(),

                TextInput::make('type_id')
                    ->numeric()
                    ->disabled()
                    ->required(),

                TextInput::make('amount')
                    ->numeric()
                    ->disabled()
                    ->required(),

                Select::make('payment_method')
                    ->options([
                        'OVER_THE_COUNTER' => 'Over the Counter',
                        'GCASH' => 'GCash',
                    ])
                    ->live()
                    ->disabled()
                    ->dehydrated(fn($get) => $get('payment_method') !== null)
                    ->required(),

                TextInput::make('reference_no')
                    ->integer()
                    ->maxLength(13)
                    ->live()
                    ->disabled(fn($get) => $get('payment_method') != 'GCASH')
                    ->required(fn($get) => $get('payment_method') == 'GCASH'),

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
                //TextColumn::make('id')
                    //->numeric()
                    //->searchable()
                    //->sortable(),

                //ADDITION - FOR SEARCHING
                TextColumn::make('customer_name')
                    ->label('CUSTOMER NAME')
                    ->searchable(query: function (Builder $query, string $search) {
                        $query->whereHas('typeable', function($q) use ($search) {
                            $q->whereHas('user', function($q) use ($search) {
                                $q->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhereRaw("first_name || ' ' || last_name LIKE ?", ["%{$search}%"]);
                            });
                        });
                    })
                    ->getStateUsing(fn($record) => $record->customer_name ?? '-'),
                TextColumn::make('type')->label('TYPE')->sortable()->searchable(),
                //TextColumn::make('type_id'),
                TextColumn::make('amount')->label('AMOUNT')->money('PHP', true),
                TextColumn::make('payment_method')->label('PAYMENT METHOD'),
                TextColumn::make('status')
                    ->label('STATUS')
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'PENDING' => 'warning',
                        'CONFIRMED' => 'success',
                        'REJECTED' => 'danger',
                        default => 'secondary',
                    }),
                TextColumn::make('payment_date')->label('PAYMENT DATE')->date(),
                ImageColumn::make('image')->disk('public')->label('IMAGE')->circular(),
                Tables\Columns\TextColumn::make('created_at')
                ->label('CREATED AT')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                ->label('UPDATED AT')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            //->defaultSort('id', 'desc')
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
                Tables\Actions\BulkAction::make('printAll')
                    ->label('Print All Data')
                    ->icon('heroicon-o-printer')
                    ->color('info')
                    ->deselectRecordsAfterCompletion()
                    ->url(route('print.all.data.payments'))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['typeable.user']);
    }
}
