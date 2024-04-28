<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\FileController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {
    // User routes
    Route::put('/profile', [FreelancerController::class, 'userCreateUpdateProfile']);
    Route::post('/profile/request-approval', [FreelancerController::class, 'userSendApprovalRequest']);
    Route::delete('/profiles/{profile}', [FreelancerController::class, 'deleteProfile']);
    Route::post('profile/logout', [UserController::class, 'signOut']);
    // Admin routes
    Route::get('/admin/pending-approval', [FreelancerController::class, 'adminFetchPendingApproval']);
    Route::put('/admin/profile/{profile}/approve', [FreelancerController::class, 'adminDecidesApproval']);




    // Route::post('/media', [MediaController::class, 'storeMedia']);
    // Route::get('/media/media', [MediaController::class, 'showMedia']);
    // Route::put('/media/{media}', [MediaController::class, 'updateMedia']);
    // Route::delete('/media/{media}', [MediaController::class, 'destroyMedia']);
    // Route::get('/media/{media}/download', [MediaController::class, 'downloadMedia']);

    Route::post('/media', [FileController::class, 'store']);
    Route::get('/media/{id}', [FileController::class, 'show']);
    Route::put('/media/{id}', [FileController::class, 'update']);
    Route::delete('/media/{id}', [FileController::class, 'destroy']);
    Route::get('/media/{id}/download', [FileController::class, 'download']);
});
