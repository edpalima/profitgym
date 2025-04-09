<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\{TextInput, Textarea, Toggle, FileUpload};
use Filament\Forms\Form;
use Filament\Tables\Columns\{TextColumn, BooleanColumn};
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationGroup = 'Products';
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            Textarea::make('description')
                ->rows(3),

            TextInput::make('price')
                ->numeric()
                ->required(),

            TextInput::make('stock_quantity')
                ->numeric()
                ->required(),

            Toggle::make('is_active')
                ->label('Active')
                ->default(true),
            FileUpload::make('image')
                ->label('Product Image')
                ->image()
                ->directory('products')
                ->imagePreviewHeight('150')
                ->maxSize(2048)
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('price')->money(),
                TextColumn::make('stock_quantity')->sortable(),
                BooleanColumn::make('is_active'),
                TextColumn::make('created_at')->dateTime('M d, Y'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
