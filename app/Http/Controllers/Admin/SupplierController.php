<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();

        return view("admin.suppliers.index", compact("suppliers"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();

        return view("admin.suppliers.create", compact("suppliers"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255|unique:suppliers,name",
            "email" => "nullable|email:dns|max:255",
            "phone" => [
                "nullable",
                "regex:/^\+39\d{9,10}$/"
            ],
        ]);

        $data = $request->all();

        $newSupplier = new Supplier();
        $newSupplier->name = $data["name"];
        $newSupplier->slug = Str::slug($data['name']);
        $newSupplier->email = $data["email"];
        $newSupplier->phone = $data["phone"];

        $newSupplier->save();

        return redirect()->route('admin.suppliers.index')->with('success', 'Fornitore creato con successo!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        $products = $supplier->products()->orderBy('name')->get();

        return view('admin.suppliers.show', compact('supplier', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view("admin.suppliers.edit", compact("supplier"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "nullable|email:dns|max:255",
            "phone" => [
                "nullable",
                "regex:/^\+39\d{9,10}$/"
            ],
        ]);

        $data = $request->all();

        if ($supplier->name !== $data["name"]) {
            $supplier->slug = Str::slug($data["name"]);
        }

        $supplier->name = $data["name"];
        $supplier->email = $data["email"];
        $supplier->phone = $data["phone"];

        $supplier->save();

        return redirect()->route("admin.suppliers.index", $supplier)->with('success', 'Fornitore aggiornato con successo!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route("admin.suppliers.index")->with("success", "Fornitore cancellato con successo!");
    }
}
