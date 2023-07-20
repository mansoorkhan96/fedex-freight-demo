<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->text('name');
            $table->double('price');
            $table->string('product_image')->nullable();
            $table->string('upc')->nullable();
            $table->string('uom')->nullable();
            $table->json('freight_data')->nullable();
            $table->json('freight_rates')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
