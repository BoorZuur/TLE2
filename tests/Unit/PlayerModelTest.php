<?php

namespace Tests\Unit;

use App\Models\Player;
use App\Models\PlayerLevel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerModelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create player level configurations
        PlayerLevel::create(['level' => 1, 'experience_required' => 0, 'rewards' => ['coins' => 100]]);
        PlayerLevel::create(['level' => 2, 'experience_required' => 100, 'rewards' => ['coins' => 150]]);
        PlayerLevel::create(['level' => 3, 'experience_required' => 250, 'rewards' => ['coins' => 200]]);
    }

    public function test_player_model_has_correct_fillable_attributes()
    {
        $player = new Player();
        
        $expected = [
            'name',
            'email',
            'level',
            'experience_points',
            'total_experience_points',
        ];

        $this->assertEquals($expected, $player->getFillable());
    }

    public function test_player_model_casts_attributes_correctly()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
            'level' => '2',
            'experience_points' => '150',
            'total_experience_points' => '250',
        ]);

        $this->assertIsInt($player->level);
        $this->assertIsInt($player->experience_points);
        $this->assertIsInt($player->total_experience_points);
    }

    public function test_can_level_up_returns_false_when_not_enough_xp()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);

        $player->experience_points = 50;
        
        $reflection = new \ReflectionClass($player);
        $method = $reflection->getMethod('canLevelUp');
        $method->setAccessible(true);
        
        $this->assertFalse($method->invoke($player));
    }

    public function test_can_level_up_returns_true_when_enough_xp()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);

        $player->experience_points = 100;
        
        $reflection = new \ReflectionClass($player);
        $method = $reflection->getMethod('canLevelUp');
        $method->setAccessible(true);
        
        $this->assertTrue($method->invoke($player));
    }

    public function test_can_level_up_returns_false_at_max_level()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
            'level' => 3, // Max level in our test setup
        ]);

        $player->experience_points = 1000;
        
        $reflection = new \ReflectionClass($player);
        $method = $reflection->getMethod('canLevelUp');
        $method->setAccessible(true);
        
        $this->assertFalse($method->invoke($player));
    }

    public function test_level_up_increments_level_and_adjusts_xp()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);

        $player->experience_points = 120; // 100 required for level 2, 20 remaining
        
        $reflection = new \ReflectionClass($player);
        $method = $reflection->getMethod('levelUp');
        $method->setAccessible(true);
        
        $method->invoke($player);
        
        $this->assertEquals(2, $player->level);
        $this->assertEquals(20, $player->experience_points);
    }

    public function test_get_experience_to_next_level_returns_null_at_max_level()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
            'level' => 3, // Max level
        ]);

        $this->assertNull($player->getExperienceToNextLevel());
    }

    public function test_get_level_progress_returns_100_at_max_level()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
            'level' => 3, // Max level
        ]);

        $this->assertEquals(100.0, $player->getLevelProgress());
    }

    public function test_add_experience_updates_total_experience()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);

        $player->addExperience(50);
        $this->assertEquals(50, $player->total_experience_points);

        $player->addExperience(30);
        $this->assertEquals(80, $player->total_experience_points);

        // Even after leveling up, total XP should continue to increase
        $player->addExperience(20); // This should level up (100 total)
        $this->assertEquals(100, $player->total_experience_points);
    }

    public function test_level_config_relationship()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
            'level' => 2,
        ]);

        $levelConfig = $player->levelConfig;
        
        $this->assertNotNull($levelConfig);
        $this->assertEquals(2, $levelConfig->level);
        $this->assertEquals(100, $levelConfig->experience_required);
    }
}
