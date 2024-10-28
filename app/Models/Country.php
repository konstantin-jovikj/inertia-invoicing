<?php

namespace App\Models;

use App\Models\Place;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];

    public function places(){
        return $this->hasMany(Place::class);
    }
}
