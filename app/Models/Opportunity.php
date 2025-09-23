<?php

namespace App\Models;

use App\Enums\OpportunitySituation;
use App\Observers\OpportunityObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Builder;
class Opportunity extends BaseModel
{

    const SITUATION_PENDING = 'pending';
    const SITUATION_APPROVED = 'approved';
    const SITUATION_NO_APPROVED = 'no_approved';
    const SITUATION_EXPIRED = 'expired';

    protected $fillable = [
        'user_id',
        'company',
        'state_id',
        'city_id',
        'title',
        'description',
        'full_description',
        'status',
        'date',
        'salary',
        'opportunity_type_id',
        'occupation_area_id',
        'situation',
        'expire_at',
        'expire_notification_at',
        'situation_description',
        'cnpj',
        'approved_by'
    ];

    protected $casts = [
        'status' => 'boolean',
        'expire_at' => 'datetime',
        'expire_notification_at' => 'datetime',
        'situation' => OpportunitySituation::class,
    ];

    protected static function booted(): void
    {
        Opportunity::observe(OpportunityObserver::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'user_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function candidates(): MorphToMany
    {
        return $this->morphedByMany(Client::class, 'opportunityable')->using(Opportunityable::class)->withPivot(['viewed_at']);
    }

    public function occupation_area(): BelongsTo
    {
        return $this->belongsTo(OccupationArea::class);
    }

    public function opportunity_type(): BelongsTo
    {
        return $this->belongsTo(OpportunityType::class, 'opportunity_type_id');
    }

    public function scopeStatus(Builder $query): void
    {
        $query->where('status', true);
    }

    public function scopeApproved(Builder $query): void
    {
        $query->where('situation', Opportunity::SITUATION_APPROVED);
    }
}
