<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('species', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('scientific_name')->default('-')->nullable();
            $table->string('image')->default('/images/placeholder.png')->nullable();
            $table->string('beheerder')->default('-')->nullable();
            $table->text('info')->default('-')->nullable();
            $table->boolean('locked')->default(true);
            $table->smallInteger('status')->default(1);
            $table->foreignId('habitat_id')->constrained('habitats')->cascadeOnDelete()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('species');
    }
};
