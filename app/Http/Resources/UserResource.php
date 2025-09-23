<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city_id' => $this->city_id,
            'state_id' => $this->state_id,
            'description' => $this->description,
            'full_description' => $this->full_description,
            'link_site' => $this->link_site,
            'link_instagram' => $this->link_instagram,
            'link_twitter' => $this->link_twitter,
            'link_linkedin' => $this->link_linkedin,
            'banner_profile' => $this->banner_profile ? asset($this->banner_profile) : null,
            'senge_associate' => $this->senge_associate,
            'curriculum' => $this->curriculum ? asset($this->curriculum) : null,
            'avatar' => $this->avatar ? asset($this->avatar) : null,
        ];
    }
}
