<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**
 * This Routes For Users Onley
 */
Route::group(['middleware' => ['auth:api'],'prefix' => 'v1'], function () {
    Route::post('login',[AuthController::class,'login'])->withoutMiddleware('auth:api');
    Route::post('register',[AuthController::class,'register'])->withoutMiddleware('auth:api');
});

/**
 * This Routes For Admins Onley
 */
Route::group(['middleware' => ['auth:admin'],'prefix' => 'admin'], function () {
    Route::post('admin/login',[AdminController::class,'adminLogin'])->withoutMiddleware('auth:admin');
});
    

