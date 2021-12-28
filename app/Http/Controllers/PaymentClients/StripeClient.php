<?php

namespace App\Http\Controllers\PaymentClients;

class StripeClient
{
    public static function client(): \Stripe\StripeClient
    {
        $apiKey = getenv("STRIPE_SECRET_KEY") ?: "STRIPE-SECRET-KEY";

        return new \Stripe\StripeClient($apiKey);
    }
}
