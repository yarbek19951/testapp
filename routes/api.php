<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CardController;
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'prefix' => 'v1'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::group([
        'prefix'=>'user'
    ], function ($router){
        Route::get("", [UserController::class,'index']);
        Route::post("create", [UserController::class,'create']);
    });
    Route::group([
        'prefix'=>'product'
    ], function ($router){
        Route::get("", [ProductController::class,'index']);
        Route::post("create", [ProductController::class,'create']);
        Route::put("update/{id}/", [ProductController::class,'update']);
        Route::delete("destroy/{id}/", [ProductController::class,'destroy']);
    });
    Route::group([
        'prefix'=>'card'
    ], function ($router){
        Route::get("", [CardController::class,'index']);
        Route::post("create", [CardController::class,'create']);
        Route::put("update/{id}/", [CardController::class,'update']);
        Route::delete("destroy/{id}/", [CardController::class,'destroy']);
        Route::put("quantity-update/{id}/", [CardController::class,'quantity_update']);
    });

});
