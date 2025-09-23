<?php

namespace App\Filament\Resources\OpportunityResource\Pages;

use App\Filament\Resources\OpportunityResource;
use App\Models\Opportunity;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListOpportunities extends ListRecords
{
    protected static string $resource = OpportunityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make(__('All')),
            __('Pending') => Tab::make()->query(fn ($query) => $query->where('situation', Opportunity::SITUATION_PENDING)),
            __('No approved') => Tab::make()->query(fn ($query) => $query->where('situation', Opportunity::SITUATION_NO_APPROVED)),
            __('Approved') => Tab::make()->query(fn ($query) => $query->where('situation', Opportunity::SITUATION_APPROVED)),
            __('Expired') => Tab::make()->query(fn ($query) => $query->where('situation', Opportunity::SITUATION_EXPIRED)),
        ];
    }
}
