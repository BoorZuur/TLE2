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
        Schema::disableForeignKeyConstraints();

        Schema::create('user_friend', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id1');
            $table->foreign('user_id1')->references('id')->on('users');
            $table->bigInteger('user_id2');
            $table->foreign('user_id2')->references('id')->on('users');
            $table->timestamp('sent_at');
            $table->boolean('is_approved');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_friend');
    }
};
