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
        Schema::create('user_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->foreignId('order_status_id')->constrained();
            $table->foreignId('delivery_method_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('user_contact_id')->constrained();
            $table->boolean('payment')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_orders', function (Blueprint $table) {
            $table->dropForeign(['order_status_id']);
            $table->dropForeign(['delivery_method_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['user_contact_id']);
        });
    }
};
