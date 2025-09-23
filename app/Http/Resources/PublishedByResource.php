<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublishedByResource extends JsonResource
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
            'image' => $this->avatar,
            'phone' => $this->phone,
            'address' => $this->address,
            'complement' => $this->complement,
            'state' => $this->state ? new StateResource($this->state) : null,
            'city' => $this->city ? new CityResource($this->city) : null,
            'description' => $this->description,
        ];
    }
}
