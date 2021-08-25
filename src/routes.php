<?php


use Illuminate\Support\Facades\Route;

Route::get('admin/login/keycloak/callback', 'AuthController@callback');
Route::get('admin/login/form', 'AuthController@getLoginForm');
