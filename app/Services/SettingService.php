<?php

namespace App\Services;

use App\Http\Resources\SettingResource;
use App\Models\Setting;

class SettingService
{
    public function index()
    {
        return SettingResource::collection(Setting::whereIn('key', [
            'terms_of_use',
            'privacy_policy',
            'address',
            'email',
            'phone',
            'terms_of_opportunity'
        ])->get());
    }
}
