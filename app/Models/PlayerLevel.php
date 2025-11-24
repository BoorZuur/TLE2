<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'experience_required',
        'rewards',
    ];

    protected $casts = [
        'level' => 'integer',
        'experience_required' => 'integer',
        'rewards' => 'array',
    ];

    /**
     * Get all levels ordered by level number.
     */
    public static function getAllLevels()
    {
        return self::orderBy('level', 'asc')->get();
    }

    /**
     * Get level configuration by level number.
     */
    public static function getByLevel(int $level)
    {
        return self::where('level', $level)->first();
    }
}
