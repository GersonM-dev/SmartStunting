<?php

namespace App\Filament\Resources\AntropometryRecordResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PredictionRecordRelationManager extends RelationManager
{
    protected static string $relationship = 'predictionRecord';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status_stunting')->required(),
                Forms\Components\TextInput::make('status_underweight')->required(),
                Forms\Components\TextInput::make('status_wasting')->required(),
                Forms\Components\Textarea::make('recommendation')->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('status_stunting')->label('Status Stunting'),
                Tables\Columns\TextColumn::make('status_underweight')->label('Status Underweight'),
                Tables\Columns\TextColumn::make('status_wasting')->label('Status Wasting'),
                Tables\Columns\TextColumn::make('recommendation')->label('Recommendation'),
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
