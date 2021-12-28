<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'key' => $this->key,
            'name' => $this->name,
            'description' => $this->description,
            'color' => $this->category->color,
            'icon' => $this->icon->url,
            'duration' => $this->duration,
            'price' => $this->price,
            'rating' => $this->averageRating,
            'reviewsCount' => $this->reviewsCount,
            'bookingsCount' => $this->bookingsCount,
            'categoryKey' => $this->category->key
        ];
    }
}
