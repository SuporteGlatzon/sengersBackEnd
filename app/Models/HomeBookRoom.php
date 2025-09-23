<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class HomeBookRoom extends BaseModel
{
    protected $fillable = [
        'title',
        'orange_text',
        'button_link',
        'button_text',
        'rooms',
        'description',
        'image',
        'status'
    ];

    protected $casts = [
        'rooms' => 'array',
        'status' => 'boolean',
    ];

    public function scopeStatus(Builder $query): void
    {
        $query->where('status', true);
    }
}
