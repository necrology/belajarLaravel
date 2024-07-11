<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

// HOME INDEX
Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('logout', function () {
    auth()->logout();
    Session()->flush();

    return Redirect::to('/');
})->name('logout');

//CRUD ROUTE
Route::post('/insert', [HomeController::class, 'insert'])->name('insert');

Route::post('/delete/{id}', [HomeController::class, 'delete'])->name('delete');

Route::get('/getData/{id}', [HomeController::class, 'getData'])->name('getData');

Route::post('/update/{id}', [HomeController::class, 'update'])->name('update');
