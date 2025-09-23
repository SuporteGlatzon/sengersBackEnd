<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'name' => $this->name,
            'cpf' => $this->cpf,
            'code_crea' => $this->code_crea,
            'email' => $this->email,
            'image' => $this->avatar,
            'phone' => $this->phone,
            'address' => $this->address,
            'complement' => $this->complement,
            'state' => $this->state ? new StateResource($this->state) : null,
            'city' => $this->city ? new CityResource($this->city) : null,
            'description' => $this->description,
            'full_description' => $this->full_description,
            'link_site' => $this->link_site,
            'link_instagram' => $this->link_instagram,
            'link_twitter' => $this->link_twitter,
            'link_linkedin' => $this->link_linkedin,
            'banner_profile' => $this->banner_profile ? __asset($this->banner_profile) : null,
            'curriculum' => $this->curriculum ? __asset($this->curriculum) : null,
            'educations' => EducationResource::collection($this->educations),
            'opportunities' => ProfileOpportunityResource::collection($this->opportunities),
            'opportunities_applied' => OpportunityResource::collection($this->candidates),
        ];
    }
}
