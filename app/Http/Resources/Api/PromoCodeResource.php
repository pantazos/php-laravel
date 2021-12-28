<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromoCodeResource extends JsonResource
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
            'code' => $this->code,
            'enabled' => $this->enabled,
            'type' => $this->type,
            'discount' => $this->discount,
            'expires_at' => $this->expires_at,
            'services' => ServiceResource::collection($this->services),
            'categories' => ServiceResource::collection($this->categories)
        ];
    }
}
