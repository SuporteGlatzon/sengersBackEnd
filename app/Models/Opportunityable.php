<?php

namespace App\Models;

use App\Observers\OpportunityableObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Opportunityable extends MorphPivot
{
    protected $table = 'opportunityables';
    protected static function booted(): void
    {
        Opportunityable::observe(OpportunityableObserver::class);
    }

    public function opportunity(): BelongsTo
    {
        return $this->belongsTo(Opportunity::class);
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'opportunityable_id');
    }
}
