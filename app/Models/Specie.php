<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specie extends Model
{
    protected $table = 'species';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'habitat_tag',
        'scientific_name',
        'info',
        'image',
        'beheerder',
        'status',
    ];

    public function habitat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Habitat::class, 'habitat_tag', 'id');
    }

    public function unlocks()
    {
        return $this->hasMany(UserSpeciesUnlock::class, 'species_id');
    }
}
