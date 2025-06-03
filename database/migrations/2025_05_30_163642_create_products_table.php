<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            
            $table->id();
            
            $table->string("name");
            $table->string('slug')->unique();
            $table->string("brand")->nullable();
            $table->decimal("price", 6, 2);
            $table->bigInteger("units_in_stock");
            $table->bigInteger("stock_ml")->nullable();
            $table->bigInteger("stock_g")->nullable();
            $table->bigInteger("unit_size_ml")->nullable();
            $table->bigInteger("unit_size_g")->nullable();
            $table->string("image")->nullable();
            $table->foreignId("supplier_id")->nullable()->constrained()->onDelete("set null");

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
