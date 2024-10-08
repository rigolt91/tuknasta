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
        Schema::create('user_purchased_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained();
            $table->integer('units');
            $table->double('price');
            $table->double('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_purchased_products', function (Blueprint $table) {
            $table->dropForeign(['user_order_id']);
            $table->dropForeign(['product_id']);
        });
    }
};
