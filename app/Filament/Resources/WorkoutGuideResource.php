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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->required()
                    ->rows(3),

                TextInput::make('video_url')
                    ->nullable()
                    ->maxLength(255),

                Select::make('trainer_id')
                    ->label('Trainer')
                    ->options(function () {
                        return \App\Models\Trainer::all()->pluck('first_name', 'id');
                    })
                    ->required(),

                Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('trainer.first_name')->label('Trainer')->sortable(),
                ToggleColumn::make('is_active')->sortable(),
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
            'index' => Pages\ListWorkoutGuides::route('/'),
            'create' => Pages\CreateWorkoutGuide::route('/create'),
            'edit' => Pages\EditWorkoutGuide::route('/{record}/edit'),
        ];
    }
}
