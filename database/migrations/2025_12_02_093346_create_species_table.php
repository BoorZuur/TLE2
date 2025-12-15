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
            $table->string('scientific_name')->nullable();
            $table->foreignId('habitat_id')->nullable()->constrained('habitats')->nullOnDelete();
            $table->text('info')->nullable();
            $table->string('image')->nullable();
            $table->string('beheerder')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('species');
    }
};
