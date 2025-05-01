<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserMembershipResource\Pages;
use App\Filament\Resources\UserMembershipResource\RelationManagers;
use App\Models\Membership;
use App\Models\User;
use App\Models\UserMembership;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Closure;

class UserMembershipResource extends Resource
{
    protected static ?string $model = UserMembership::class;
    protected static ?string $navigationGroup = 'Membership Management';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Enrolled Memberships';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Membership Information')
                ->schema([
                    Grid::make(3)
                        ->schema([
                            Placeholder::make('user_id')
                                ->label('User')
                                ->content(fn($record) => optional($record->user)->full_name ?? '-'),

                            Placeholder::make('membership_id')
                                ->label('Membership')
                                ->content(fn($record) => optional($record->membership)->name ?? '-'),

                            Placeholder::make('created_at')
                                ->label('Date Submitted')
                                ->content(fn($record) => $record->created_at->format('Y-m-d H:i:s') ?? '-'),
                        ]),

                    Grid::make(3)
                        ->schema([
                            DatePicker::make('start_date')->required(),
                            DatePicker::make('end_date')->required(),
                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'PENDING' => 'PENDING',
                                    'APPROVED' => 'APPROVED',
                                    'REJECTED' => 'REJECTED',
                                ])
                                ->rules([
                                    fn(callable $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                        $payments = $get('payments') ?? [];

                                        if ($value === 'APPROVED' && !collect($payments)->contains('status', 'CONFIRMED')) {
                                            $fail('Membership can only be approved if there is a confirmed payment.');
                                        }
                                    },
                                ]),
                        ]),
                ]),

            Section::make('Payments')
                ->collapsible()
                ->schema([
                    Repeater::make('payments')
                        ->label('Payment Records')
                        ->relationship('payments') // morphMany handled automatically
                        ->schema([
                            Grid::make(4)->schema([
                                Select::make('payment_method')
                                    ->label('Payment Method')
                                    ->options([
                                        'GCASH' => 'Gcash',
                                        'OVER_THE_COUNTER' => 'Over the Counter',
                                    ])
                                    ->required(),

                                TextInput::make('reference_no')
                                    ->label('Reference No.')
                                    ->required(),

                                TextInput::make('amount')
                                    ->numeric()
                                    ->label('Amount')
                                    ->required(),
                                Select::make('status')
                                    ->options([
                                        'PENDING' => 'PENDING',
                                        'CONFIRMED' => 'CONFIRMED',
                                        'REJECTED' => 'REJECTED',
                                    ])
                                    ->default('PENDING')
                                    ->label('Payment Status')
                                    ->required(),

                                // Optional: uncomment if you want to allow payment date input
                                // DatePicker::make('payment_date')
                                //     ->label('Date Paid')
                                //     ->required(),
                            ]),
                        ])
                        ->maxItems(1)
                        ->defaultItems(1),
                ]),

            Toggle::make('is_active')
                ->label('Is Active')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.id')->label('Id')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('membership.name')->label('Membership'),
                TextColumn::make('start_date')->date(),
                TextColumn::make('end_date')->date(),
                TextColumn::make('status'),
                TextColumn::make('is_active'),
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
            'index' => Pages\ListUserMemberships::route('/'),
            'create' => Pages\CreateUserMembership::route('/create'),
            'edit' => Pages\EditUserMembership::route('/{record}/edit'),
        ];
    }
}
