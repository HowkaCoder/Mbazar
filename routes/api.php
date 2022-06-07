<?php

use App\Http\Controllers\AdvertiseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\MainUserController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register' , [MainUserController::class , 'register']);

Route::post('login' , [MainUserController::class , 'login']);


// Route::middleware('auth:sanctum')->group( function() {

    route::post('logout' , [MainUserController::class , 'logout']);
    route::get('main' , [MainPageController::class , 'index']);
    route::resource('advertises' , AdvertiseController::class);
    route::post('/advertises/update' , [AdvertiseController::class , "upbeat"]);
    route::get('/advertises/detail/{id}' , [ AdvertiseController::class , 'detail'] );
    route::resource('profile' , ProfileController::class);
    route::resource('categories' , CategoryController::class)/*->only(['index' , 'story']) */; 
    route::resource('favorites' , FavoriteController::class);

    # CATEGORY SHOW-FUNCTION
    // route::get('/categories/{category}' , function(Category $category) {return $category ;});

    route::resource('cities' , CityController::class);

// });



// Route::resource('users' , \App\Http\Controllers\UserController::class);

