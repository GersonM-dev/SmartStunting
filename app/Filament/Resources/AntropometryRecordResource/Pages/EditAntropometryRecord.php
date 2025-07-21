<?php

namespace App\Filament\Resources\AntropometryRecordResource\Pages;

use App\Filament\Resources\AntropometryRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAntropometryRecord extends EditRecord
{
    protected static string $resource = AntropometryRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
