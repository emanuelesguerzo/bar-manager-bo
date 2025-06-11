<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Grazie alla funzione che si trova nel model Product prelevo prodotti che hanno una quantita' inferiore alla threshold impostata
        $lowStockProducts = Product::lowStock()->get();

        return view('dashboard', compact('lowStockProducts'));
    }
}
