<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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

        // Filtro per nome
        if ($search = $request->input("search")) {
            $query->where("name", "like", "%$search%");
        }

        // Filtro per categoria 
        if ($categoryId = $request->input("category_id")) {
            $query->where("category_id", $categoryId);
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
        $products = Product::orderBy('name')->get();

        return view("admin.sellables.create", compact("categories", "products"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255|unique:sellables,name",
            "description" => "nullable|string",
            "price" => "required|numeric|min:0|max:9999.99",
            "image" => "nullable|image",
            "category_id" => "nullable|exists:categories,id",
            "product_id.*" => "nullable|exists:products,id",
            "quantity.*" => "nullable|integer|min:1",
            "unit.*" => "nullable|in:ml,g,pz",
        ]);

        $data = $request->all();

        $newSellable = new Sellable();
        $newSellable->name = $data["name"];
        $newSellable->slug = Str::slug($data["name"]);
        $newSellable->description = $data["description"];
        $newSellable->price = $data["price"];
        $newSellable->is_visible = $request->has("is_visible");
        $newSellable->category_id = $data["category_id"] ?? null;

        if ($request->hasFile("image")) {
            $img_url = Storage::disk("public")->put("sellables", $data["image"]);
            $newSellable->image = $img_url;
        }

        $newSellable->save();

        // Costruisce un array se gli ingredienti sono presenti per la tabella ponte
        $ingredients = [];

        if (isset($data['product_id'])) {
            foreach ($data['product_id'] as $index => $productId) {
                if ($productId) {
                    $ingredients[$productId] = [
                        'quantity' => $data['quantity'][$index] ?? 1,
                        'unit' => $data['unit'][$index] ?? null,
                    ];
                }
            }

            $newSellable->products()->sync($ingredients);
        }

        return redirect()->route("admin.sellables.index")->with("success", "Il prodotto $newSellable->name è stato creato con successo!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Sellable $sellable)
    {
        $previous = Sellable::where("id", "<", $sellable->id)->orderBy("id", "desc")->first();
        $next = Sellable::where("id", ">", $sellable->id)->orderBy("id")->first();

        // Se siamo al primo o all'ultimo cicliamo
        if (!$previous) {
            $previous = Sellable::orderBy("id", "desc")->first();
        }

        if (!$next) {
            $next = Sellable::orderBy("id")->first();
        }

        return view("admin.sellables.show", compact("sellable", "previous", "next"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sellable $sellable)
    {
        $categories = Category::all();
        $products = Product::orderBy('name')->get();

        return view("admin.sellables.edit", compact("sellable", "categories", "products"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sellable $sellable)
    {
        $request->validate([
            "name" => "required|string|max:255|unique:sellables,name," . $sellable->id,
            "description" => "nullable|string",
            "price" => "required|numeric|min:0|max:9999.99",
            "image" => "nullable|image",
            "category_id" => "nullable|exists:categories,id",
            "product_id.*" => "nullable|exists:products,id",
            "quantity.*" => "nullable|integer|min:1",
            "unit.*" => "nullable|in:ml,g,pz",
        ]);

        $data = $request->all();

        if ($sellable->name !== $data["name"]) {
            $sellable->slug = Str::slug($data["name"]);
        }

        $sellable->name = $data["name"];
        $sellable->description = $data["description"];
        $sellable->price = $data["price"];
        $sellable->is_visible = $request->has("is_visible");
        $sellable->category_id = $data["category_id"];


        if ($request->hasFile("image")) {
            // Cancella l'immagine precedente se esiste
            if ($sellable->image && Storage::disk("public")->exists($sellable->image)) {
                Storage::disk("public")->delete($sellable->image);
            }

            // Salva la nuova immagine
            $img_url = Storage::disk("public")->put("sellables", $data["image"]);
            $sellable->image = $img_url;
        }

        if ($request->has("delete_image")) {
            if ($sellable->image && Storage::disk("public")->exists($sellable->image)) {
                Storage::disk("public")->delete($sellable->image);
            }
            $sellable->image = null;
        }

        $sellable->save();

        $ingredients = [];

        if (isset($data['product_id'])) {
            foreach ($data['product_id'] as $index => $productId) {
                if ($productId) {
                    $ingredients[$productId] = [
                        'quantity' => $data['quantity'][$index] ?? 1,
                        'unit' => $data['unit'][$index] ?? null,
                    ];
                }
            }
        }

        $sellable->products()->sync($ingredients);

        return redirect()->route("admin.sellables.show", $sellable)->with("success", "Il prodotto $sellable->name è stato aggiornato con successo!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sellable $sellable)
    {
        $sellable->products()->detach();

        if ($sellable->image && Storage::disk('public')->exists($sellable->image)) {
            Storage::disk('public')->delete($sellable->image);
        }

        $sellable->delete();

        return redirect()->route("admin.sellables.index")->with("success", "Il prodotto $sellable->name è stato cancellato con successo!");
    }
}
