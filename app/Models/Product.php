<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'product_type',
        'currency_type',
        'species_id',
        'powerup_effects',
        'image_url',
        'qr_filename',
    ];

    protected $casts = [
        'powerup_effects' => 'array',
    ];

    public function purchases(): HasMany
    {
        return $this->hasMany(UserPurchase::class);
    }

    public function species(): BelongsTo
    {
        return $this->belongsTo(Specie::class);
    }

    public function isAnimal(): bool
    {
        return $this->product_type === 'animal' && $this->species_id !== null;
    }

    public function isPowerup(): bool
    {
        return $this->product_type === 'powerup';
    }

    public function canBuyWithCoins(): bool
    {
        return $this->currency_type === 'coins';
    }

    public function requiresRealMoney(): bool
    {
        return $this->currency_type === 'real_money';
    }

    public function requiresQRCode(): bool
    {
        return $this->currency_type === 'qr';
    }
}
