<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SellableController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route("dashboard");
    }
    return view('/auth/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(["auth", "verified"])
    ->name("admin.")
    ->prefix("admin")
    ->group( function () {

        Route::resource("sellables", SellableController::class);
        Route::resource("categories", CategoryController::class);
        Route::resource("suppliers", SupplierController::class);
        Route::resource("products", ProductController::class);
        Route::resource("orders", OrderController::class);
        

        // Aggiunta e rimozione prodotti in magazzino
        Route::post("/products/{product}/add-stock", [ProductController::class, "addStock"])->name("products.addStock");
        Route::post("/products/{product}/remove-stock", [ProductController::class, "removeStock"])->name("products.removeStock");
        Route::post("/products/{product}/clear-stock", [ProductController::class, "clearStock"])->name("products.clearStock");
    });

require __DIR__.'/auth.php';
