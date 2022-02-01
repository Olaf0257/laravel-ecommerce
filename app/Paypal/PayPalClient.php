<?php

namespace App\Paypal;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;      // when u go live, change this to ProductionEnvironment

class PayPalClient
{
    /**
     * Returns PayPal HTTP client instance with environment that has access
     * credentials context. Use this instance to invoke PayPal APIs, provided the
     * credentials have access.
     */
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    /**
     * Set up and return PayPal PHP SDK environment with PayPal access credentials.
     * This sample uses SandboxEnvironment. In production, use LiveEnvironment.
     */
    public static function environment()
    {
        $clientId = config("services.paypal.client_id");
        $clientSecret = config("services.paypal.client_secret");
        
        return new SandboxEnvironment($clientId, $clientSecret);
    }
}