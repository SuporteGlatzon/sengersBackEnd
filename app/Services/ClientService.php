<?php

namespace App\Services;

use App\Http\Resources\ClientResource;
use App\Models\Client;

class ClientService
{
    public function show($client_id)
    {
        $client = Client::where('user_type', 'client')->find($client_id);

        return $client ? new ClientResource($client) : null;
    }
}
