<?php

namespace App\Models;

use App\Models\Scopes\ClientScope;
use App\Observers\ClientObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Client extends User
{
    protected static function booted(): void
    {
        static::addGlobalScope(new ClientScope);

        Client::observe(ClientObserver::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class, 'user_id');
    }

    public function opportunities(): HasMany
    {
        return $this->hasMany(Opportunity::class, 'user_id');
    }

    public function candidates(): MorphToMany
    {
        return $this->morphToMany(Opportunity::class, 'opportunityable');
    }

    public function opportunities_applied(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Opportunity::class,
                'candidates',
                'client_id',
                'opportunity_id'
            );
    }
}
