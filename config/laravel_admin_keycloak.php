<?php

return [

    'client_id'     => env('KEYCLOAK_CLIENT_ID'),
    'client_secret' => env('KEYCLOAK_CLIENT_SECRET'),
    'base_url'      => env('KEYCLOAK_BASE_URL'),
    'redirect'      => '${APP_URL}/admin/login/keycloak_admin/callback'

];
