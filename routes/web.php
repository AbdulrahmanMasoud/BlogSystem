<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
  return view('welcome');
});
Route::get('/test', [CategoryController::class, 'method']);


Route::any('{slug}', function () {
  return view('welcome');
});
