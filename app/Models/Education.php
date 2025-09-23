<?php

namespace App\Models;

use App\Enums\CurrentSituation;

class Education extends BaseModel
{
    protected $table = 'educations';

    protected $fillable = [
        'institution',
        'course',
        'conclusion_at',
        'current_situation',
        'observation',
        'user_id'
    ];

    protected $casts = [
        'current_situation' => CurrentSituation::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
