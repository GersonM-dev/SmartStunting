<?php

namespace App\Filament\Resources\AntropometryRecordResource\Pages;

use App\Filament\Resources\AntropometryRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAntropometryRecords extends ListRecords
{
    protected static string $resource = AntropometryRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
