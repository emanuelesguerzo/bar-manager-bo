<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sellable;
use Illuminate\Http\Request;

class SellableController extends Controller
{
    public function index() {

        $sellables = Sellable::where("is_visible", true)
        ->with(["category"])
        ->get();

        return response()->json(
            [
                "success" => true,
                "data" => $sellables
            ]
        );

    }

    public function show($slug) {
        
        $sellable = Sellable::where("slug", $slug)
            ->with(["category", "products"])
            ->firstOrFail();

        return response()->json(
            [
                "success" => true,
                "data" => $sellable
            ]
        );
    }
}
