<?php

use App\Http\Controllers\Api\AnimalController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\UserController;
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

Route::resource('category', CategoryController::class);
Route::resource('city', CityController::class);

Route::get('comment/{id}', [CommentController::class, 'show']);

Route::get('search', [SearchController::class, 'search']);

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::get('animal', [AnimalController::class, 'index']);
Route::get('animal/{id}', [AnimalController::class, 'show']);

Route::get('animals/{id}', [CategoryController::class, 'show']);
Route::get('myads/{id}', [UserController::class, 'myads']); 
Route::middleware('auth:sanctum')->group(function () {
 
  Route::get('favourite/{user_id}', [FavouriteController::class, 'index']);
  Route::post('favourite', [FavouriteController::class, 'store']);
  Route::delete('favourite/{id}', [FavouriteController::class, 'destroy']);
  Route::post('animal', [AnimalController::class, 'store']);
  Route::post('comment', [CommentController::class, 'store']);
  Route::delete('comment/{id}', [CommentController::class, 'destroy']);
  Route::get('getme', [UserController::class, 'getme']);
  Route::get('delete_ads/{id}', [UserController::class, 'delete_ads']);
});