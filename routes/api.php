<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix("v1")->group(function () {

    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"]);

    Route::middleware("auth:sanctum")->group(function () {
        Route::get('/me', [ProfileController::class, 'me']);

        Route::post("logout", [AuthController::class, "logout"]);
        Route::apiResource("products", ProductController::class);
        Route::post("products/restore/{id?}", [ProductController::class, 'restore'])->name("products.restore");

        Route::apiResource("clients", ClientController::class);
        Route::post("clients/restore/{id?}", [ClientController::class, 'restore'])->name("clients.restore");

        Route::apiResource("orders", OrderController::class);
        Route::post("orders/restore/{id?}", [OrderController::class, 'restore'])->name("orders.restore");
    });
});
