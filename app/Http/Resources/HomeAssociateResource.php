<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeAssociateResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'image' => $this->image ? __asset($this->image) : null,
            'description' => $this->description,
            'orange_text' => $this->orange_text,
            'title_right' => $this->title_right,
            'advantages' => $this->advantages,
            'button_link' => $this->button_link,
            'button_text' => $this->button_text,
        ];
    }
}
