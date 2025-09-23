<?php

namespace App\Services;

use App\Http\Resources\ProfileResource;
use App\Http\Resources\OpportunityResource;
use App\Http\Resources\ProfileOpportunityResource;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;


class ProfileService
{
    public function index()
    {
        return new ProfileResource(Client::find(request()->user()->id));
    }

    public function showOpportunity($request, $opportunity_id)
    {
        $client = Client::find($request->user()->id);
        $opportunity = $client->opportunities()->find($opportunity_id);

        return $opportunity ? new ProfileOpportunityResource($opportunity) : null;
    }

    public function showOpportunityApplied($request, $opportunity_id)
    {
        $client = Client::find($request->user()->id);
        $opportunity = $client->candidates()->find($opportunity_id);

        return $opportunity ? new OpportunityResource($opportunity) : null;
    }

    public function update($request)
    {
        \Illuminate\Support\Facades\Log::info('Dados recebidos no update Profile', $request->all());

        $client = Client::find($request->user()->id);
        $data = $request->except(['email', 'avatar']);

        if ($request->input('delete_curriculum') === '1') {
            if ($client->curriculum && Storage::disk('public')->exists($client->curriculum)) {
                Storage::disk('public')->delete($client->curriculum);
            }
            $data['curriculum'] = null;
        }

        foreach ($request->allFiles() as $field => $file) {
            if ($file->isValid()) {
                if ($client->$field && Storage::disk('public')->exists($client->$field)) {
                    Storage::disk('public')->delete($client->$field);
                }

                $path = $file->store('profile', 'public');

                \Illuminate\Support\Facades\Log::info("Arquivo {$field} armazenado em: {$path}");

                $data[$field] = $path;
            }
        }

        if (! $request->hasFile('curriculum') && $request->input('delete_curriculum') !== '1') {
            unset($data['curriculum']);
        }

        $client->update($data);

        return response()->json(['message' => 'Perfil atualizado com sucesso.'], 200);
    }
}
