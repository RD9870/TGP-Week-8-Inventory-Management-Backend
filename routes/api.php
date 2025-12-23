<?php
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ProfitController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('products', [ProductController::class, 'index'])->middleware(CheckUserRole::class.':admin,manager');

    Route::get('products/{id}', [ProductController::class, 'show'])->middleware(CheckUserRole::class.':admin,manager');

    Route::post('products', [ProductController::class, 'store'])->middleware(CheckUserRole::class.':admin,manager');

    Route::put('products/{id}', [ProductController::class, 'update'])->middleware(CheckUserRole::class.':admin');

    Route::delete('products/{id}', [ProductController::class, 'destroy'])->middleware(CheckUserRole::class.':admin');
Route::post('/receipts', [ReceiptController::class, 'store'])->middleware([CheckUserRole::class . ':cashier']);
    Route::get('/monthly-rate', [ProfitController::class, 'monthlyProfitRate']);
    Route::get('/detailed', [ProfitController::class, 'detailedProfits']);

});

