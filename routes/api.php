<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api')->prefix('v1')->group(function () {
    Route::controller(AuthController::class)
        ->prefix('auth')
        ->group(function () {
            Route::post('login', 'login');
            Route::post('register', 'register');
            Route::post('logout', 'logout');
            Route::post('refresh', 'refresh');
        });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('products/dropdown', [ProductController::class, 'dropdown']);
        Route::apiResource('products', ProductController::class);
//        Route::controller(\App\Http\Controllers\ProductController::class)
//            ->group(function () { // TODO bring the code into line with the documentation
//                Route::get('products', 'index');
//                Route::get('products/{id}', 'show');
//                Route::post('products', 'store');
//                Route::put('products/{id}', 'update');
//                Route::delete('products/{id}', 'destroy');
//            });
    });
});
