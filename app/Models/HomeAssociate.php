<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
class HomeAssociate extends BaseModel
{
    protected $fillable = [
        'title',
        'orange_text',
        'subtitle',
        'title_right',
        'button_link',
        'button_text',
        'advantages',
        'description',
        'image',
        'status'
    ];

    protected $casts = [
        'advantages' => 'array',
        'status' => 'boolean',
    ];

    public function scopeStatus(Builder $query): void
    {
        $query->where('status', true);
    }
}
