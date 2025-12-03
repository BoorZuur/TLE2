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
    ];

    public function habitat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Habitat::class, 'habitat_tag', 'id');
    }
}
