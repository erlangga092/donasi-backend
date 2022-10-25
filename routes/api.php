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

// category API
Route::get('/category', [ApiCategoryController::class, "index"]);
Route::get('/category/{slug}', [ApiCategoryController::class, "show"]);
Route::get('/category-home', [ApiCategoryController::class, "categoryHome"]);
