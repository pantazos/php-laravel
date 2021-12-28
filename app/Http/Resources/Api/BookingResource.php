<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BookingResource extends JsonResource
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
            'customer' => new UserResource($this->customer),
            'provider' => new UserResource($this->provider),
            'service' => new ServiceResource($this->service),
            'status' => new StatusResource($this->status),
            'bookingAt' => Carbon::parse($this->booking_at)->toDateTimeString(),
            'notes' => $this->notes,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'addressName' => $this->address_name,
            'addressDetails' => $this->address_details,
            'tax' => (float)$this->tax,
            'discount' => $this->discount,
            'total' => (float)$this->total,
            'createdAt' => Carbon::parse($this->created_at)->toDateTimeString()
        ];
    }
}
