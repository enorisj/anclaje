<?php

use App\Http\Controllers\AnchorPcController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\JWTAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [JWTAuthController::class, 'login'])->name('login');
Route::post('/register', [JWTAuthController::class, 'register'])->name('register');  
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    
], function ($router) {
    Route::post('/logout', [JWTAuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [JWTAuthController::class, 'refresh'])->name('refresh');


Route::get('areas', [AreaController::class, 'index']);
Route::get('area/{id}', [AreaController::class, 'show']);
Route::post('area/store', [AreaController::class, 'store']);
Route::put('area/{id}/update', [AreaController::class, 'update']);
Route::delete('area/{id}/destroy', [AreaController::class, 'destroy']);

Route::get('anchor', [AnchorPcController::class, 'index']);
Route::get('anchor/{id}', [AnchorPcController::class, 'show']);
Route::post('anchor/store', [AnchorPcController::class, 'store']);
Route::put('anchor/{id}/update', [AnchorPcController::class, 'update']);
Route::delete('anchor/{id}/destroy', [AnchorPcController::class, 'destroy']);

});