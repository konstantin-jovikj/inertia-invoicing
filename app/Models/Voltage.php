<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Voltage extends Model
{
    protected $fillable = [
        'voltage',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
