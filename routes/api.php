<?php

use App\Http\Controllers\Api\SellableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get("/sellables", [SellableController::class, "index"]);

Route::get("/sellables/{slug}", [SellableController::class, "show"]);