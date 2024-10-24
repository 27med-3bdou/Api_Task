<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\OrdersController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/' , function ()
{
    return 1;
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'U'

], function () {
    Route::post('/login'      , [LoginController::class , 'login']);
    Route::post('/register'   , [LoginController::class, 'register']);
    Route::post('/logout'     , [LoginController::class, 'logout']);
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'A'

], function () {
Route::post('/login'      , [AdminController::class , 'login']);
Route::post('/register'   , [AdminController::class, 'register']);
Route::post('/logout'     , [AdminController::class, 'logout']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'D'

], function () {
Route::post('/login'      , [DeliveryController::class , 'login']);
Route::post('/register'   , [DeliveryController::class, 'register']);
Route::post('/logout'     , [DeliveryController::class, 'logout']);
});


Route::middleware(['auth:sanctum', 'role:delivery'])->group(function () {
    Route::get('/my-orders', [DeliveryController::class, 'show']);
    Route::post('/orders/{order}/update-status', [DeliveryController::class, 'update']);
});

Route::middleware('auth:sanctum', 'role:admin')->group(function(){
    Route::get('/orders', [OrdersController::class, 'index']);
    Route::get('/orders/{id}', [OrdersController::class, 'show']);
    Route::post('/orders', [OrdersController::class, 'store']);
    Route::put('/orders/{id}', [OrdersController::class, 'update']);
    Route::delete('/orders/{id}', [OrdersController::class, 'destroy']);
    Route::post('/orders/{order}/assign', [OrdersController::class, 'assignDeliveryPersonnel']);
});


