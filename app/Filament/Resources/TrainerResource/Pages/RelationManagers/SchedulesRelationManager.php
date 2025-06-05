<?php

namespace App\Filament\Resources\TrainerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('day')
                    ->options([
                        'Monday' => 'Monday',
                        'Tuesday' => 'Tuesday',
                        'Wednesday' => 'Wednesday',
                        'Thursday' => 'Thursday',
                        'Friday' => 'Friday',
                        'Saturday' => 'Saturday',
                        'Sunday' => 'Sunday',
                    ])
                    ->required(),

Forms\Components\Select::make('start_time')
    ->options([
        '06:00' => '6:00 AM',
        '07:00' => '7:00 AM',
        '08:00' => '8:00 AM',
        '09:00' => '9:00 AM',
        '10:00' => '10:00 AM',
        '11:00' => '11:00 AM',
        '12:00' => '12:00 PM',
        '13:00' => '1:00 PM',
        '14:00' => '2:00 PM',
        '15:00' => '3:00 PM',
        '16:00' => '4:00 PM',
        '17:00' => '5:00 PM',
        '18:00' => '6:00 PM',
        '19:00' => '7:00 PM',
        '20:00' => '8:00 PM',
    ])
    ->required()
    ->native(false),

Forms\Components\Select::make('end_time')
    ->options([
        '07:00' => '7:00 AM',
        '08:00' => '8:00 AM',
        '09:00' => '9:00 AM',
        '10:00' => '10:00 AM',
        '11:00' => '11:00 AM',
        '12:00' => '12:00 PM',
        '13:00' => '1:00 PM',
        '14:00' => '2:00 PM',
        '15:00' => '3:00 PM',
        '16:00' => '4:00 PM',
        '17:00' => '5:00 PM',
        '18:00' => '6:00 PM',
        '19:00' => '7:00 PM',
        '20:00' => '8:00 PM',
        '21:00' => '9:00 PM',
    ])
    ->required()
    ->native(false),

                Forms\Components\Select::make('class_type')
                    ->options([
                        'Strength_training' => 'Strength Training',
                        'Cardio' => 'Cardio',
                        'Yoga' => 'Yoga',
                        'Pilates' => 'Pilates',
                        'Crossfit' => 'CrossFit',
                        'Weightlifting' => 'Weightlifting',
                        'Bodybuilding' => 'Bodybuilding',
                        'Functional_fitness' => 'Functional Fitness',
                        'Rehab' => 'Rehabilitation',
                    ])
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('availability')
                    ->options([
                        'Available' => 'Available',
                        'Limited' => 'Limited',
                        'Booked' => 'Booked',
                    ])
                    ->default('Available')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('day'),
                Tables\Columns\TextColumn::make('start_time')
                    ->time(),
                Tables\Columns\TextColumn::make('end_time')
                    ->time(),
                Tables\Columns\TextColumn::make('class_type'),
                Tables\Columns\TextColumn::make('availability')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Available' => 'success',
                        'Limited' => 'warning',
                        'Booked' => 'danger',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}