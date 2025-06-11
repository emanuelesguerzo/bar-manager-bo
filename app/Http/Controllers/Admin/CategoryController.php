<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return view("admin.categories.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view("admin.categories.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255|unique:categories,name",
            "description" => "nullable|string",
        ]);

        $data = $request->all();

        $newCategory = new Category();
        $newCategory->name = $data["name"];
        $newCategory->slug = Str::slug($data["name"]);
        $newCategory->description = $data["description"];

        $newCategory->save();

        return redirect()->route("admin.categories.index")->with("success", "La categoria $newCategory->name è stata creata con successo!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Prelevo i prodotti della categoria in ordine di nome
        $sellables = $category->sellables()->orderBy("name")->get();

        return view("admin.categories.show", compact("category", "sellables"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view("admin.categories.edit", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            // $category->id ci permette di salvare il nome anche se e' uguale a quello prima
            "name" => "required|string|max:255|unique:categories,name," . $category->id,
            "description" => "nullable|string",
        ]);

        $data = $request->all();

        // Update alla slug solo se cambia il nome
        if ($category->name !== $data["name"]) {
            $category->slug = Str::slug($data["name"]);
        }

        $category->name = $data["name"];
        $category->description = $data["description"];

        $category->save();

        return redirect()->route("admin.categories.index")->with("success", "La categoria $category->name è stata aggiornata con successo!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Errore in caso si voglia cancellare una categoria che ha prodotti associati
        if ($category->sellables()->count() > 0) {
            return redirect()->back()->with("error", "Non puoi eliminare una categoria che ha prodotti associati.");
        }
        
        $category->delete();

        return redirect()->route("admin.categories.index")->with("success", "La categoria $category->name è stata cancellata con successo!");
    }
}
