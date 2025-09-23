<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeCardResource extends JsonResource
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
            'call' => $this->call,
            'subtitle' => $this->subtitle,
            'button_text' => $this->button_text,
            'link' => $this->link,
            'status' => $this->status,
        ];
    }
}
