<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    //
    protected $table = 'animals';

    public $timestamps = false;
    protected $fillable = [
        'user_id', 'name', 'happiness', 'hunger', 'cleanliness',
        'species_tag', 'adopted_at', 'updated_at', 'last_hunger_update', 'last_fed'
    ];

    protected $casts = [
        'last_hunger_update' => 'datetime',
        'last_fed' => 'datetime',
        'adopted_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
