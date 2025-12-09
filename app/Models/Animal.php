<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    //
    protected $table = 'animals';

    public $timestamps = false;
    protected $fillable = ['user_id', 'name', 'happiness', 'hunger', 'cleanliness', 'species_tag', 'adopted_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function species()
    {
        return $this->belongsTo(Specie::class, 'species_tag', 'id');
    }
}
