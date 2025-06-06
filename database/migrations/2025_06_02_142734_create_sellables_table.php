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
        Schema::create('sellables', function (Blueprint $table) {

            $table->id();

            $table->string("name");
            $table->string("slug")->unique();
            $table->text("description")->nullable();
            $table->decimal("price", 6, 2);
            $table->string("image")->nullable();
            $table->boolean("is_visible")->default(true);
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellables');
    }
};
