<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'level',
        'experience_points',
        'total_experience_points',
    ];

    protected $casts = [
        'level' => 'integer',
        'experience_points' => 'integer',
        'total_experience_points' => 'integer',
    ];

    /**
     * Add experience points to the player and check for level ups.
     */
    public function addExperience(int $amount): array
    {
        $this->experience_points += $amount;
        $this->total_experience_points += $amount;
        
        $leveledUp = false;
        $levelsGained = 0;
        $rewards = [];

        // Check if player can level up
        while ($this->canLevelUp()) {
            $this->levelUp();
            $leveledUp = true;
            $levelsGained++;
            
            // Get rewards for the new level
            $levelConfig = PlayerLevel::where('level', $this->level)->first();
            if ($levelConfig && $levelConfig->rewards) {
                $rewards[] = [
                    'level' => $this->level,
                    'rewards' => $levelConfig->rewards
                ];
            }
        }

        $this->save();

        return [
            'leveled_up' => $leveledUp,
            'levels_gained' => $levelsGained,
            'current_level' => $this->level,
            'current_xp' => $this->experience_points,
            'xp_to_next_level' => $this->getExperienceToNextLevel(),
            'rewards' => $rewards,
        ];
    }

    /**
     * Check if player has enough XP to level up.
     */
    protected function canLevelUp(): bool
    {
        $nextLevel = PlayerLevel::where('level', $this->level + 1)->first();
        
        if (!$nextLevel) {
            return false; // Max level reached
        }

        return $this->experience_points >= $nextLevel->experience_required;
    }

    /**
     * Level up the player.
     */
    protected function levelUp(): void
    {
        $nextLevel = PlayerLevel::where('level', $this->level + 1)->first();
        
        if ($nextLevel) {
            $this->experience_points -= $nextLevel->experience_required;
            $this->level++;
        }
    }

    /**
     * Get experience required for next level.
     */
    public function getExperienceToNextLevel(): ?int
    {
        $nextLevel = PlayerLevel::where('level', $this->level + 1)->first();
        
        if (!$nextLevel) {
            return null; // Max level reached
        }

        return $nextLevel->experience_required - $this->experience_points;
    }

    /**
     * Get progress percentage to next level.
     */
    public function getLevelProgress(): ?float
    {
        $nextLevel = PlayerLevel::where('level', $this->level + 1)->first();
        
        if (!$nextLevel) {
            return 100.0; // Max level reached
        }

        $required = $nextLevel->experience_required;
        if ($required == 0) {
            return 100.0;
        }

        return min(100.0, ($this->experience_points / $required) * 100);
    }

    /**
     * Get the player's level configuration.
     */
    public function levelConfig()
    {
        return $this->hasOne(PlayerLevel::class, 'level', 'level');
    }
}
