<?php


use Illuminate\Support\Facades\Route;

Route::get('admin/login/{provider}/callback', 'AuthController@callback');
Route::get('admin/login/form', 'AuthController@getLoginForm');
