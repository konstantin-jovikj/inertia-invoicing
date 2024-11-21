<?php

namespace App\Models;

use App\Models\Place;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = [
        'place_id',
        'address',
        'name',
    ];

    public function place(){
        return $this->belongsTo(Place::class, 'place_id');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
