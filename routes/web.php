<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\UserAuthentication;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RolesController;


Route::get('/', function () {
    return view('welcome');
});
/**
 * Admin Route : Start
 */
Route::group(['middleware' => [UserAuthentication::class,PreventBackHistory::class]], function () {
    Route::group(['prefix' => 'admin'], function () {
        //
        /**
         * Dashboard Route
         */
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin');

        Route::resource('/roles', RolesController::class);
        Route::get('roles-data', [RolesController::class, 'getData'])->name('roles.data');


        Route::resource('/users', UserController::class);
        Route::get('users-data', [UserController::class, 'getData'])->name('users.data');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
