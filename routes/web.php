<?php

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
    $columns = DB::getDoctrineColumn('m_product', 'uom_id')->getType()->getName();
    dd($columns);
});

// Route::get('/{model}', [CrudController::class, 'index']);
// Route::get('/{model}/{id}', [CrudController::class, 'find']);
// Route::post('/{model}', [CrudController::class, 'create']);
// Route::put('/{model}/{id}', [CrudController::class, 'update']);
// Route::delete('/{model}/{id}', [CrudController::class, 'delete']);
