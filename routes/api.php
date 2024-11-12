<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ConstrainedController;
use App\Http\Controllers\MobilityController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('store', [AuthController::class, 'store']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'users'

], function ($router) {

    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::put('/{user}', [UserController::class, 'update']);
    Route::delete('/{user}', [UserController::class, 'destroy']);
    Route::patch('/restore/{id}', [UserController::class, 'restore'])->where('id', '[0-9]+'); 

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'events'

], function ($router) {

    Route::get('/', [EventController::class, 'index']);
    Route::get('/val', [EventController::class, 'indexVal']);
    Route::get('/events_auth', [EventController::class, 'indexAuth']);
    Route::get('/all', [EventController::class, 'all']);
    Route::get('/collection', [EventController::class, 'collection']);
    Route::post('/', [EventController::class, 'store']);
    Route::get('/{event}', [EventController::class, 'show']);
    Route::put('/{event}', [EventController::class, 'update']);
    Route::delete('/{event}', [EventController::class, 'destroy']);
    Route::patch('/restore/{id}', [EventController::class, 'restore'])->where('id', '[0-9]+');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'mobilitys'

], function ($router) {

    Route::get('/', [MobilityController::class, 'index']);
    Route::get('/mobilite_auth', [MobilityController::class, 'indexAuth']);
    Route::get('/collection', [MobilityController::class, 'collection']);
    Route::post('/', [MobilityController::class, 'store']);
    Route::get('/{mobility}', [MobilityController::class, 'show']);
    Route::put('/{mobility}', [MobilityController::class, 'update']);
    Route::delete('/{mobility}', [MobilityController::class, 'destroy']);
    Route::patch('/restore/{id}', [MobilityController::class, 'restore'])->where('id', '[0-9]+');

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'constraineds'

], function ($router) {

    Route::get('/', [ConstrainedController::class, 'index']);
    Route::post('/', [ConstrainedController::class, 'store']);
    Route::get('/{constrained}', [ConstrainedController::class, 'show']);
    Route::put('/{constrained}', [ConstrainedController::class, 'update']);
    Route::delete('/{constrained}', [ConstrainedController::class, 'destroy']);
    Route::patch('/restore/{id}', [ConstrainedController::class, 'restore'])->where('id', '[0-9]+');

});
