<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Sellable;
use Illuminate\Http\Request;

class SellableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Sellable::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%$search%");
        }

        $sellables = $query->paginate(8);

        return view("admin.sellables.index", compact("sellables", "categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sellable $sellable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sellable $sellable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sellable $sellable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sellable $sellable)
    {
        //
    }
}
