<?php

namespace App\Observers;

use App\Models\Opportunity;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\OpportunityApprovedNotification;
use App\Notifications\OpportunityCreatedNotification;
use App\Notifications\OpportunityExpiredNotification;
use App\Notifications\OpportunityNoApprovedNotification;

class OpportunityObserver
{

    public function saving(Opportunity $opportunity): void
    {
        if ($opportunity->isDirty('situation')) {
            $opportunity->expire_at = null;

            if (optional($opportunity->situation)->value === Opportunity::SITUATION_APPROVED) {
                $days_expire_opportunity = Setting::where('key', 'days_expire_opportunity')->first();
                $addDays = $days_expire_opportunity ? $days_expire_opportunity->value : 30;

                $opportunity->expire_at = now()->addDays($addDays);
                $opportunity->expire_notification_at = null;
                $opportunity->approved_by = request()->user()->id;
            }
        }
    }
    /**
     * Handle the Opportunity "created" event.
     */
    public function creating(Opportunity $opportunity): void
    {
        $opportunity->situation = Opportunity::SITUATION_PENDING;
    }

    public function created(Opportunity $opportunity): void
    {
        User::whereIn('role_id', [Role::SUPERADMIN, Role::ADMIN] )->distinct('email')->get()->each(function ($user) use ($opportunity) { //Não sei quem fez... mas o role Admin esta com valor 2 que no manager do laravel mostra sendo o role de comunicação
            $user->notify(new OpportunityCreatedNotification($opportunity));
        });
    }


    public function updating(Opportunity $opportunity): void
    {
        if ($opportunity->isDirty('situation') && $opportunity->situation->value !== Opportunity::SITUATION_NO_APPROVED) {
            $opportunity->situation_description = null;
        }
    }

    /**
     * Handle the Opportunity "updated" event.
     */
    public function updated(Opportunity $opportunity): void
    {
        if ($opportunity->isDirty('situation')) {
            if ($opportunity->situation->value === Opportunity::SITUATION_APPROVED) {
                $opportunity->client->notify(new OpportunityApprovedNotification($opportunity));
            }

            if ($opportunity->situation->value === Opportunity::SITUATION_NO_APPROVED) {
                $opportunity->client->notify(new OpportunityNoApprovedNotification($opportunity));
            }

            if ($opportunity->situation->value === Opportunity::SITUATION_EXPIRED) {
                $opportunity->client->notify(new OpportunityExpiredNotification($opportunity));
            }
        }
    }

    /**
     * Handle the Opportunity "deleted" event.
     */
    public function deleted(Opportunity $opportunity): void
    {
        // ...
    }

    /**
     * Handle the Opportunity "restored" event.
     */
    public function restored(Opportunity $opportunity): void
    {
        // ...
    }

    /**
     * Handle the Opportunity "forceDeleted" event.
     */
    public function forceDeleted(Opportunity $opportunity): void
    {
        // ...
    }
}
