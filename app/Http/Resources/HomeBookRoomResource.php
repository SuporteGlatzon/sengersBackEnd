<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeBookRoomResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'orange_text' => $this->orange_text,
            'title' => $this->title,
            'image' => $this->image ? __asset($this->image) : null,
            'description' => $this->description,
            'title_right' => $this->title_right,
            'room' => $this->rooms,
            'button_link' => $this->button_link,
            'button_text' => $this->button_text,
        ];
    }
}
