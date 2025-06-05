<?php

namespace App\Filament\Resources;

use App\Models\TermsPolicy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class TermsPolicyResource extends Resource
{
    protected static ?string $model = TermsPolicy::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Gym Content';

    protected static ?string $modelLabel = 'Terms & Conditions';

    protected static ?string $navigationLabel = 'Terms & Conditions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Terms and Conditions Content')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->default('Terms and Conditions'),
                            
                        RichEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Last Updated'),
                    
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->isLatest()),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
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
            'index' => \App\Filament\Resources\TermsPolicyResource\Pages\ListTermsPolicies::route('/'),
            'create' => \App\Filament\Resources\TermsPolicyResource\Pages\CreateTermsPolicy::route('/create'),
            'edit' => \App\Filament\Resources\TermsPolicyResource\Pages\EditTermsPolicy::route('/{record}/edit'),
        ];
    }
}