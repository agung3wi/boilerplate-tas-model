<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\UploadController;
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


Route::group([
    'middleware' => ['setguard:api', 'auth.rest']
], function () {
    // START CUSTOM ROUTE

    // END CUSTOM ROUTE
    Route::get('/test', [CrudController::class, 'test']);

    Route::get('/{model}/list', [CrudController::class, 'index']);
    Route::get('/{model}/dataset', [CrudController::class, 'dataset']);
    Route::post('/{model}/create', [CrudController::class, 'create']);
    Route::put('/{model}/update', [CrudController::class, 'update']);
    Route::delete('/{model}/delete', [CrudController::class, 'delete']);
    Route::put('/{model}/remove', [CrudController::class, 'remove']);
    Route::put('/{model}/restore', [CrudController::class, 'restore']);
    Route::get('/{model}/{id}/show', [CrudController::class, 'show']);

    Route::post('upload', [UploadController::class, 'upload'])->name("upload")->middleware('auth.rest');


    Route::get('/gen-lang/lang', [CrudController::class, 'lang']);
    Route::get('/gen-model/{model}', [CrudController::class, 'generate']);
    Route::get('/gen-module/listmodule', [CrudController::class, 'listModule']);
});

Route::group([
    'middleware' => ['setguard:api']
], function () {
    Route::get('file/{model}/{field}/{id}', [UploadController::class, 'getFile']);
    Route::get('tumb-file/{model}/{field}/{id}', [UploadController::class, 'getTumbnailFile']);
    Route::get('temp-file/{path}', [UploadController::class, 'getTempFile']);
});
