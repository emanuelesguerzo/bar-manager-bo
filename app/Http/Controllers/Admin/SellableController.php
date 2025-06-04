<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Sellable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        $categories = Category::all();

        return view("admin.sellables.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "description" => "nullable|string",
            "price" => "required|numeric|min:0|max:9999.99",
            "image" => "nullable|image",
            "category_id" => "nullable|exists:categories,id",
        ]);

        $data = $request->all();

        $newSellable = new Sellable();
        $newSellable->name = $data["name"];
        $newSellable->slug = Str::slug($data['name']);
        $newSellable->description = $data["description"];
        $newSellable->price = $data["price"];
        $newSellable->is_visible = $request->has("is_visible");
        $newSellable->category_id = $data["category_id"] ?? null;

        if ($request->hasFile("image")) {
            $img_url = Storage::disk("public")->put("sellables", $data["image"]);
            $newSellable->image = $img_url;
        }

        $newSellable->save();

        return redirect()->route('admin.sellables.index')->with('success', 'Prodotto creato con successo!');
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
