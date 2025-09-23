<?php

namespace App\Filament\Pages;

use FilipFonal\FilamentLogManager\Pages\Logs as PagesLogs;

class Logs extends PagesLogs
{
    public static function canAccess(): bool
    {
        $user = request()->user();
        return $user && $user->role_id == 1;
    }
}
