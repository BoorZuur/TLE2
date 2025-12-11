<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_species_unlocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('species_id')->constrained('species')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'species_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_species_unlocks');
    }
};
