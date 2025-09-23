<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileOpportunityResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company' => $this->company,
            'cnpj' => $this->cnpj,
            'state' => $this->state_id ? new StateResource($this->state) : null,
            'city' => $this->city_id ? new CityResource($this->city) : null,
            'title' => $this->title,
            'description' => $this->description,
            'full_description' => $this->full_description,
            'status' => $this->status,
            'situation' => $this->situation,
            'date' => $this->date,
            'salary' => $this->salary,
            'published_by' => new PublishedByResource($this->client),
            'type' => $this->opportunity_type_id ? new OpportunityTypeResource($this->opportunity_type) : null,
            'occupation_area' => $this->occupation_area_id ? new OccupationAreaResource($this->occupation_area) : null,
            'candidates' => CandidateResource::collection($this->candidates),
        ];
    }
}
