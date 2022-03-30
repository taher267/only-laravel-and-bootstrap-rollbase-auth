<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
|
// composer require laravel/ui
    php artisan ui bootstrap --auth
    php artisan make:controller AdminController
    php artisan make:controller UserController
    php artisan make:middleware isUserMiddleware
    php artisan make:middleware isAdminMiddleware

    RedirectIfAuthenticated
    loginController
    //Prevent back history
     php artisan make:middleware PreventBackHistory
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix'=>'admin', 'middleware'=>['isAdmin','auth','PreventBackHistory']],function () {
    Route::get('dashboard', [AdminController::class,'index'])->name('admin.dashboard');
    Route::get('profile', [AdminController::class,'profile'])->name('admin.profile');
    Route::get('settings', [AdminController::class,'settings'])->name('admin.settings');
});
Route::group(['prefix'=>'user', 'middleware'=>['isUser','auth','PreventBackHistory']],function () {
    Route::get('dashboard', [UserController::class,'index'])->name('user.dashboard');
    Route::get('profile', [UserController::class,'profile'])->name('user.profile');
    Route::get('settings', [UserController::class,'settings'])->name('user.settings');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
