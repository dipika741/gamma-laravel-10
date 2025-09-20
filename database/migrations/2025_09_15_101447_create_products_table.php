<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    if (!Schema::hasTable('products')) {

    // Schema::create('products', function (Blueprint $table) {
    //     $table->id();
    //     $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
    //     $table->string('name');
    //     $table->text('description')->nullable();
    //     $table->decimal('original_price', 10, 2);
    //     $table->unsignedTinyInteger('discount_percentage')->default(0);
    //     $table->decimal('discounted_price', 10, 2);
    //     $table->float('rating')->default(0);
    //     $table->timestamps();
    // });

    // Schema::create('products', function (Blueprint $table) {
    //     $table->id();
    
    //     $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
    //     $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->onDelete('cascade');
    //     $table->foreignId('subsubcategory_id')->nullable()->constrained('subsubcategories')->onDelete('cascade');
    
    //     $table->string('name');
    //     $table->text('description')->nullable();
    //     $table->decimal('original_price', 10, 2);
    //     $table->unsignedTinyInteger('discount_percentage')->default(0);
    //     $table->decimal('discounted_price', 10, 2);
    //     $table->float('rating')->default(0);
    
    //     $table->timestamps();
    // });

    Schema::create('products', function (Blueprint $table) {
        $table->id();
    
        $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
    
        // must be nullable if optional
        $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->onDelete('cascade');
    
        $table->foreignId('sub_sub_category_id')->nullable()->constrained('subsub_categories')->onDelete('cascade');
    
        $table->string('name');
        $table->text('title')->nullable();
        $table->text('description')->nullable();
        $table->decimal('original_price', 10, 2);
        $table->unsignedTinyInteger('discount_percentage')->default(0);
        $table->decimal('discounted_price', 10, 2);
        $table->float('rating')->default(0);
        $table->string('slug')->unique();
        $table->timestamps();
    });
    
    
    
    
}
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
