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
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('regular_price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->unsignedTinyInteger('off')->nullable();
            $table->integer('stock')->default(0);
            $table->text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->json('images')->nullable();
            $table->json('categories')->nullable();
            $table->json('tags')->nullable();
            $table->float('rating')->default(0);
            $table->integer('review_count')->default(0);
            $table->boolean('status')->default(1);
            $table->boolean('feature')->default(1);
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
