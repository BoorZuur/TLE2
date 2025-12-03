<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $fillable = ['user_id', 'name', 'hunger', 'cleanliness'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
