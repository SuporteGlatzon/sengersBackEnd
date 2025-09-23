<?php

namespace App\Filament\Resources;

use Rmsramos\Activitylog\Resources\ActivitylogResource as BaseActivitylogResource;
use Illuminate\Support\Facades\Auth;

class CustomActivitylogResource extends BaseActivitylogResource
{
    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user && ($user->role_id === 1); // Allow only role_id 1
    }
}
