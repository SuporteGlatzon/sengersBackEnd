<?php

namespace App\Filament\Resources\IntegratorSectionResource\Pages;

use App\Filament\Resources\IntegratorSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIntegratorSections extends ListRecords
{
    protected static string $resource = IntegratorSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
