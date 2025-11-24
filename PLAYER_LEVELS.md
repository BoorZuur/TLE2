# Player Levels System Documentation

## Overview

This system implements a comprehensive player leveling and experience (XP) progression system for TLE2. Players can gain experience points through various activities and automatically level up when reaching XP thresholds.

## Features

- **Experience Points (XP) System**: Players accumulate XP from various in-game activities
- **Automatic Level-Up**: Players automatically level up when reaching required XP thresholds
- **Level Rewards**: Each level grants rewards (e.g., coins) to players
- **Multiple Level Gains**: Players can gain multiple levels from a single XP addition
- **Progress Tracking**: Track current level, XP progress, and XP to next level
- **Leaderboard**: View top players sorted by level and total XP

## Database Schema

### Players Table
- `id`: Primary key
- `name`: Player name
- `email`: Player email (unique)
- `level`: Current level (default: 1)
- `experience_points`: XP progress towards next level
- `total_experience_points`: Total XP earned throughout gameplay
- `timestamps`: Created and updated timestamps

### Player Levels Table
- `id`: Primary key
- `level`: Level number (unique)
- `experience_required`: XP required to reach this level from previous level
- `rewards`: JSON field containing rewards for reaching this level
- `timestamps`: Created and updated timestamps

## Level Configuration

The system comes pre-configured with 10 levels:

| Level | XP Required | Rewards |
|-------|-------------|---------|
| 1     | 0           | 100 coins |
| 2     | 100         | 150 coins |
| 3     | 250         | 200 coins |
| 4     | 450         | 250 coins |
| 5     | 700         | 300 coins |
| 6     | 1000        | 350 coins |
| 7     | 1400        | 400 coins |
| 8     | 1900        | 450 coins |
| 9     | 2500        | 500 coins |
| 10    | 3200        | 600 coins |

## API Endpoints

### Get Player Level Information
```
GET /api/players/{playerId}/level
```

Returns:
```json
{
  "player_id": 1,
  "name": "Player Name",
  "level": 2,
  "experience_points": 50,
  "total_experience_points": 150,
  "xp_to_next_level": 200,
  "level_progress_percentage": 20.0,
  "current_level_rewards": {
    "coins": 150
  }
}
```

### Add Experience to Player
```
POST /api/players/{playerId}/experience
```

Request Body:
```json
{
  "experience": 100
}
```

Response:
```json
{
  "success": true,
  "message": "Player leveled up! Now level 3",
  "data": {
    "leveled_up": true,
    "levels_gained": 1,
    "current_level": 3,
    "current_xp": 0,
    "xp_to_next_level": 450,
    "rewards": [
      {
        "level": 3,
        "rewards": {
          "coins": 200
        }
      }
    ]
  }
}
```

### Get All Level Configurations
```
GET /api/levels
```

Returns:
```json
{
  "levels": [
    {
      "id": 1,
      "level": 1,
      "experience_required": 0,
      "rewards": {
        "coins": 100
      }
    },
    ...
  ]
}
```

### Get Specific Level Configuration
```
GET /api/levels/{level}
```

Returns:
```json
{
  "level": {
    "id": 2,
    "level": 2,
    "experience_required": 100,
    "rewards": {
      "coins": 150
    }
  }
}
```

### Get Leaderboard
```
GET /api/leaderboard
```

Returns top 100 players sorted by level and total XP:
```json
{
  "leaderboard": [
    {
      "id": 5,
      "name": "Top Player",
      "level": 10,
      "total_experience_points": 5000
    },
    ...
  ]
}
```

## Usage Examples

### Creating a New Player
```php
$player = Player::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
]);
// Player starts at level 1 with 0 XP
```

### Adding Experience Points
```php
$player = Player::find(1);
$result = $player->addExperience(150);

if ($result['leveled_up']) {
    echo "Congratulations! You leveled up to level {$result['current_level']}!";
    
    foreach ($result['rewards'] as $reward) {
        echo "Level {$reward['level']} rewards: ";
        print_r($reward['rewards']);
    }
}
```

### Checking Level Progress
```php
$player = Player::find(1);

echo "Current Level: {$player->level}\n";
echo "Current XP: {$player->experience_points}\n";
echo "Total XP: {$player->total_experience_points}\n";
echo "XP to Next Level: {$player->getExperienceToNextLevel()}\n";
echo "Progress: {$player->getLevelProgress()}%\n";
```

### Getting Level Configuration
```php
$levelConfig = PlayerLevel::getByLevel(5);
echo "Level 5 requires {$levelConfig->experience_required} XP\n";
echo "Rewards: ";
print_r($levelConfig->rewards);
```

## Model Methods

### Player Model

#### `addExperience(int $amount): array`
Adds experience points to the player and handles automatic level-ups.

Returns an array with:
- `leveled_up`: Boolean indicating if player leveled up
- `levels_gained`: Number of levels gained
- `current_level`: Player's current level
- `current_xp`: Current XP towards next level
- `xp_to_next_level`: XP needed for next level
- `rewards`: Array of rewards earned from level-ups

#### `getExperienceToNextLevel(): ?int`
Returns XP needed to reach the next level, or null if at max level.

#### `getLevelProgress(): ?float`
Returns progress percentage (0-100) towards next level, or 100 if at max level.

#### `levelConfig()`
Eloquent relationship to get the PlayerLevel configuration for the player's current level.

### PlayerLevel Model

#### `getAllLevels()`
Static method to get all level configurations ordered by level number.

#### `getByLevel(int $level)`
Static method to get level configuration for a specific level.

## Testing

The system includes comprehensive test coverage:

### Feature Tests (`tests/Feature/PlayerLevelTest.php`)
- Player creation with default level
- Experience gain
- Single level-up
- Multiple level-ups
- Excess experience retention
- XP to next level calculation
- Level progress percentage
- Level rewards
- All API endpoints

### Unit Tests (`tests/Unit/PlayerModelTest.php`)
- Model attributes and casting
- Level-up logic
- Max level handling
- XP calculations
- Model relationships

Run tests with:
```bash
php artisan test
```

Or run specific test files:
```bash
php artisan test tests/Feature/PlayerLevelTest.php
php artisan test tests/Unit/PlayerModelTest.php
```

## Installation

1. Run migrations to create the necessary tables:
```bash
php artisan migrate
```

2. The `player_levels` table will be automatically seeded with the default 10 levels.

3. Routes are defined in `routes/api.php` and are automatically loaded.

## Extending the System

### Adding More Levels
To add more levels, create a new migration or directly insert into the `player_levels` table:

```php
PlayerLevel::create([
    'level' => 11,
    'experience_required' => 4000,
    'rewards' => ['coins' => 700],
]);
```

### Custom Rewards
Rewards are stored as JSON, so you can add any type of reward:

```php
'rewards' => [
    'coins' => 500,
    'gems' => 10,
    'items' => ['special_pet', 'rare_habitat'],
]
```

### Integrating with Game Activities
Award XP when players complete activities:

```php
// After feeding an animal
$player->addExperience(10);

// After completing a mini-game
$player->addExperience(50);

// After washing an animal
$player->addExperience(15);
```

## Notes

- XP is cumulative - `total_experience_points` tracks all XP ever earned
- `experience_points` resets to the remainder after each level-up
- Players can gain multiple levels from a single XP addition
- The system handles max level gracefully (returns null for next level XP)
- All API endpoints return JSON responses
- The leaderboard is limited to top 100 players for performance
