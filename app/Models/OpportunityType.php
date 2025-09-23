<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class OpportunityType extends BaseModel
{
    protected $fillable = [
        'title',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeStatus(Builder $query): void
    {
        $query->where('status', true);
    }
}
