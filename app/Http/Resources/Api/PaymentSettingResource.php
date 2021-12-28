<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentSettingResource extends JsonResource
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
            'tax_enabled' => (boolean)$this->tax_enabled,
            'tax_percentage' => $this->tax_percentage,
            'currency' => new CurrencyResource($this->currency)
        ];
    }
}
