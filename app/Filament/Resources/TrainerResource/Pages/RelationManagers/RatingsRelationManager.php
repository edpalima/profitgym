<?php

namespace App\Filament\Resources\TrainerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RatingsRelationManager extends RelationManager
{
    protected static string $relationship = 'ratings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->disabled(),

                Forms\Components\Select::make('rating')
                    ->options([
                        1 => '1 Star',
                        2 => '2 Stars',
                        3 => '3 Stars', 
                        4 => '4 Stars',
                        5 => '5 Stars',
                    ])
                    ->required()
                    ->disabled(),

                Forms\Components\Textarea::make('feedback')
                    ->maxLength(500)
                    ->columnSpanFull()
                    ->disabled(),

                Forms\Components\Toggle::make('recommend')
                    ->label('Would recommend?')
                    ->required()
                    ->disabled(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                //Tables\Columns\TextColumn::make('user.name')
                    //->label('User')
                    //->sortable(),
                    
                Tables\Columns\TextColumn::make('rating')
                    ->badge()
                    ->color(fn (int $state): string => match ($state) {
                        1 => 'danger',
                        2 => 'danger',
                        3 => 'warning',
                        4 => 'success',
                        5 => 'success',
                    })
                    ->formatStateUsing(fn (int $state): string => "$state " . str('star')->plural($state)),
                    
                Tables\Columns\TextColumn::make('feedback')
                    ->label('Feedback')
                    ->wrap()
                    ->words(20)
                    ->tooltip(function ($column) {
                        $state = $column->getState();
                        if (str_word_count($state) > 20) {
                            return $state;
                        }
                        return null;
                    }),
                    
                Tables\Columns\IconColumn::make('recommend')
                    ->label('Recommended')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // No CreateAction here - creation is disabled
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // Correct non-static method to prevent creation
    public function canCreate(): bool
    {
        return false;
    }
}