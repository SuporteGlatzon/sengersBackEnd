<?php

namespace App\Filament\Resources\OpportunityTypeResource\Pages;

use App\Filament\Resources\OpportunityTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOpportunityTypes extends ListRecords
{
    protected static string $resource = OpportunityTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
