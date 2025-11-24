# TLE2 - The Language Experience 2

A Laravel-based gaming application featuring player progression, animal care, and social features.

## Features

### Speler Levels (Player Levels) System ⭐
- Experience points (XP) progression system
- Automatic level-up with configurable thresholds
- Level rewards (coins, items, etc.)
- Player leaderboard
- Comprehensive API for level management

📖 **[Complete Player Levels Documentation](PLAYER_LEVELS.md)**

## API Endpoints

### Player Level Management
- `GET /api/players/{playerId}/level` - Get player level information
- `POST /api/players/{playerId}/experience` - Add experience to a player
- `GET /api/levels` - Get all level configurations
- `GET /api/levels/{level}` - Get specific level configuration
- `GET /api/leaderboard` - Get player leaderboard

## Installation

1. Install dependencies:
```bash
composer install
```

2. Run migrations:
```bash
php artisan migrate
```

3. Start the development server:
```bash
php artisan serve
```

## Testing

Run the test suite:
```bash
php artisan test
```

## License

This project is part of TLE2 development.
