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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// header('Access-Control-Allow-Origin: http://localhost:3000');
// header('Access-Control-Allow-Headers: origin, x-requested-with, content-type');
// header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');



    /*
        USER AUTHENTICATION
     */
    Route::prefix('auth')->group(function() {
        Route::post('login', [App\Http\Controllers\Api\AuthenticationController::class, 'login']);
        Route::post('register', [App\Http\Controllers\Api\AuthenticationController::class, 'register']);
        Route::get('validate-token/{token}', [App\Http\Controllers\Api\AuthenticationController::class, 'validate_token']);
    });

     /*
        AUTHENTICATED ROUTES
     */
    Route::middleware('auth:sanctum')->group(function() {

        Route::resource('blog', 'App\Http\Controllers\Api\BlogController');
        Route::resource('project', 'App\Http\Controllers\Api\ProjectController');

        Route::post('refresh', [App\Http\Controllers\Api\AuthenticationController::class, 'refresh']);
        Route::get('logout', [App\Http\Controllers\Api\AuthenticationController::class, 'logout']);
        
    });
    