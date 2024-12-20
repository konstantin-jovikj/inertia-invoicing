<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Refrigerant;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $fillable = [
        'category_id',
        // 'refrigerant_id',
        'model',
        'model_en',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // public function refrigerant()
    // {
    //     return $this->belongsTo(Refrigerant::class);
    // }
}
