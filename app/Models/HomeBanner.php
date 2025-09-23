<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class HomeBanner extends BaseModel
{

    protected $fillable = [
        'title',
        'image',
        'subtitle',
        'button_link',
        'button_text',
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
