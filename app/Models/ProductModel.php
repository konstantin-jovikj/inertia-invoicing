<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Refrigerant;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $fillable = [
        'category_id',
        'model',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
