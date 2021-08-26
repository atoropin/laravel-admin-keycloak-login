<?php


use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::get('login/{provider}/callback', 'AuthController@callback');
    Route::get('login/form', 'AuthController@getLoginForm');
});
