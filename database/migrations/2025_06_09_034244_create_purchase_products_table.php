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
        Schema::create('purchase_products', function (Blueprint $table) {
            
          

            
            $table->id();

            // Add this column first
            $table->unsignedBigInteger('purchase_id');

            // Other columns
            $table->unsignedBigInteger('product_id');
            $table->decimal('quantity', 8, 2)->default(0);
            $table->decimal('price', 8, 2)->default(0);
            $table->json('data')->nullable();
            $table->timestamps();

            // Then add the foreign keys
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_products');
    }
};
