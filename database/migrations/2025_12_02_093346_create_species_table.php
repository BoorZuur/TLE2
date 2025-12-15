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
            $table->string('scientific_name')->default('-');
            $table->string('image')->default('/images/placeholder.png');
            $table->string('beheerder')->default('-');
            $table->text('info')->default('-');
            $table->boolean('locked')->default(true);
            $table->smallInteger('status')->default(1);
            $table->foreignId('habitat_id')->constrained('habitats')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('species');
    }
};
