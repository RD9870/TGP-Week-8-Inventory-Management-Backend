<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ManagerMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//login rout open for unauthorized users
Route::post('/login',[AuthController::class,'login']);

//logout route open only to authorized user (admin, customer, authour)
Route::post('/logout',[AuthController::class,'logout'])->middleware(['auth:sanctum']);


//admin routes
Route::prefix('admin')->middleware(['auth:sanctum',AdminMiddleware::class])->group(function(){
    // //rout that gets all books and if the request has a cat param only books with that cat is shown
    // Route::apiResource('book',CustomerBookController::class)->only(['index','show']);
    // //route to show all the cart items and remove a cart item
    // Route::apiResource('cart',CartController::class)->except('store');
    // //route to add new book to cart
    // Route::post('cart/{book}',[CartController::class,'store']);
    // //route to view past orders
    // Route::apiResource('orders',OrderController::class);

    //User crud route
        Route::apiResource('users',UserController::class);
    //category crud route
        Route::apiResource('categories',CategoryController::class);
    //subcategory crud route
        Route::apiResource('subcategories',SubcategoryController::class);
});


//manager routes
Route::prefix('manager')->middleware(['auth:sanctum', ManagerMiddleware::class])->group(function(){
    //category crud route
        Route::apiResource('categories',CategoryController::class)->only(['index','show','store']);
});
