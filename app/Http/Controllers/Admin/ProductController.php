<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $suppliers = Supplier::all();
        $query = Product::query();

        if ($search = $request->input("search")) {
            $query->where(function ($q) use ($search) {
                $q->where("name", "like", "%$search%")->orWhere("brand", "like", "%$search%");
            });
        }

        $products = $query->paginate(8);

        return view("admin.products.index", compact("products", "suppliers"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();

        return view("admin.products.create", compact("suppliers"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255|unique:products,name",
            "brand" => "nullable|string|max:255",
            "price" => "required|numeric|min:0|max:9999.99",
            "units_in_stock" => "required|integer|min:0",
            "unit_size_ml" => "nullable|integer|min:0",
            "unit_size_g" => "nullable|integer|min:0",
            "image" => "nullable|image",
            "supplier_id" => "nullable|exists:suppliers,id",
            "stock_quantity" => "nullable|integer|min:0",
            "stock_unit" => "nullable|in:ml,g",
            "stock_alert_threshold" => "required|integer|min:1",
        ]);

        $data = $request->all();

        $newProduct = new Product();
        $newProduct->name = $data["name"];
        $newProduct->slug = Str::slug($data["name"]);
        $newProduct->brand = $data["brand"];
        $newProduct->price = $data["price"];
        $newProduct->units_in_stock = $data["units_in_stock"];
        $newProduct->stock_alert_threshold = $data['stock_alert_threshold'];

        if ($data["stock_unit"] === "ml") {
            $newProduct->unit_size_ml = $data["stock_quantity"];
            $newProduct->stock_ml = $data["stock_quantity"] * $data["units_in_stock"];
            $newProduct->unit_size_g = null;
            $newProduct->stock_g = null;
        } elseif ($data["stock_unit"] === "g") {
            $newProduct->unit_size_g = $data["stock_quantity"];
            $newProduct->stock_g = $data["stock_quantity"] * $data["units_in_stock"];
            $newProduct->unit_size_ml = null;
            $newProduct->stock_ml = null;
        }

        $newProduct->supplier_id = $data["supplier_id"] ?? null;

        if ($request->hasFile("image")) {
            $img_url = Storage::disk("public")->put("products", $data["image"]);
            $newProduct->image = $img_url;
        }

        $newProduct->save();

        return redirect()->route("admin.products.index")->with("success", "Il prodotto $newProduct->name è stato creato con successo!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $previous = Product::where("id", "<", $product->id)->orderBy("id", "desc")->first();
        $next = Product::where("id", ">", $product->id)->orderBy("id")->first();

        // Se siamo al primo o all'ultimo cicliamo
        if (!$previous) {
            $previous = Product::orderBy("id", "desc")->first();
        }

        if (!$next) {
            $next = Product::orderBy("id")->first();
        }

        return view("admin.products.show", compact("product", "previous", "next"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $suppliers = Supplier::all();

        return view("admin.products.edit", compact("product", "suppliers"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            "name" => "required|string|max:255|unique:products,name," . $product->id,
            "brand" => "nullable|string|max:255",
            "price" => "required|numeric|min:0|max:9999.99",
            "units_in_stock" => "required|integer|min:0",
            "stock_quantity" => "nullable|integer|min:0",
            "stock_unit" => "nullable|in:ml,g",
            "image" => "nullable|image",
            "supplier_id" => "nullable|exists:suppliers,id",
            "stock_alert_threshold" => "required|integer|min:1",
        ]);

        $data = $request->all();

        if ($product->name !== $data["name"]) {
            $product->slug = Str::slug($data["name"]);
        }

        $product->name = $data["name"];
        $product->brand = $data["brand"];
        $product->price = $data["price"];
        $product->units_in_stock = $data["units_in_stock"];
        $product->stock_alert_threshold = $data['stock_alert_threshold'];

        if ($data["stock_unit"] === "ml") {
            $product->unit_size_ml = $data["stock_quantity"];
            $product->stock_ml = $data["stock_quantity"] * $data["units_in_stock"];
            $product->unit_size_g = null;
            $product->stock_g = null;
        } elseif ($data["stock_unit"] === "g") {
            $product->unit_size_g = $data["stock_quantity"];
            $product->stock_g = $data["stock_quantity"] * $data["units_in_stock"];
            $product->unit_size_ml = null;
            $product->stock_ml = null;
        }

        $product->supplier_id = $data["supplier_id"] ?? null;

        if ($request->hasFile("image")) {

            // Cancello l'immagine precedente se esiste
            if ($product->image && Storage::disk("public")->exists($product->image)) {
                Storage::disk("public")->delete($product->image);
            }

            // Salvo la nuova immagine
            $img_url = Storage::disk("public")->put("products", $request->file("image"));
            $product->image = $img_url;
        }

        if ($request->has("delete_image")) {
            if ($product->image && Storage::disk("public")->exists($product->image)) {
                Storage::disk("public")->delete($product->image);
            }
            $product->image = null;
        }

        $product->save();

        return redirect()->route("admin.products.index")->with("success", "Il prodotto $product->name è stato aggiornato con successo!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk("public")->exists($product->image)) {
            Storage::disk("public")->delete($product->image);
        }

        $product->delete();

        return redirect()->route("admin.products.index")->with("success", "Il prodotto $product->name è stato cancellato con successo!");
    }

    /**
     * Aggiunta merce al magazzino
     */
    public function addStock(Request $request, Product $product)
    {
        $request->validate([
            'new_units' => 'required|integer|min:1',
        ]);

        $newUnits = $request->input('new_units');

        // Aggiungo le nuove unità al conteggio esistente
        $product->units_in_stock += $newUnits;

        // Aggiorno stock_ml o stock_g a seconda del tipo
        if ($product->unit_size_ml) {
            $product->stock_ml += $newUnits * $product->unit_size_ml;
        } elseif ($product->unit_size_g) {
            $product->stock_g += $newUnits * $product->unit_size_g;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', "Hai aggiunto $newUnits unità a $product->name!");
    }

    /**
     * Rimozione merce in magazzino
     */
    public function removeStock(Request $request, Product $product)
    {
        $request->validate([
            'remove_units' => 'required|integer|min:1',
        ]);

        $removeUnits = $request->input('remove_units');

        // Non rimuovere più di quanto disponibile
        if ($removeUnits > $product->units_in_stock) {
            return redirect()->back()->with('error', "Non puoi rimuovere più unità di quelle presenti in magazzino!");
        }

        $product->units_in_stock -= $removeUnits;

        if ($product->unit_size_ml) {
            $product->stock_ml -= $removeUnits * $product->unit_size_ml;
        } elseif ($product->unit_size_g) {
            $product->stock_g -= $removeUnits * $product->unit_size_g;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', "Hai scaricato $removeUnits unità da $product->name!");
    }

    /**
     * Scarico magazzino completo
     */
    public function clearStock(Product $product)
    {
        $product->stock_ml = null;
        $product->stock_g = null;
        $product->units_in_stock = 0;
        $product->save();

        return redirect()->route("admin.products.index")
            ->with("success", "Scarico magazzino completo di $product->name.");
    }

}
