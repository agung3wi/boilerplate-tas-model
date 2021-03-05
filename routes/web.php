<?php

use App\Http\Controllers\CrudController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use PHPMailer\PHPMailer\PHPMailer;
use Aws\Ses\SesClient;
use Aws\Ses\Exception\SesException;

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
});

// Route::get('/{model}', [CrudController::class, 'index']);
// Route::get('/{model}/{id}', [CrudController::class, 'find']);
// Route::post('/{model}', [CrudController::class, 'create']);
// Route::put('/{model}/{id}', [CrudController::class, 'update']);
// Route::delete('/{model}/{id}', [CrudController::class, 'delete']);
