<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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
    return view('welcome');
});

Route::get('/', function () {
    return redirect('home');
});

Route::get('/login', function() {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::get('/register', function() {
    return view('auth.register');
})->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'do_login'])->name('do_login');
Route::get('/seed', [HomeController::class, 'seed'])->name('seed');
Route::get('/home', HomeController::class)->middleware('auth')->name('home');
Route::group(['middleware' => ['auth']], function() {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/user', [HomeController::class, 'new_user'])->name('new_user');
    Route::post('/comprar', [HomeController::class, 'comprar'])->name('comprar');
    Route::post('/facturar', [HomeController::class, 'facturar'])->name('facturar');
    Route::get('/factura/{id}', [HomeController::class, 'ver_factura'])->name('ver_factura');
    Route::resource('products', ProductController::class)->except(['create', 'edit', 'index']);
});
#Route::post('/home', [Home::class, 'save_post']);