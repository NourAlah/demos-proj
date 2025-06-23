<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/debug', function () {
    /* return [
        'env_login_endpoint' => env('PASSPORT_LOGIN_ENDPOINT'),
        'config_login_endpoint' => config('services.passport.login_endpoint'),
    ]; */
});


