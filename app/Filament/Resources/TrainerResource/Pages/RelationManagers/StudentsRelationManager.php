<?php

namespace App\Filament\Resources\TrainerResource\RelationManagers;

use App\Models\TrainerStudent;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Student')
                    ->options(function (callable $get) {
                        // Get the current trainer's ID
                        $trainerId = $this->ownerRecord->id;

                        // Get user IDs already assigned to this trainer
                        $assignedUserIds = TrainerStudent::where('trainer_id', $trainerId)
                            ->pluck('user_id');

                        // Get users with role MEMBER not already assigned
                        return User::where('role', User::ROLE_MEMBER)
                            ->whereNotIn('id', $assignedUserIds)
                            ->get()
                            ->mapWithKeys(fn($user) => [
                                $user->id => "{$user->first_name} {$user->last_name}",
                            ])
                            ->toArray();
                    })
                    ->searchable()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('No students')
            ->emptyStateDescription('Create a student to get started.')
            ->columns([
                Tables\Columns\TextColumn::make('user_id')->label('Student Name')
                    ->getStateUsing(fn($record) => $record->user->name ?? 'N/A')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('New Student'),
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
