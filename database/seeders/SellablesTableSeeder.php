<?php

namespace Database\Seeders;

use App\Models\Sellable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SellablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellables = include database_path('data/SellablesData.php');

        foreach ($sellables as $sellable) {

            $newSellable = new Sellable();

            $newSellable->name = $sellable["name"];
            $newSellable->slug = Str::slug($sellable["name"]);
            $newSellable->description = $sellable["description"];
            $newSellable->price = $sellable["price"];
            $newSellable->image = $sellable["image"];
            $newSellable->is_visible = $sellable["is_visible"];
            $newSellable->category_id = $sellable["category_id"];

            $newSellable->save();
            
        }
    }
}
