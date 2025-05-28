<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainerResource\Pages;
use App\Filament\Resources\TrainerResource\RelationManagers;
use App\Models\Trainer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\{TextInput, Textarea, FileUpload, Section, Select, Toggle};
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
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Personal Information')
                ->description('Basic identity details for the trainer.')
                ->schema([
                    TextInput::make('first_name')
                        ->label('First Name')
                        ->required()
                        ->maxLength(100),

                    TextInput::make('middle_name')
                        ->label('Middle Name')
                        ->maxLength(100),

                    TextInput::make('last_name')
                        ->label('Last Name')
                        ->required()
                        ->maxLength(100),
                ])
                ->columns(3),

            Section::make('Professional Info')
                ->description('Specialization and image for trainer profile.')
                ->schema([
                    Select::make('specialization')
                        ->label('Specialization')
                        ->required()
                        ->options([
                            'strength_training' => 'Strength Training',
                            'cardio' => 'Cardio',
                            'yoga' => 'Yoga',
                            'pilates' => 'Pilates',
                            'crossfit' => 'CrossFit',
                            'weightlifting' => 'Weightlifting',
                            'bodybuilding' => 'Bodybuilding',
                            'functional_fitness' => 'Functional Fitness',
                            'rehab' => 'Rehabilitation',
                        ])
                        ->searchable()
                        ->preload()
                        ->placeholder('Select specialization'),

                    FileUpload::make('image')
                        ->label('Profile Image')
                        ->image()
                        ->imagePreviewHeight('150')
                        ->directory('trainers'),
                ])
                ->columns(2),

            Section::make('Contact Details')
                ->description('Phone number and email address.')
                ->schema([
                    TextInput::make('phone')
                        ->label('Phone')
                        ->tel()
                        ->maxLength(20),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(150),
                ])
                ->columns(2),

            Section::make('About')
                ->description('A short description and full bio.')
                ->schema([
                    Textarea::make('description')
                        ->label('Short Description')
                        ->rows(3)
                        ->maxLength(500),

                    Textarea::make('bio')
                        ->label('Biography')
                        ->rows(6)
                        ->maxLength(1000),
                ]),

            Toggle::make('is_active')
                ->default(true),
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
            'index' => Pages\ListTrainers::route('/'),
            'create' => Pages\CreateTrainer::route('/create'),
            'edit' => Pages\EditTrainer::route('/{record}/edit'),
        ];
    }
}
