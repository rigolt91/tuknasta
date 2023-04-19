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
            $table->string('image');
            $table->string('name')->unique();
            $table->string('sku')->unique();
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->text('description');
            $table->double('price');
            $table->double('previous_price')->nullable();
            $table->integer('stock');
            $table->boolean('show')->default(true);
            $table->boolean('recommend')->default(false);
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subcategory_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        $table->dropForeign('categories_category_id_foreign');
        $table->dropForeign('subcategories_subcategory_id_foreign');
        $table->dropForeign('branches_branch_id_foreign');
    }
};
