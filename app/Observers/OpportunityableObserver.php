<?php

namespace App\Observers;

use App\Models\Opportunityable;
use App\Notifications\AppliedForOpportunitySuccessfulNotification;
use App\Notifications\ClientAppliedForOpportunityNotification;

class OpportunityableObserver
{

    public function created(Opportunityable $opportunityable): void
    {
        $opportunity = $opportunityable->opportunity;
        $candidate = $opportunityable->candidate;

        $opportunity->client->notify(new ClientAppliedForOpportunityNotification($opportunity, $candidate));

        $candidate->notify(new AppliedForOpportunitySuccessfulNotification($opportunity));
    }
}
