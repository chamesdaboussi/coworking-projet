<?php

return [
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],
    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'resend' => [
        'key' => env('RESEND_KEY'),
    ],
    'stripe' => [
        // Public key only: used by Stripe.js in the browser.
        'key' => env('PUBLIC_STRIPE_PUBLISHABLE_KEY'),
        'currency' => env('STRIPE_CURRENCY', 'eur'),
    ],
];
