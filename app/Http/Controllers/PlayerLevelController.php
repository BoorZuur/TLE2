<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\PlayerLevel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PlayerLevelController extends Controller
{
    /**
     * Get player level information.
     */
    public function show(int $playerId): JsonResponse
    {
        $player = Player::findOrFail($playerId);
        
        $levelConfig = $player->levelConfig;
        
        return response()->json([
            'player_id' => $player->id,
            'name' => $player->name,
            'level' => $player->level,
            'experience_points' => $player->experience_points,
            'total_experience_points' => $player->total_experience_points,
            'xp_to_next_level' => $player->getExperienceToNextLevel(),
            'level_progress_percentage' => round($player->getLevelProgress(), 2),
            'current_level_rewards' => $levelConfig ? $levelConfig->rewards : null,
        ]);
    }

    /**
     * Add experience points to a player.
     */
    public function addExperience(Request $request, int $playerId): JsonResponse
    {
        $validated = $request->validate([
            'experience' => 'required|integer|min:1',
        ]);

        $player = Player::findOrFail($playerId);
        $result = $player->addExperience($validated['experience']);

        return response()->json([
            'success' => true,
            'message' => $result['leveled_up'] 
                ? "Player leveled up! Now level {$result['current_level']}"
                : "Experience added successfully",
            'data' => $result,
        ]);
    }

    /**
     * Get all level configurations.
     */
    public function getLevels(): JsonResponse
    {
        $levels = PlayerLevel::getAllLevels();
        
        return response()->json([
            'levels' => $levels,
        ]);
    }

    /**
     * Get specific level configuration.
     */
    public function getLevel(int $level): JsonResponse
    {
        $levelConfig = PlayerLevel::getByLevel($level);
        
        if (!$levelConfig) {
            return response()->json([
                'error' => 'Level not found',
            ], 404);
        }
        
        return response()->json([
            'level' => $levelConfig,
        ]);
    }

    /**
     * Get player leaderboard sorted by level and XP.
     */
    public function leaderboard(): JsonResponse
    {
        $players = Player::orderBy('level', 'desc')
            ->orderBy('total_experience_points', 'desc')
            ->limit(100)
            ->get()
            ->map(function ($player) {
                return [
                    'id' => $player->id,
                    'name' => $player->name,
                    'level' => $player->level,
                    'total_experience_points' => $player->total_experience_points,
                ];
            });

        return response()->json([
            'leaderboard' => $players,
        ]);
    }
}
