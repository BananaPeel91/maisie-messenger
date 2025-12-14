<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */

    'api' => [
        'key' => env('API_KEY'),
    ],

    'resend' => [
        'api_key' => env('RESEND_API_KEY'),
        'from_email' => env('RESEND_FROM_EMAIL', 'onboarding@resend.dev'),
        'from_name' => env('RESEND_FROM_NAME', 'Maisie'),
    ],

    'maisie' => [
        'recipient_email' => env('RECIPIENT_EMAIL'),
        'recipient_name' => env('RECIPIENT_NAME', 'Mummy'),
        'sender_name' => env('SENDER_NAME', 'Maisie'),
    ],

];
