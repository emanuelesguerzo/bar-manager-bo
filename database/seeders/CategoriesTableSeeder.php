<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = include database_path('data/CategoriesData.php');

        foreach ($categories as $category) {

            $newCategory = new Category();

            $newCategory->name = $category["name"];
            $newCategory->slug = Str::slug($category["name"]);
            $newCategory->description = $category["description"];
            
            $newCategory->save();
            
        }
    }
}
