<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'google' => [
        'client_id' => '1099005013280-hnuuo50kgnbm3qd6l7pcbcisk4k24m9m.apps.googleusercontent.com',         // Your GitHub Client ID
        'client_secret' => 'y6DqosGUTRTqqeSCsbFnzAm6',
        'redirect' => 'http://localhost:8000/login/google/callback',
    ],
    'facebook' => [
        'client_id' => '268234417114277',
        'client_secret' => '7efd646602f8a4783901302497add845', // Your GitHub Client Secret
        'redirect' => 'http://localhost:8000/login/facebook/callback',
    ],
    'github' => [
        'client_id' => '449ab97a056aa409a414',
        'client_secret' => '7781ad2a3ba9fab37d309467afc0247d9818fbf6', // Your GitHub Client Secret
        'redirect' => 'http://localhost:8000/login/github/callback',
    ],

];
