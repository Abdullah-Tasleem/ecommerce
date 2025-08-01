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
        Schema::create('coupons', function (Blueprint $table) {

            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();

            // Discount details
            $table->enum('discount_type', ['fixed', 'percent']);
            $table->decimal('discount_value', 8, 2)->nullable();
            $table->decimal('max_discount_amount', 8, 2)->nullable();
            $table->decimal('min_cart_value', 8, 2)->nullable();

            // Validity
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // Usage Limits
            $table->integer('usage_limit')->nullable(); 
            $table->integer('limit_per_user')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive'])->default('active');

            // Flags
            $table->boolean('first_time_users_only')->default(false);
            $table->boolean('registered_users_only')->default(true);
            $table->boolean('exclude_sale_items')->default(true);
            $table->boolean('auto_apply')->default(false);

            // Category & Product restrictions
            $table->json('eligible_categories')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
