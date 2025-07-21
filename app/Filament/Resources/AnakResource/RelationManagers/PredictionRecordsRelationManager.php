<?php

namespace App\Filament\Resources\AnakResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;

class PredictionRecordsRelationManager extends RelationManager
{
    protected static string $relationship = 'predictionRecords';
    protected static ?string $recordTitleAttribute = 'status_stunting';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('status_stunting')
                    ->label('Stunting Status')
                    ->required()
                    ->maxLength(50),

                TextInput::make('status_underweight')
                    ->label('Underweight Status')
                    ->required()
                    ->maxLength(50),

                TextInput::make('status_wasting')
                    ->label('Wasting Status')
                    ->required()
                    ->maxLength(50),

                Textarea::make('recommendation')
                    ->label('Recommendation')
                    ->rows(4)
                    ->maxLength(65535),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status_stunting')
                    ->label('Stunting')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status_underweight')
                    ->label('Underweight')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status_wasting')
                    ->label('Wasting')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('recommendation')
                    ->label('Recommendation')
                    ->limit(50),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
