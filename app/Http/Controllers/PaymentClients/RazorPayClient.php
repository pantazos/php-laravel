<?php

namespace App\Http\Controllers\PaymentClients;

use Razorpay\Api\Api;

class RazorPayClient
{
    /**
     * Returns RazorPay HTTP client instance with environment that has access
     * credentials context. Use this instance to invoke RazorPay APIs, provided the
     * credentials have access.
     */
    public static function client(): Api
    {
        $apiKey = getenv("RAZOR_PAY_API_KEY") ?: "RAZOR-PAY-API-KEY";
        $apiSecret = getenv("RAZOR_PAY_API_SECRET") ?: "RAZOR-PAY-API-SECRET";

        return new Api($apiKey, $apiSecret);
    }
}
