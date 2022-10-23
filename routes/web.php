<?php

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

Route::get('/', function () {
    return view('auth.login');
});

Route::prefix('admin')->group(function () {
    Route::group(['middleware' => 'auth'], function () {

        // dashboard admin
        Route::get("/dashboard", \App\Http\Controllers\Admin\DashboardController::class)
            ->name('admin.dashboard.index');

        // categories
        Route::resource("/category", \App\Http\Controllers\Admin\CategoryController::class, ['as' => 'admin']);
    });
});
