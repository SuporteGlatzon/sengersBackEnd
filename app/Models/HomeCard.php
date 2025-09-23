<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class HomeCard extends BaseModel
{
    protected $fillable = [
        'title',
        'call',
        'subtitle',
        'button_text',
        'link',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeStatus(Builder $query): void
    {
        $query->where('status', true);
    }
}
