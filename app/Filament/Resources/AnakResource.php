<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Anak;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AnakResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\AnakResource\RelationManagers\PredictionRecordsRelationManager;
use App\Filament\Resources\AnakResource\RelationManagers\AntropometryRecordsRelationManager;

class AnakResource extends Resource
{
    protected static ?string $model = Anak::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';
    protected static ?string $pluralLabel = "Data Anak";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Anak')
                    ->schema([
                        Select::make('user_id')
                            ->label('Parent')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required(),

                        TextInput::make('name')
                            ->label('Child Name')
                            ->required()
                            ->maxLength(255),

                        Select::make('gender')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required(),

                        DatePicker::make('birth_date')
                            ->label('Birth Date')
                            ->required(),

                        TextInput::make('region')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('father_edu')
                            ->label('Father Education')
                            ->nullable()
                            ->maxLength(255),

                        TextInput::make('mother_edu')
                            ->label('Mother Education')
                            ->nullable()
                            ->maxLength(255),
                    ]),

                Section::make('Catatan Antropometri')
                    ->schema([
                        Repeater::make('antropometryRecords')
                            ->relationship('antropometryRecords')
                            ->label('Anthropometry Records')
                            ->addActionLabel('Tambah Pengukuran')
                            ->addActionAlignment(Alignment::Start)
                            ->columns(2)
                            ->collapsible()
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('age_in_month')
                                    ->label('Umur (bulan)')
                                    ->numeric()
                                    ->required(),

                                TextInput::make('weight')
                                    ->label('Berat (kg)')
                                    ->numeric()
                                    ->required(),

                                TextInput::make('height')
                                    ->label('Tinggi (cm)')
                                    ->numeric()
                                    ->required(),

                                TextInput::make('vitamin_a_count')
                                    ->label('Jumlah Vitamin A')
                                    ->numeric(),

                                TextInput::make('head_circumference')
                                    ->label('Lingkar Kepala (cm)')
                                    ->numeric(),

                                TextInput::make('upper_arm_circumference')
                                    ->label('Lingkar Lengan Atas (cm)')
                                    ->numeric(),
                            ])->itemLabel(fn(array $state): ?string => isset($state['age_in_month']) ? 'Prediksi Umur-' . $state['age_in_month'] : null),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Parent'),
                TextColumn::make('name')->label('Child Name'),
                TextColumn::make('gender'),
                TextColumn::make('birth_date')->label('Birth Date')->date(),
                TextColumn::make('region'),
                TextColumn::make('father_edu')->label('Father Education'),
                TextColumn::make('mother_edu')->label('Mother Education'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            AntropometryRecordsRelationManager::class,
            PredictionRecordsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnaks::route('/'),
            // 'create' => Pages\CreateAnak::route('/create'),
            // 'view' => Pages\ViewAnak::route('/{record}'),
            // 'edit' => Pages\EditAnak::route('/{record}/edit'),
        ];
    }
}
