<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'key' => $this->key,
            'content' => $this->content,
            'rating' => $this->rating,
            'user' => new UserResource($this->customer),
            'createdAt' => $this->created_at
        ];
    }
}
