<?php

namespace App\Models;

use App\Models\Place;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = [
        'place_id',
        'address',
        'name',
    ];

    public function place(){
        return $this->belongsTo(Place::class);
    }
}
