<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'paytabs' => [
        'paypage_url' => env('PAYTABS_PAYPAGE_URL'),
        'verify_url' => env('PAYTABS_VERIFY_URL'),
        'merchant_email' => env('PAYTABS_MERCHANT_EMAIL'),
        'secret_key' => env('PAYTABS_SECRET_KEY'),
        'site_url' => env('PAYTABS_SITE_URL'),
    ],

    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET'),
    ],

    'currency_converter' => [
        'apikey' => env('CURRENCY_CONVERTER_APIKEY'),
        'from_currency' => env('CURRENCY_CONVERTER_FROM_CURRENCY'),
        'to_currency' => env('CURRENCY_CONVERTER_TO_CURRENCY'),
    ],

];
