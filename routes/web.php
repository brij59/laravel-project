<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// USER
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserDashboardController;



// ADMIN
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;

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
    return view('auth.userLogin');
});

Auth::routes();



Route::group(['prefix' => 'user'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');
        Route::get('/logout', [LoginController::class, 'userLogout'])->name('user.logout');
    });
});



Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminController::class, 'adminLogin'])->name('admin.login');
        Route::post('/login', [AdminController::class, 'adminAuthenticate'])->name('admin.auth');
    });

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');
    });
});
