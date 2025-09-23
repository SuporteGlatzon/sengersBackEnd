<?php

use Illuminate\Support\Facades\Storage;

function __asset($url)
{
    if ($url) {
        return asset(Storage::disk(config('filament.default_filesystem_disk'))->url($url));
    }
}
