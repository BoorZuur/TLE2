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
        Schema::create('player_levels', function (Blueprint $table) {
            $table->id();
            $table->integer('level')->unique();
            $table->integer('experience_required');
            $table->json('rewards')->nullable();
            $table->timestamps();
        });

        // Seed initial levels
        $levels = [
            ['level' => 1, 'experience_required' => 0, 'rewards' => json_encode(['coins' => 100])],
            ['level' => 2, 'experience_required' => 100, 'rewards' => json_encode(['coins' => 150])],
            ['level' => 3, 'experience_required' => 250, 'rewards' => json_encode(['coins' => 200])],
            ['level' => 4, 'experience_required' => 450, 'rewards' => json_encode(['coins' => 250])],
            ['level' => 5, 'experience_required' => 700, 'rewards' => json_encode(['coins' => 300])],
            ['level' => 6, 'experience_required' => 1000, 'rewards' => json_encode(['coins' => 350])],
            ['level' => 7, 'experience_required' => 1400, 'rewards' => json_encode(['coins' => 400])],
            ['level' => 8, 'experience_required' => 1900, 'rewards' => json_encode(['coins' => 450])],
            ['level' => 9, 'experience_required' => 2500, 'rewards' => json_encode(['coins' => 500])],
            ['level' => 10, 'experience_required' => 3200, 'rewards' => json_encode(['coins' => 600])],
        ];

        foreach ($levels as $level) {
            DB::table('player_levels')->insert($level);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_levels');
    }
};
