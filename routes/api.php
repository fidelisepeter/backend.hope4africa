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

// header('Access-Control-Allow-Origin: http://localhost:3000');
// header('Access-Control-Allow-Headers: origin, x-requested-with, content-type');
// header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');



/**
 * USER AUTHENTICATION
 */

Route::prefix('auth')->group(function () {
    Route::post('login', [App\Http\Controllers\Api\AuthenticationController::class, 'login']);
    Route::post('register', [App\Http\Controllers\Api\AuthenticationController::class, 'register']);
    Route::get('validate-token/{token}', [App\Http\Controllers\Api\AuthenticationController::class, 'validate_token']);
});


/**
 * AUTHENTICATED ROUTES
 */

Route::middleware('auth:sanctum')->group(function () {

    //Blog Endpoints 
    Route::get('blog', [App\Http\Controllers\Api\BlogController::class, 'index'])->withoutMiddleware('auth:sanctum')->name('blog.index');
    Route::post('blog', [App\Http\Controllers\Api\BlogController::class, 'store'])->name('blog.store');
    Route::get('blog/{blog}', [App\Http\Controllers\Api\BlogController::class, 'show'])->withoutMiddleware('auth:sanctum')->name('blog.show');
    Route::match(['put', 'patch','post'], 'blog/{blog}', [App\Http\Controllers\Api\BlogController::class, 'update'])->name('blog.update');
    Route::delete('blog/{blog}', [App\Http\Controllers\Api\BlogController::class, 'destroy'])->name('blog.destroy');

    //Project Endpoints
    Route::get('project', [App\Http\Controllers\Api\ProjectController::class, 'index'])->withoutMiddleware('auth:sanctum')->name('project.index');
    Route::post('project', [App\Http\Controllers\Api\ProjectController::class, 'store'])->name('project.store');
    Route::get('project/{project}', [App\Http\Controllers\Api\ProjectController::class, 'show'])->withoutMiddleware('auth:sanctum')->name('project.show');
    Route::match(['put', 'patch','post'], 'project/{project}', [App\Http\Controllers\Api\ProjectController::class, 'update'])->name('project.update');
    Route::delete('project/{project}', [App\Http\Controllers\Api\ProjectController::class, 'destroy'])->name('project.destroy');

    //Logout & Refresh
    Route::post('refresh', [App\Http\Controllers\Api\AuthenticationController::class, 'refresh']);
    Route::get('logout', [App\Http\Controllers\Api\AuthenticationController::class, 'logout']);
});
