<?php


use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**
 * This Routes For Users Onley
 */
Route::group(['middleware' => ['auth:api'],'prefix' => 'v1'], function () {
    Route::post('login',[AuthController::class,'login'])->withoutMiddleware('auth:api');
    Route::post('register',[AuthController::class,'register'])->withoutMiddleware('auth:api');
    Route::put('user-update',[AuthController::class,'updateUser']);
    Route::post('logout',[AuthController::class,'logout']);
  Route::apiResource('categories', CategoryController::class);
  Route::apiResource('posts', PostController::class);
});


/**
 * This Routes For Admins Onley
 */
Route::group(['middleware' => ['auth:admin'],'prefix' => 'admin'], function () {
    Route::post('/login',[AdminController::class,'adminLogin'])->withoutMiddleware('auth:admin');
    Route::post('/logout',[AdminController::class,'adminLogout']);
});

