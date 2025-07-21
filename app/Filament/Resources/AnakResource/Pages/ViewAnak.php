<?php

namespace App\Filament\Resources\AnakResource\Pages;

use App\Filament\Resources\AnakResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAnak extends ViewRecord
{
    protected static string $resource = AnakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
