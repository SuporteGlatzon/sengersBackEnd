<?php

namespace App\Filament\Resources\HomeBookRoomResource\Pages;

use App\Filament\Resources\HomeBookRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomeBookRooms extends ListRecords
{
    protected static string $resource = HomeBookRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
