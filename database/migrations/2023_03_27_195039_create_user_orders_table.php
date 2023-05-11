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
            $table->foreignId('order_status_id')->constrained()->cascadeOnDelete();
            $table->foreignId('delivery_method_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_contact_id')->constrained()->cascadeOnDelete();
            $table->boolean('payment')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_orders');
        $table->dropForeign('users_user_id_foreign');
        $table->dropForeign('user_contacts_user_contact_id_foreign');
        $table->dropForeign('order_statuses_order_status_id_foreign');
        $table->dropForeign('delivery_methods_delivery_method_id_foreign');
        $table->dropForeign('products_product_id_foreign');
    }
};
