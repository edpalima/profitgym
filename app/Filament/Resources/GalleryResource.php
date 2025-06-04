<?php

namespace App\Filament\Resources;

use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\{
    FileUpload,
    TextInput,
    Textarea,
    Toggle
};
use Filament\Tables\Columns\{
    ImageColumn,
    TextColumn,
    ToggleColumn
};
use App\Filament\Resources\GalleryResource\Pages;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationGroup = 'Gym Content';
    protected static ?string $navigationLabel = 'Galleries';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->maxLength(255)
                ->required(),

            FileUpload::make('image')
                ->image()
                ->required()
                ->directory('galleries'),

            RichEditor::make('description')
                ->columnSpanFull(),

            Toggle::make('is_active')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('IMAGE'),

                TextColumn::make('title')
                ->label('TITLE')
                    ->sortable()
                    ->searchable(),

                ToggleColumn::make('is_active')
                ->label('IS ACTIVE')
                    ->sortable(),
                TextColumn::make('created_at')
                ->label('CREATED AT')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
              TextColumn::make('updated_at')
              ->label('UPDATED AT')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit'   => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
