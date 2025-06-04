<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\{TextInput, Textarea, Toggle, FileUpload, Select};
use Filament\Forms\Form;
use Filament\Tables\Columns\{TextColumn, BooleanColumn};
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationGroup = 'Products';
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            Select::make('category_id')
                ->relationship('category')
                ->getOptionLabelFromRecordUsing(fn(Category $record) => "{$record->name}")
                ->required(),

            Textarea::make('description')
                ->rows(3),

            TextInput::make('price')
                ->numeric()
                ->required(),

            FileUpload::make('image')
                ->label('Product Image')
                ->image()
                ->directory('products')
                ->imagePreviewHeight('150')
                ->maxSize(2048)
                ->nullable(),

            TextInput::make('stock_quantity')
                ->numeric()
                ->required(),

            Toggle::make('is_active')
                ->label('Active')
                ->default(true),

            Toggle::make('allows_preorder')
                ->label('Allow Preorders')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('NAME')->sortable()->searchable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('CATEGORY')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('price')->money('PHP')->label('PRICE'),
                TextColumn::make('stock_quantity')->label('STOCK')->sortable(),
                BooleanColumn::make('is_active')->label('IS ACTIVE'),
                TextColumn::make('created_at')->dateTime('M d, Y'),
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
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->options(
                        \App\Models\Category::all()->pluck('name', 'id')->toArray()
                    ),
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
                    ->url(route('print.all.data.products'))
                    ->openUrlInNewTab(),
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
