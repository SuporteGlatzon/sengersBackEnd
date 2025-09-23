<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeBannerResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'image' => $this->image ? __asset($this->image) : null,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'button_link' => $this->button_link,
            'button_text' => $this->button_text,
        ];
    }
}
