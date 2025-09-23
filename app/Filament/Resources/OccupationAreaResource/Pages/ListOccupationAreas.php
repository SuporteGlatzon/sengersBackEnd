<?php

namespace App\Filament\Resources\OccupationAreaResource\Pages;

use App\Filament\Resources\OccupationAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOccupationAreas extends ListRecords
{
    protected static string $resource = OccupationAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
