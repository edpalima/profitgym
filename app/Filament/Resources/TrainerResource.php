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
                ImageColumn::make('image')->label('')->circular(),
                TextColumn::make('first_name')->label('FIRST NAME')->sortable()->searchable(),
                TextColumn::make('last_name')->label('LAST NAME')->sortable()->searchable(),
                TextColumn::make('specialization')->label('SPECIALIZATION')->sortable()->searchable(),
                TextColumn::make('schedules_count')
                    ->label('Schedules')
                    ->counts('schedules')
                    ->badge(),
                TextColumn::make('ratings_avg_rating')
                    ->label('Avg Rating')
                    ->avg('ratings', 'rating')
                    ->formatStateUsing(fn ($state): string => number_format($state, 1) . ' ★'),
                TextColumn::make('feedback_count')
                    ->label('Feedback Count')
                    ->state(function (Trainer $record) {
                        return $record->ratings()->whereNotNull('feedback')->count();
                    })
                    ->badge()
                    ->color(function ($state) {
                        return match (true) {
                            $state == 0 => 'danger',       // No feedback
                            $state <= 5 => 'warning',      // 1-5 feedbacks
                            $state <= 20 => 'info',        // 6-20 feedbacks
                            default => 'success',          // 21+ feedbacks
                        };
                    })
                    ->formatStateUsing(function ($state) {
                        return match (true) {
                            $state == 0 => 'No feedback',
                            $state == 1 => '1 feedback',
                            default => "{$state} feedbacks",
                        };
                    }),
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
            RelationManagers\SchedulesRelationManager::class,
            RelationManagers\RatingsRelationManager::class,
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