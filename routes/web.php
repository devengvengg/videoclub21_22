<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;

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

Route::get('/', [HomeController::class, 'getHome']);

Route::group(['prefix' => 'catalog', 'middleware' => 'auth'], function () {

    Route::get('/', [CatalogController::class, 'getIndex'])->name('dashboard');

    Route::get('/show/{id}', [CatalogController::class, 'getShow']);

    Route::get('/create', [CatalogController::class, 'getCreate']);
    Route::post('/create', [CatalogController::class, 'postCreate']);

    Route::get('/edit/{id}', [CatalogController::class, 'getEdit']);
    Route::put('/edit/{id}', [CatalogController::class, 'putEdit']);

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';
