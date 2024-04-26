<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleOauthController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

# Google Auth
Route::get('api/google/redirect', [GoogleOauthController::class, 'redirect'])->name("google.redirect");
Route::get('api/google/callback', [GoogleOauthController::class, 'callback'])->name("google.callback");











