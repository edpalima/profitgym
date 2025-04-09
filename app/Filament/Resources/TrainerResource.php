<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainerResource\Pages;
use App\Filament\Resources\TrainerResource\RelationManagers;
use App\Models\Trainer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\{TextInput, Textarea, FileUpload};
use Filament\Tables\Columns\{TextColumn, ImageColumn};
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrainerResource extends Resource
{
    protected static ?string $model = Trainer::class;
    protected static ?string $navigationGroup = 'Membership Management';
    protected static ?string $navigationLabel = 'Trainers';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('first_name')->required(),
            TextInput::make('middle_name'),
            TextInput::make('last_name')->required(),
            TextInput::make('specialization')->required(),
            Textarea::make('description'),
            Textarea::make('bio'),
            TextInput::make('phone'),
            TextInput::make('email')->email(),
            FileUpload::make('image')->image()->directory('trainers'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->circular(),
                TextColumn::make('first_name')->searchable(),
                TextColumn::make('last_name')->searchable(),
                TextColumn::make('specialization')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone'),
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
            'index' => Pages\ListTrainers::route('/'),
            'create' => Pages\CreateTrainer::route('/create'),
            'edit' => Pages\EditTrainer::route('/{record}/edit'),
        ];
    }
}
