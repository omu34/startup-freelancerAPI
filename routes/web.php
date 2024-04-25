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










// Route::get('api/google/callback', function (Request $request) {
// $code = request()->get('code');

// $client = new Client();

// $response = $client->post('https://www.googleapis.com/oauth2/v4/token', [
//   'form_params' => [
//     'grant_type' => 'authorization_code',
//     'client_id' => env('GOOGLE_CLIENT_ID'),
//     'client_secret' => env('GOOGLE_CLIENT_SECRET'),
//     'token_uri'=>env('GOOGLE_TOKEN_URI'),
//     'auth_uri'=>env('GOOGLE_AUTH_URI'),
//     'code' => $code,
//     'redirect' => env('GOOGLE_REDIRECT_URL'),
// ]])->name("google.redirect")});
