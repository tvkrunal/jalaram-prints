<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\UserAuthentication;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PriceMasterController;



Route::get('/', function () {
    return redirect()->route('login');
});
/**
 * Admin Route : Start
 */
Route::group(['middleware' => ['auth']], function () {
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

        Route::resource('/inquiry', InquiryController::class);
        Route::get('inquiry-data', [InquiryController::class, 'getData'])->name('inquiry.data');

        Route::resource('/customer', CustomerController::class);
        Route::get('customer-data', [CustomerController::class, 'getData'])->name('customer.data');

        Route::resource('/price-master', PriceMasterController::class);
        Route::get('price-master-data', [PriceMasterController::class, 'getData'])->name('price.master.data');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
