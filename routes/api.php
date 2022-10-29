<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Api\CategoryController as ApiCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// auth API
Route::post("/register", [\App\Http\Controllers\Api\RegisterController::class, "register"]);
Route::post("/login", [\App\Http\Controllers\Api\LoginController::class, "login"]);

// category API
Route::get('/category', [ApiCategoryController::class, "index"]);
Route::get('/category/{slug}', [ApiCategoryController::class, "show"]);
Route::get('/category-home', [ApiCategoryController::class, "categoryHome"]);

// campaign API
Route::get("/campaign", [\App\Http\Controllers\Api\CampaignController::class, "index"]);
Route::get("/campaign/{slug}", [\App\Http\Controllers\Api\CampaignController::class, "show"]);

// slider API
Route::get('/slider', [\App\Http\Controllers\Api\SliderController::class, "index"]);

// profile API
Route::get('/profile', [\App\Http\Controllers\Api\ProfileController::class, "index"]);
Route::post('/profile', [\App\Http\Controllers\Api\ProfileController::class, "update"])->middleware('auth:api');
Route::post('/profile/password', [\App\Http\Controllers\Api\ProfileController::class, "updatePassword"])->middleware('auth:api');

// donation API
Route::get("/donation", [\App\Http\Controllers\Api\DonationController::class, "index"])->middleware('auth:api');
Route::post("/donation", [\App\Http\Controllers\Api\DonationController::class, "store"])->middleware('auth:api');
Route::post("/donation/notification", [\App\Http\Controllers\Api\DonationController::class, "notificationHandler"])->middleware('auth:api');


// reset password without login API
Route::post("/forgot-password", [\App\Http\Controllers\Api\ProfileController::class, "updatePasswordWithoutLogin"]);
