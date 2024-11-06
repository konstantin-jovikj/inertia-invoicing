<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Regulation;
use App\Models\ProductModel;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function regulations()
    {
        return $this->belongsToMany(Regulation::class);
    }

    public function models()
    {
        return $this->hasMany(ProductModel::class);
    }
}
