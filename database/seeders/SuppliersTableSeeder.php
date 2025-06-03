<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = include database_path('data/SuppliersData.php');

        foreach ($suppliers as $supplier) {

           $newSupplier = new Supplier();
           
           $newSupplier->name = $supplier["name"];
           $newSupplier->slug = Str::slug($supplier["name"]);
           $newSupplier->email = $supplier["email"];
           $newSupplier->phone = $supplier["phone"];

           $newSupplier->save();

        }

    }
}
