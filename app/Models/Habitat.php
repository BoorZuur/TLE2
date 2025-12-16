<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitat extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'info_image',
        'image_0',
        'image_20',
        'image_40',
        'image_60',
        'image_80',
        'image_100',
    ];

    // Define relationship with Specie model
    public function species() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Specie::class, 'habitat_id', 'id');
    }
}
