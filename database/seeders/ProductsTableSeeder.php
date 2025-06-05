<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = include database_path("data/ProductsData.php");

        foreach($products as $product) {

            $newProduct = new Product();

            $newProduct->name = $product["name"];
            $newProduct->slug = Str::slug($product["name"]);
            $newProduct->brand = $product["brand"];
            $newProduct->price = $product["price"];
            $newProduct->units_in_stock = $product["units_in_stock"];
            $newProduct->stock_ml = $product["stock_ml"];
            $newProduct->stock_g = $product["stock_g"];
            $newProduct->unit_size_ml = $product["unit_size_ml"];
            $newProduct->unit_size_g = $product["unit_size_g"];
            $newProduct->image = $product["image"];
            $newProduct->supplier_id = $product["supplier_id"];

            $newProduct->save();

        }
    }
}
