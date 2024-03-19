<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardControllers;
use App\Http\Controllers\Forgot\ForgotControllers;
use App\Http\Controllers\Home\HomeControllers;
use App\Http\Controllers\Product\ProductControllers;
use App\Http\Controllers\Users\UsersControllers;
use Illuminate\Support\Facades\Auth;
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


// ALL CONTROLLERS

Route::get('/', function () {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard.index');
    } else {
        if (Auth::guard('user')->check()) {
            return redirect()->route('user.order.index');
        }
    }
});

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('index');
    Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::post('logout',  [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('auth')->name('forgot.')->group(function () {
    Route::get('forgot', [ForgotControllers::class, 'index'])->name('index');
    Route::post('forgot', [ForgotControllers::class, 'forgot'])->name('forgot');
});


Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    // ROUTE TO DASHBOARD CONTROLLERS
    Route::name('dashboard.')->group(function () {
        Route::get('dashboard-admin', [DashboardControllers::class, 'index'])->name('index');
    });

    // ROUTE TO PRODUCTS CONTROLLERS
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/', [ProductControllers::class, 'index'])->name('index');
        Route::get('create', [ProductControllers::class, 'create'])->name('create');
        Route::post('store', [ProductControllers::class, 'store'])->name('store');
        Route::get('show/{id}', [ProductControllers::class, 'show'])->name('show');
        Route::post('update', [ProductControllers::class, 'update'])->name('update');
        Route::post('delete', [ProductControllers::class, 'delete'])->name('delete');
    });

    // ROUTE TO USERS CONTROLLERS
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UsersControllers::class, 'index'])->name('index');
        Route::post('store', [UsersControllers::class, 'store'])->name('store');
        Route::get('show/{id}', [UsersControllers::class, 'show'])->name('show');
        Route::post('update', [UsersControllers::class, 'update'])->name('update');
        Route::post('delete', [UsersControllers::class, 'delete'])->name('delete');
    });
});

Route::middleware('auth:user')->prefix('user')->name('user.')->group(function () {


});
