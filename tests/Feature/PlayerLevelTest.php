<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\PlayerLevel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerLevelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create player level configurations
        PlayerLevel::create(['level' => 1, 'experience_required' => 0, 'rewards' => ['coins' => 100]]);
        PlayerLevel::create(['level' => 2, 'experience_required' => 100, 'rewards' => ['coins' => 150]]);
        PlayerLevel::create(['level' => 3, 'experience_required' => 250, 'rewards' => ['coins' => 200]]);
        PlayerLevel::create(['level' => 4, 'experience_required' => 450, 'rewards' => ['coins' => 250]]);
        PlayerLevel::create(['level' => 5, 'experience_required' => 700, 'rewards' => ['coins' => 300]]);
    }

    public function test_player_can_be_created_with_default_level()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);

        $this->assertEquals(1, $player->level);
        $this->assertEquals(0, $player->experience_points);
        $this->assertEquals(0, $player->total_experience_points);
    }

    public function test_player_gains_experience()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);

        $result = $player->addExperience(50);

        $this->assertEquals(50, $player->experience_points);
        $this->assertEquals(50, $player->total_experience_points);
        $this->assertFalse($result['leveled_up']);
        $this->assertEquals(1, $result['current_level']);
    }

    public function test_player_levels_up_when_reaching_threshold()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);

        // Add enough XP to reach level 2 (100 XP required)
        $result = $player->addExperience(100);

        $this->assertTrue($result['leveled_up']);
        $this->assertEquals(1, $result['levels_gained']);
        $this->assertEquals(2, $result['current_level']);
        $this->assertEquals(0, $result['current_xp']); // XP resets after level up
        $this->assertEquals(100, $player->total_experience_points);
    }

    public function test_player_can_level_up_multiple_times()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);

        // Add enough XP to reach level 3 (100 + 250 = 350 XP required)
        $result = $player->addExperience(350);

        $this->assertTrue($result['leveled_up']);
        $this->assertEquals(2, $result['levels_gained']);
        $this->assertEquals(3, $result['current_level']);
        $this->assertEquals(0, $result['current_xp']);
    }

    public function test_player_retains_excess_experience_after_level_up()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);

        // Add 120 XP - should level up to 2 with 20 XP remaining
        $result = $player->addExperience(120);

        $this->assertTrue($result['leveled_up']);
        $this->assertEquals(2, $result['current_level']);
        $this->assertEquals(20, $result['current_xp']);
    }

    public function test_get_experience_to_next_level()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);

        // At level 1 with 0 XP, need 100 XP to reach level 2
        $this->assertEquals(100, $player->getExperienceToNextLevel());

        // Add 30 XP
        $player->addExperience(30);
        $this->assertEquals(70, $player->getExperienceToNextLevel());

        // Add 70 more XP to level up
        $player->addExperience(70);
        $this->assertEquals(250, $player->getExperienceToNextLevel()); // Level 2 to 3 requires 250 XP
    }

    public function test_get_level_progress_percentage()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);

        $this->assertEquals(0.0, $player->getLevelProgress());

        $player->addExperience(50);
        $this->assertEquals(50.0, $player->getLevelProgress()); // 50/100 = 50%

        $player->addExperience(50);
        $this->assertEquals(0.0, $player->getLevelProgress()); // Leveled up, progress resets
    }

    public function test_level_up_includes_rewards()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);

        $result = $player->addExperience(100);

        $this->assertTrue($result['leveled_up']);
        $this->assertNotEmpty($result['rewards']);
        $this->assertEquals(2, $result['rewards'][0]['level']);
        $this->assertEquals(['coins' => 150], $result['rewards'][0]['rewards']);
    }

    public function test_api_get_player_level_info()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);

        $response = $this->getJson("/api/players/{$player->id}/level");

        $response->assertStatus(200)
            ->assertJson([
                'player_id' => $player->id,
                'name' => 'Test Player',
                'level' => 1,
                'experience_points' => 0,
                'total_experience_points' => 0,
                'xp_to_next_level' => 100,
            ]);
    }

    public function test_api_add_experience_to_player()
    {
        $player = Player::create([
            'name' => 'Test Player',
            'email' => 'test@example.com',
        ]);

        $response = $this->postJson("/api/players/{$player->id}/experience", [
            'experience' => 50,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'current_level' => 1,
                    'current_xp' => 50,
                ],
            ]);
    }

    public function test_api_get_all_levels()
    {
        $response = $this->getJson('/api/levels');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'levels' => [
                    '*' => [
                        'id',
                        'level',
                        'experience_required',
                        'rewards',
                    ],
                ],
            ]);
    }

    public function test_api_get_specific_level()
    {
        $response = $this->getJson('/api/levels/2');

        $response->assertStatus(200)
            ->assertJson([
                'level' => [
                    'level' => 2,
                    'experience_required' => 100,
                    'rewards' => ['coins' => 150],
                ],
            ]);
    }

    public function test_api_get_leaderboard()
    {
        // Create multiple players
        $player1 = Player::create(['name' => 'Player 1', 'email' => 'player1@example.com']);
        $player2 = Player::create(['name' => 'Player 2', 'email' => 'player2@example.com']);
        $player3 = Player::create(['name' => 'Player 3', 'email' => 'player3@example.com']);

        $player1->addExperience(100); // Level 2
        $player2->addExperience(350); // Level 3
        $player3->addExperience(50);  // Level 1

        $response = $this->getJson('/api/leaderboard');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'leaderboard' => [
                    '*' => [
                        'id',
                        'name',
                        'level',
                        'total_experience_points',
                    ],
                ],
            ]);

        // Check order - Player 2 should be first (level 3), then Player 1 (level 2)
        $leaderboard = $response->json('leaderboard');
        $this->assertEquals('Player 2', $leaderboard[0]['name']);
        $this->assertEquals(3, $leaderboard[0]['level']);
        $this->assertEquals('Player 1', $leaderboard[1]['name']);
        $this->assertEquals(2, $leaderboard[1]['level']);
    }
}
