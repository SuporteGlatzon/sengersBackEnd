<?php

namespace App\Filament\Resources\HomeAssociateResource\Pages;

use App\Filament\Resources\HomeAssociateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomeAssociate extends EditRecord
{
    protected static string $resource = HomeAssociateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
