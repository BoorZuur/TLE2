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
        Schema::disableForeignKeyConstraints();

        Schema::create('species', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('habitat_tag');
            $table->string('scientific_name')->default('-');
            $table->string('image')->default('/images/placeholder.png');
            $table->string('beheerder')->default('-');
            $table->text('info')->default('-');
            $table->boolean('locked')->default(true);

            $table->foreign('habitat_tag')->references('id')->on('habitats');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('species');
    }
};
