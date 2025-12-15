<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->enum('product_type', ['animal', 'powerup'])->default('powerup');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('image_url')->nullable();
            $table->decimal('price', 8, 2);
            $table->enum('currency_type', ['coins', 'real_money', 'qr'])->default('coins');
            $table->string('species_tag')->nullable();
            $table->json('powerup_effects')->nullable();
            $table->string('qr_filename')->nullable();
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
