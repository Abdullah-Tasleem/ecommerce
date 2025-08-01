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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            $table->string('name');
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('zip')->nullable();

            $table->string('status')->default('Pending'); // e.g., Pending, Completed, Cancelled

            $table->string('payment_method')->default('cod');
            $table->string('payment_status')->default('pending');
            $table->dateTime('delivered_date')->nullable();
            $table->dateTime('canceled_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
