<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\AntropometryRecord;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AntropometryRecordResource\Pages;
use App\Filament\Resources\AntropometryRecordResource\RelationManagers;
use App\Filament\Resources\AntropometryRecordResource\RelationManagers\PredictionRecordRelationManager;

class AntropometryRecordResource extends Resource
{
    protected static ?string $model = AntropometryRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),

                Forms\Components\Select::make('anak_id')
                    ->relationship('anak', 'name')
                    ->required(),

                Forms\Components\TextInput::make('age_in_month')
                    ->label('Age in Months')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('weight')
                    ->label('Weight (kg)')
                    ->numeric()
                    ->step(0.1)
                    ->required(),

                Forms\Components\TextInput::make('height')
                    ->label('Height (cm)')
                    ->numeric()
                    ->step(0.1)
                    ->required(),

                Forms\Components\TextInput::make('vitamin_a_count')
                    ->label('Vitamin A Count')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('head_circumference')
                    ->label('Head Circumference (cm)')
                    ->numeric()
                    ->step(0.1)
                    ->required(),

                Forms\Components\TextInput::make('upper_arm_circumference')
                    ->label('Upper Arm Circumference (cm)')
                    ->numeric()
                    ->step(0.1)
                    ->required(),

                Forms\Components\Section::make('Hasil Prediksi')
                    ->schema([
                        Forms\Components\TextInput::make('status_stunting')->label('Status Stunting')->required(),
                        Forms\Components\TextInput::make('status_underweight')->label('Status Underweight')->required(),
                        Forms\Components\TextInput::make('status_wasting')->label('Status Wasting')->required(),
                        Forms\Components\Textarea::make('recommendation')->label('Recommendation')->rows(3)->required(),
                    ])
                    ->relationship('predictionRecord')
                    ->collapsed()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('anak.name')
                    ->label('Child')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('age_in_month')
                    ->label('Age (months)')
                    ->sortable(),

                Tables\Columns\TextColumn::make('weight')
                    ->label('Weight (kg)')
                    ->sortable(),

                Tables\Columns\TextColumn::make('height')
                    ->label('Height (cm)')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            // PredictionRecordRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAntropometryRecords::route('/'),
            'create' => Pages\CreateAntropometryRecord::route('/create'),
            'edit' => Pages\EditAntropometryRecord::route('/{record}/edit'),
        ];
    }
}
