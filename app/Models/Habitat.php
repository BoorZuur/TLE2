<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitat extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    // Define relationship with Specie model
    public function species() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Specie::class, 'habitat_tag', 'id');
    }
}
