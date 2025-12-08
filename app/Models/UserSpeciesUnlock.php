<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class UserSpeciesUnlock extends Model
{
    protected $table = 'user_species_unlocks';

    protected $fillable = ['user_id', 'species_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function species(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Specie::class, 'species_id');
    }
}
