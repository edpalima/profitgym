<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkoutGuideResource\Pages;
use App\Filament\Resources\WorkoutGuideResource\RelationManagers;
use App\Models\WorkoutGuide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class WorkoutGuideResource extends Resource
{
    protected static ?string $model = WorkoutGuide::class;
    protected static ?string $navigationGroup = 'Gym Content';
    protected static ?string $navigationLabel = 'Workout Guides';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Workout Guide Details')
                    ->description('Fill out the information below to create or update a workout guide.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),

                                FileUpload::make('featured_photo')
                                    ->label('Featured Photo')
                                    ->image()
                                    ->directory('workout-guides')
                                    ->required(),
                            ]),

                        RichEditor::make('description')
                            ->label('Description')
                            ->required()
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('Toggle to activate or deactivate this workout guide.')
                            ->default(true),
                    ])
                    ->columns(1)
                    ->collapsible(),

                TextInput::make('video_url')
                    ->label('Video URL')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_photo')
                    ->label('PHOTO')
                    ->size(50),
                TextColumn::make('title')->label('TITLE')->sortable()->searchable(),
                TextColumn::make('description')
                    ->label('DESCRIPTION')
                    ->formatStateUsing(fn($state) => Str::limit(strip_tags($state), 50))
                    ->tooltip(fn($record) => strip_tags($record->description)),
                ToggleColumn::make('is_active')->label('IS ACTIVE')->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkoutGuides::route('/'),
            'create' => Pages\CreateWorkoutGuide::route('/create'),
            'edit' => Pages\EditWorkoutGuide::route('/{record}/edit'),
        ];
    }
}
