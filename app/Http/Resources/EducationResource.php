<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
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
            'institution' => $this->institution,
            'course' => $this->course,
            'conclusion_at' => $this->conclusion_at,
            'current_situation' => $this->current_situation,
            'observation' => $this->observation,
        ];
    }
}
