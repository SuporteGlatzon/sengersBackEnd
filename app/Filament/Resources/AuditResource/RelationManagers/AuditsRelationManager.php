<?php

namespace App\Filament\Resources\AuditResource\RelationManagers;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Rmsramos\Activitylog\ActivitylogPlugin;
use Rmsramos\Activitylog\RelationManagers\ActivitylogRelationManager;
use Rmsramos\Activitylog\Resources\ActivitylogResource;

class AuditsRelationManager extends ActivitylogRelationManager
{
    public function table(Table $table): Table
    {
        return ActivitylogResource::table(
            $table
                ->heading(ActivitylogPlugin::get()->getPluralLabel())
                ->actions([
                    ViewAction::make(),
                    DeleteAction::make()
                ])
                ->bulkActions([
                    BulkActionGroup::make([
                        DeleteBulkAction::make(),
                    ])
                ])
        );
    }
}
