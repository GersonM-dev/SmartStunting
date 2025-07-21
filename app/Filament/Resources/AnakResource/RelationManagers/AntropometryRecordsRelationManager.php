<?php

namespace App\Filament\Resources\AnakResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;

class AntropometryRecordsRelationManager extends RelationManager
{
    protected static string $relationship = 'antropometryRecords';
    // Use a human‑friendly field here if you like:
    protected static ?string $recordTitleAttribute = 'age_in_month';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('age_in_month')->label('Age (months)')->numeric()->required(),
                TextInput::make('weight')->numeric()->required(),
                TextInput::make('height')->numeric()->required(),
                TextInput::make('vitamin_a_count')->label('Vit A Count')->numeric(),
                TextInput::make('head_circumference')->numeric(),
                TextInput::make('upper_arm_circumference')->label('Upper Arm Circumference')->numeric(),
            ]);
    }
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('age_in_month')->label('Age (m)'),
                TextColumn::make('weight'),
                TextColumn::make('height'),
                TextColumn::make('vitamin_a_count')->label('Vit A'),
                TextColumn::make('head_circumference')->label('Head C.'),
                TextColumn::make('upper_arm_circumference')->label('Upper Arm C.'),
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
