<?php

namespace App\Services;

use App\Http\Resources\OpportunityResource;
use App\Http\Resources\ProfileOpportunityResource;
use App\Models\Client;
use App\Models\Opportunity;
use App\Models\Opportunityable;
use App\Models\Setting;
use App\Notifications\OpportunityViewedNotification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

class OpportunityService
{
    public function list()
    {
        return OpportunityResource::collection(
            Opportunity::orderBy('id', 'desc')->where(function ($query) {
                if ($state_id = request()->get('state_id')) {
                    $query->where('state_id', $state_id);
                }
                if ($city_id = request()->get('city_id')) {
                    $query->where('city_id', $city_id);
                }
                if ($occupation_area_id = request()->get('occupation_area_id')) {
                    $query->where('occupation_area_id', $occupation_area_id);
                }
                if ($opportunity_type_id = request()->get('opportunity_type_id')) {
                    $query->where('opportunity_type_id', $opportunity_type_id);
                }
                if ($search = request()->get('search')) {
                    $query->where(function ($query) use ($search) {
                        $query->whereRaw('UPPER(company) LIKE ?', ["%" . mb_strtoupper($search) . "%"]);
                        $query->whereRaw('UPPER(cnpj) LIKE ?', ["%" . mb_strtoupper($search) . "%"]);
                        $query->orWhereRaw('UPPER(title) LIKE ?', ["%" . mb_strtoupper($search) . "%"]);
                        $query->orWhereRaw('UPPER(description) LIKE ?', ["%" . mb_strtoupper($search) . "%"]);
                        $query->orWhereRaw('UPPER(full_description) LIKE ?', ["%" . mb_strtoupper($search) . "%"]);
                        $query->orWhereRaw('UPPER(salary) LIKE ?', ["%" . mb_strtoupper($search) . "%"]);

                        $query->orWhereHas('opportunity_type', function ($query) use ($search) {
                            $query->whereRaw('UPPER(title) LIKE ?', ["%" . mb_strtoupper($search) . "%"]);
                        });

                        $query->orWhereHas('occupation_area', function ($query) use ($search) {
                            $query->whereRaw('UPPER(title) LIKE ?', ["%" . mb_strtoupper($search) . "%"]);
                        });

                        $query->orWhereHas('state', function ($query) use ($search) {
                            $query->whereRaw('UPPER(title) LIKE ?', ["%" . mb_strtoupper($search) . "%"]);
                            $query->orWhereRaw('UPPER(letter) LIKE ?', ["%" . mb_strtoupper($search) . "%"]);
                        });

                        $query->orWhereHas('city', function ($query) use ($search) {
                            $query->whereRaw('UPPER(title) LIKE ?', ["%" . mb_strtoupper($search) . "%"]);
                        });
                    });
                }
            })->status()
                ->approved()->get()
        );
    }

    public function store($request)
    {
        $client = Client::find($request->user()->id);
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        return new OpportunityResource($client->opportunities()->create($data));
    }

    public function show($opportunity_id)
    {
        $opportunity = Opportunity::status()->approved()->find($opportunity_id);
        return $opportunity ? new ProfileOpportunityResource($opportunity) : null;
    }

    public function update($request, $id)
    {
        $client      = Client::find($request->user()->id);
        $opportunity = $client->opportunities()->findOrFail($id);

        $input = $request->only([
            'company',
            'title',
            'date',
            'salary',
            'description',
            'full_description',
            'state_id',
            'city_id',
            'opportunity_type_id',
            'occupation_area_id',
            'status'
        ]);

        if (isset($input['salary'])) {
            $valor            = intval($input['salary']);
            $input['salary']  = 'R$' . number_format($valor, 0, '.', '');
        }

        $newStatus     = filter_var($input['status'], FILTER_VALIDATE_BOOLEAN);
        $statusChanged = $newStatus !== $opportunity->status;

        $otherChanged = false;
        foreach (Arr::except($input, ['status']) as $field => $value) {
            if ($opportunity->$field != $value) {
                $otherChanged = true;
                break;
            }
        }

        $updates = [];
        if ($statusChanged) {
            $updates['status'] = $newStatus;
        }
        if ($otherChanged) {
            $updates['situation']   = Opportunity::SITUATION_PENDING;
            $updates['approved_by'] = null;
        }

        foreach ($input as $f => $v) {
            if (
                in_array($f, ['salary', 'company', 'title', 'date', 'description', 'full_description', 'state_id', 'city_id', 'opportunity_type_id', 'occupation_area_id'])
                && $opportunity->$f != $v
            ) {
                $updates[$f] = $v;
            }
        }

        if (empty($updates)) {
            return response()->json([
                'message'     => 'Nenhuma alteração detectada.',
                'opportunity' => $opportunity
            ], 200);
        }

        $opportunity->update($updates);

        if (
            isset($updates['situation'])
            && $updates['situation'] === Opportunity::SITUATION_PENDING
        ) {
            $admins = \App\Models\User::whereIn('role_id', [1, 2])->distinct('email')->get();
            foreach ($admins as $admin) {
                $admin->notify(
                    new \App\Notifications\OpportunityCreatedNotification($opportunity->toArray())
                );
            }
        }

        return response()->json([
            'message'     => 'Opportunity updated successfully',
            'opportunity' => $opportunity->fresh()
        ], 200);
    }


    public function delete($request, $id)
    {
        $client = Client::find($request->user()->id);
        return $client->opportunities()->findOrFail($id)->delete();
    }

    public function associate($opportunity_id)
    {
        $user_id = request()->user()->id;

        $opportunity = Opportunity::findOrFail($opportunity_id);

        if ($opportunity->client->id === $user_id) {
            throw ValidationException::withMessages([
                'user' => ['the owner of the opportunity cannot join'],
            ]);
        }

        $oportunidadeJaVinculada = Opportunityable::where('opportunity_id', $opportunity_id)
            ->where('opportunityable_type', 'App\Models\Client')
            ->where('opportunityable_id', $user_id)
            ->exists(); // retorna true ou false
        if (!$oportunidadeJaVinculada) {
            if ($opportunity->client->id === $user_id) {
                throw ValidationException::withMessages([
                    'user' => ['the owner of the opportunity cannot join'],
                ]);
            }
            $opportunity->candidates()->syncWithoutDetaching($user_id);
        } else {
            throw ValidationException::withMessages([
                'user' => ['Usuário já registrado nesta oportunidade.'],
            ]);
        }
    }

    public function viewed($opportunity_id, $candidate_id)
    {
        $opportunity = Opportunity::find($opportunity_id);

        if ($opportunity) {
            $candidate = $opportunity->candidates()->find($candidate_id);
            if ($candidate && !$candidate->viewed_at) {
                $opportunity->candidates()->updateExistingPivot($candidate, ['viewed_at' => now()]);
                $candidate->notify(new OpportunityViewedNotification($opportunity));
            }
        }
    }

    public function disassociate($opportunity_id)
    {
        $opportunity = Opportunity::findOrFail($opportunity_id);
        $opportunity->candidates()->detach(request()->user()->id);
    }

    public function renew($opportunity_id)
    {
        $opportunity = Opportunity::find(Crypt::decrypt($opportunity_id));

        if ($opportunity->expire_notification_at) {
            $days_expire_opportunity = Setting::where('key', 'days_expire_opportunity')->first();
            $addDays = $days_expire_opportunity ? $days_expire_opportunity->value : 30;

            $opportunity->expire_at = now()->addDays($addDays);
            $opportunity->expire_notification_at = null;
            $opportunity->save();

            die("<h1>VAGA RENOVADA ATÉ O " . $opportunity->expire_at);
        } else {
            die("<h1>VAGA JÁ RENOVADA</h1>");
        }
    }
}
