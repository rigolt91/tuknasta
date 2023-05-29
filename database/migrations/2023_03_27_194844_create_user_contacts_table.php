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
        Schema::create('user_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->string('last_name');
            $table->string('email');
            $table->string('dni')->nullable();
            $table->string('phone')->nullable();
            $table->string('street')->nullable();
            $table->string('between_streets')->nullable();
            $table->string('number')->nullable();
            $table->foreignId('province_id')->nullable()->constrained();
            $table->foreignId('municipality_id')->nullable()->constrained();
            $table->boolean('prefer')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_contacts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['province_id']);
            $table->dropForeign(['municipality_id']);
        });
    }
};
