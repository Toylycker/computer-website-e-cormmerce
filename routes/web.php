<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ComputerController;
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

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/', [HomeController::class, 'send']);
Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/language/{key}', [HomeController::class, 'language'])->name('language')->where('key', '[a-z]+');
Route::get('/busket', [HomeController::class, 'busket'])->name('busket');

Route::controller(ComputerController::class)->group(function () {
    Route::get('/computers', 'index')->name('computers');
    Route::get('/computer/{slug}', 'show')->name('computer')->where('slug', '[0-9A-Za-z-]+');
    Route::get('/computer/{slug}/favorite', 'favorite')->name('computer.favorite')->where('slug', '[0-9A-Za-z-]+');
    Route::get('/computer/{slug}/busket', 'busket')->name('computer.busket')->where('slug', '[0-9A-Za-z-]+');

    Route::middleware('auth')->group(function () {
        Route::get('/computers/create', 'create')->name('computer.create');
        Route::post('/computers/store', 'store')->name('computer.store');
        Route::get('/computers/{slug}/edit', 'edit')->name('computer.edit')->where('slug', '[0-9A-Za-z-]+');
        Route::put('/computers/{slug}/update', 'update')->name('computer.update')->where('slug', '[0-9A-Za-z-]+');
        Route::delete('/computers/{slug}/delete', 'delete')->name('computer.delete')->where('slug', '[0-9A-Za-z-]+');
    });
});