<?php
namespace App\Http\Controllers;
namespace App\Http\Middleware;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CorsMiddleware;


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


Route::get('resource', [ApiController::class, 'api_data']);
Route::get('queries', [ApiController::class,'contact_queries_api']);
Route::get('users', [ApiController::class,'all_users']);

// routes/api.php or routes/web.php

Route::middleware([CorsMiddleware::class])->group(function () {
    Route::post('send-data', [ApiController::class,'receiveData']);
    Route::post('user-login', [LoginController::class,'Userlogin']);

    // Add more routes as needed
});





