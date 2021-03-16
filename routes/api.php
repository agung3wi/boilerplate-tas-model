<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'prefix' => 'auth',
    'middleware' => 'setguard:api'

], function () {

    Route::post('login', [AuthController::class, 'login'])->name("login");
    Route::post('register', [AuthController::class, 'register'])->name("register");
    Route::post('logout', [AuthController::class, 'logout'])->name("logout");
    Route::post('refresh', [AuthController::class, 'refresh'])->name("refresh");
    Route::post('me', [AuthController::class, 'me'])->name("me")->middleware("permission:user");
});


Route::get('/{model}', [CrudController::class, 'index']);
Route::get('/{model}/show', [CrudController::class, 'show']);
Route::post('/{model}/create', [CrudController::class, 'create']);
Route::put('/{model}/update', [CrudController::class, 'update']);
Route::delete('/{model}/delete', [CrudController::class, 'delete']);
Route::put('/{model}/remove', [CrudController::class, 'remove']);
Route::put('/{model}/restore', [CrudController::class, 'restore']);
