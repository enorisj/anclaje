<?php

use App\Http\Controllers\AnchorPcController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\UserController;
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


Route::get('area/{id}/force-destroy', [AreaController::class, 'forceDestroy']);
Route::get('area/{id}/restore', [AreaController::class, 'restore']);
Route::get('area/deleted', [AreaController::class, 'getDeleted']);
Route::get('areas', [AreaController::class, 'index']);
Route::get('area/{id}', [AreaController::class, 'show']);
Route::post('area/store', [AreaController::class, 'store']);
Route::put('area/{id}/update', [AreaController::class, 'update']);
Route::delete('area/{id}/destroy', [AreaController::class, 'destroy']);

 
Route::get('anchor/{id}/force-destroy', [AnchorPcController::class, 'forceDestroy']);
Route::get('anchor/{id}/restore', [AnchorPcController::class, 'restore']);
Route::get('anchor/deleted', [AnchorPcController::class, 'getDeleted']);
Route::get('anchor/{number}/find', [AnchorPcController::class, 'getByNumber']);
Route::get('anchors', [AnchorPcController::class, 'index']);
Route::post('anchor/store', [AnchorPcController::class, 'store']);
Route::put('anchor/{id}/update', [AnchorPcController::class, 'update']);
Route::delete('anchor/{id}/destroy', [AnchorPcController::class, 'destroy']);
Route::get('anchor/{id}', [AnchorPcController::class, 'show']);

Route::get('user/{id}/force-destroy', [UserController::class, 'forceDestroy']);
Route::get('user/{id}/restore', [UserController::class, 'restore']);
Route::get('user/deleted', [UserController::class, 'getDeleted']);
Route::post('user/info', [UserController::class, 'infoperUser']);
Route::post('user/ldapuser', [UserController::class, 'ldapUser']);
Route::get('user/list', [UserController::class, 'getUsers']);
Route::post('user/store', [UserController::class, 'store']);
Route::put('user/{id}/update', [UserController::class, 'update']);

});