<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewCollection extends JsonResource
{
    /**
     * Used to transform cursor pagination response
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => ReviewResource::collection($this->items()),
            'prevCursor' => Request::create($this->previousPageUrl() ?: "")->query('cursor'),
            'nextCursor' => Request::create($this->nextPageUrl() ?: "")->query('cursor')];
    }
}
