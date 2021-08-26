<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Keycloak client credentials
    |--------------------------------------------------------------------------
    */

    'client_id'     => env('KEYCLOAK_CLIENT_ID'),
    'client_secret' => env('KEYCLOAK_CLIENT_SECRET'),
    'base_url'      => env('KEYCLOAK_BASE_URL'),

    /*
    |--------------------------------------------------------------------------
    | Keycloak callback handling URL
    |--------------------------------------------------------------------------
    */

    'redirect'      => env('APP_URL').'/admin/login/keycloak/callback'

];
