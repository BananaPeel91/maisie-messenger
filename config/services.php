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

    'maisie' => [
        'recipient_email' => env('RECIPIENT_EMAIL'),
        'recipient_name' => env('RECIPIENT_NAME', 'Mummy'),
        'sender_name' => env('SENDER_NAME', 'Maisie'),
    ],

];
