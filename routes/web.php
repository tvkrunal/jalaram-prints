<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\UserAuthentication;
use App\Http\Controllers\Admin\AdminController;


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
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
