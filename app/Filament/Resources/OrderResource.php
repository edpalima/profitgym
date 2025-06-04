<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationGroup = 'Orders';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Orders';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Order Information')
                ->schema([
                    Grid::make(3)
                        ->schema([
                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'PENDING' => 'PENDING',
                                    'FOR PICKUP' => 'FOR PICKUP',
                                    'COMPLETED' => 'COMPLETED',
                                    'REJECTED' => 'REJECTED',
                                ])
                                ->required(),    
                            Select::make('user_id')
                                ->disabled()
                                ->label('User')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->required(),

                            TextInput::make('total_amount')
                                ->label('Total Amount')
                                ->numeric()
                                ->required()
                                ->disabled(),
                        ]),

                    Grid::make(3)
                    
                        ->schema([
                            Placeholder::make('id')
                                ->label('Order ID')
                                ->content(fn($record) => $record->id ?? '-'),

                            Placeholder::make('created_at')
                                ->label('Created At')
                                ->content(fn($record) => $record->created_at?->format('Y-m-d H:i:s') ?? '-'),
                        ]),
                ]),

            Section::make('Order Items')
                // ->collapsible()
                ->schema([
                    Repeater::make('orderItems')
                        ->label('Order Items')
                        ->relationship('orderItems') // hasMany relationship
                        ->schema([
                            Grid::make(3)->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->label('Product')
                                    ->required(),
                                TextInput::make('quantity')
                                    ->numeric()
                                    ->label('Quantity')
                                    ->required(),
                                TextInput::make('price')
                                    ->numeric()
                                    ->label('Price')
                                    ->required(),
                            ]),
                        ])
                        ->defaultItems(1)
                        ->maxItems(1),
                ]),

            Section::make('Payments')
                ->collapsible()
                ->schema([
                    Repeater::make('payments')
                        ->label('Payment Records')
                        ->relationship('payments')
                        ->schema([
                            Grid::make(5)->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->disk('public')
                                    ->directory('payments')
                                    ->disabled(fn($get) => $get('image') !== null)
                                    ->image()
                                    ->imagePreviewHeight('250')
                                    ->downloadable()
                                    ->openable()
                                    ->label('Payment Image'),
                                Select::make('payment_method')
                                    ->label('Payment Method')
                                    ->options([
                                        'GCASH' => 'GCash',
                                        'OVER_THE_COUNTER' => 'Over the Counter',
                                    ])
                                    ->required(),

                                TextInput::make('reference_no')
                                    ->label('Reference No.'),

                                TextInput::make('amount')
                                    ->label('Amount')
                                    ->numeric()
                                    ->required(),

                                Select::make('status')
                                    ->label('Payment Status')
                                    ->options([
                                        'PENDING' => 'PENDING',
                                        'CONFIRMED' => 'CONFIRMED',
                                        'REJECTED' => 'REJECTED',
                                    ])
                                    ->default('PENDING')
                                    ->required(),
                            ]),
                        ])
                        ->maxItems(1)
                        ->defaultItems(1),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //TextColumn::make('id')->label('Order ID')->sortable(),
                TextColumn::make('user.name')->label('USER')->sortable()->searchable(),
                TextColumn::make('total_amount')->label('TOTAL AMOUNT')->money('PHP')->sortable(),
                TextColumn::make('status')
                     ->label('STATUS')
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'PENDING' => 'warning',
                        'FOR PICKUP' => 'info',
                        'COMPLETED' => 'success',
                        'REJECTED' => 'danger',
                        default => 'secondary',
                    }),
                TextColumn::make('created_at')->label('DATE')->dateTime('M d, Y h:i A')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('UPDATED AT')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
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
                    ->url(route('print.all.data.orders'))
                    ->openUrlInNewTab(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // If you want to add relation managers for payments, etc., do that here
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
