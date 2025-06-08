<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SellableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// GET Sellable
Route::get("/sellables", [SellableController::class, "index"]);
Route::get("/sellables/{slug}", [SellableController::class, "show"]);

// POST Order
Route::post("/orders", [OrderController::class, "store"]);