<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;


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
// 
Route::group([ 'prefix' => 'product','middleware' => 'AuthToken',], function () {
    Route::post('/update/{id}', [ProductController::class, 'updateProduct'])->middleware('UploadImage');
    Route::get('/get', [ProductController::class, 'getProduct']);
    Route::delete('/delete/{id}', [ProductController::class, 'deleteProduct']);
    Route::post('/upload', [ProductController::class, 'uploadProduct'])->middleware('UploadImage');
});

Route::group([ 'prefix' =>'auth',], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('AuthToken');
});