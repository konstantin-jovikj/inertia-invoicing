<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Directive;
use App\Models\Regulation;
use App\Models\ProductModel;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }



    public function models()
    {
        return $this->hasMany(ProductModel::class);
    }

    public function directives()
    {
        return $this->belongsToMany(Directive::class, 'category_directive_regulation');
    }

    public function regulations()
    {
        return $this->belongsToMany(Regulation::class, 'category_directive_regulation');
    }

}
