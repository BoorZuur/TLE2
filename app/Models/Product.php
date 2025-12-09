<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'product_type',
        'currency_type',
        'species_tag',
        'powerup_effects',
        'image_url',
    ];

    protected $casts = [
        'powerup_effects' => 'array',
    ];

    public function purchases(): HasMany
    {
        return $this->hasMany(UserPurchase::class);
    }

    public function isAnimal(): bool
    {
        return $this->product_type === 'animal';
    }

    public function isPowerup(): bool
    {
        return $this->product_type === 'powerup';
    }

    public function requiresRealMoney(): bool
    {
        return $this->currency_type === 'real_money';
    }

    public function canBuyWithCoins(): bool
    {
        return $this->currency_type === 'coins';
    }
}
