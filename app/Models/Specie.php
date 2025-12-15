<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specie extends Model
{
    protected $table = 'species';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'scientific_name',
        'habitat_id',
        'info',
        'image',
        'beheerder',
    ];

    public function habitat(): BelongsTo
    {
        return $this->belongsTo(Habitat::class);
    }

    public function unlocks(): HasMany
    {
        return $this->hasMany(UserSpeciesUnlock::class, 'species_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
