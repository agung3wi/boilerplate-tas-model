<?php

use App\Http\Controllers\CrudController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return DB::select("SELECT * FROM information_schema.columns
    WHERE table_catalog = '" . env("DB_DATABASE") . "' AND table_name = 'm_product'");
});

Route::get('/admin', function () {
    return view('home');
});


Route::group([
    'middleware' => 'setguard:web'
], function () {
    Route::get('/{model}', [CrudController::class, 'index']);
    Route::post('/{model}/create', [CrudController::class, 'create']);
    Route::put('/{model}/update', [CrudController::class, 'update']);
    Route::delete('/{model}/delete', [CrudController::class, 'delete']);
    Route::put('/{model}/remove', [CrudController::class, 'remove']);
    Route::put('/{model}/restore', [CrudController::class, 'restore']);
    Route::get('/{model}/{id}/show', [CrudController::class, 'show']);
});

Route::get('/generate/lang', [CrudController::class, 'lang']);
Route::get('/generate/{model}', [CrudController::class, 'generate']);
Route::get('/gen-modul/modullist', [CrudController::class, 'listModul']);

