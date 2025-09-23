<?php

namespace App\Filament\Resources\HomeCardResource\Pages;

use App\Filament\Resources\HomeCardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomeCards extends ListRecords
{
    protected static string $resource = HomeCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
