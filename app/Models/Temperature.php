<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    protected $fillable = [
        'class',
        'range',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
