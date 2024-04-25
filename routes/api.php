<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\MediaController;


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
    // Library routes
    Route::post('library', [MediaController::class, 'storeMedia']);
    Route::get('library/{library}', [MediaController::class, 'getMedia']);
    Route::put('library/{library}/{mediaId}', [MediaController::class, 'updateMedia']);
    Route::delete('library/{library}/{mediaId}', [MediaController::class, 'deleteMedia']);
    Route::get('library/{library}/{mediaId}/download', [MediaController::class, 'downloadMedia']);
});





