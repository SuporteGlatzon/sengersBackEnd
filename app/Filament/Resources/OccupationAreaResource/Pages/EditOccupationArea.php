<?php

namespace App\Filament\Resources\OccupationAreaResource\Pages;

use App\Filament\Resources\OccupationAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOccupationArea extends EditRecord
{
    protected static string $resource = OccupationAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
