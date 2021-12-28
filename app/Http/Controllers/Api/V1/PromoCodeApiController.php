<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PromoCodeResource;
use App\Models\PromoCode;
use App\Models\Service;
use DateTime;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PromoCodeApiController extends Controller
{
    public function validatePromoCode(Request $request, $code): Response
    {
        $request->validate(['service_key' => 'required|string']);

        $promoCode = PromoCode::where('code', $code)->first();

        if (!$promoCode || !$promoCode->enabled)
            return response(['message' => 'Promo code is invalid'], 412);

        $now = new DateTime();
        if ($promoCode->expires_at && $promoCode->expires_at < $now)
            return response(['message' => 'Promo code has expired'], 412);

        if ($promoCode->categories->isEmpty() && $promoCode->services->isEmpty())
            return response(new PromoCodeResource($promoCode)); // valid promo code, return its details

        $serviceKey = $request->query('service_key');
        $service = Service::byKey($serviceKey)->firstOrFail();

        // if promo code has categories, check if this category is included, if yes, return promo code details
        if (!$promoCode->categories->isEmpty() && $promoCode->categories->contains('key', $service->category->key))
            return response(new PromoCodeResource($promoCode));

        // else if promo code has services, check if this service is included, if yes, return promo code details
        if (!$promoCode->services->isEmpty() && $promoCode->services->contains('key', $service->key))
            return response(new PromoCodeResource($promoCode));

        // else, return invalid promo code
        return response(['message' => 'Promo code is invalid'], 412);
    }
}
