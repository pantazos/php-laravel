<?php

namespace App\Http\Controllers\PaymentClients;

use PayPalCheckoutSdk\Core\PayPalEnvironment;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class PayPalClient
{
    /**
     * Returns PayPal HTTP client instance with environment that has access
     * credentials context. Use this instance to invoke PayPal APIs, provided the
     * credentials have access.
     */
    public static function client(): PayPalHttpClient
    {
        return new PayPalHttpClient(self::environment());
    }

    /**
     * Set up and return PayPal PHP SDK environment with PayPal access credentials.
     * This sample uses SandboxEnvironment. In production, use ProductionEnvironment.
     */
    public static function environment(): PayPalEnvironment
    {
        $clientId = getenv("PAYPAL_CLIENT_ID") ?: "PAYPAL-SANDBOX-CLIENT-ID";
        $clientSecret = getenv("PAYPAL_CLIENT_SECRET") ?: "PAYPAL-SANDBOX-CLIENT-SECRET";
        return new SandboxEnvironment($clientId, $clientSecret);
    }
}

