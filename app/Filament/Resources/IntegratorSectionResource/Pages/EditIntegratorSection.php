<?php

namespace App\Filament\Resources\IntegratorSectionResource\Pages;

use App\Filament\Resources\IntegratorSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIntegratorSection extends EditRecord
{
    protected static string $resource = IntegratorSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
