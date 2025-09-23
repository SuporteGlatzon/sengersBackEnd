<?php

namespace App\Observers;

use App\Models\Client;
use App\Models\Role;

class ClientObserver
{
    /**
     * Handle the Client "created" event.
     */
    public function creating(Client $client): void
    {
        $client->role_id = Role::CLIENT;
    }

    /**
     * Handle the Client "updated" event.
     */
    public function updated(Client $client): void
    {
        // ...
    }

    /**
     * Handle the Client "deleted" event.
     */
    public function deleted(Client $client): void
    {
        // ...
    }

    /**
     * Handle the Client "restored" event.
     */
    public function restored(Client $client): void
    {
        // ...
    }

    /**
     * Handle the Client "forceDeleted" event.
     */
    public function forceDeleted(Client $client): void
    {
        // ...
    }
}
