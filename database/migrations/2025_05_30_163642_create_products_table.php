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
            $table->string("name");
            $table->string("brand")->nullable();
            $table->text("description")->nullable();
            $table->decimal("price", 6, 2); // es. 9999.99
            $table->unsignedInteger("quantity")->default(0);
            $table->boolean("is_available")->default(true);
            $table->boolean("is_visible")->default(true);
            $table->string("image")->nullable();

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
