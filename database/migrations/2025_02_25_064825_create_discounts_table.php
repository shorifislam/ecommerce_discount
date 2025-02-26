<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('discount_type', ['percentage', 'money']);
            $table->decimal('amount', 10, 2);
            $table->decimal('min_cart_total', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamp('active_from')->nullable();
            $table->timestamp('active_to')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
