<?php

namespace App\Models;

use App\Models\Product;
use App\Models\ProductModel;
use Illuminate\Database\Eloquent\Model;

class Refrigerant extends Model
{
    protected $fillable = [
        'short_name',
        'synonym',
        'formula',
        'gwp',
        'boiling_point',
        'freezing_point',
        'flammability',
        'oxidizing',
        'vapour_pressure',
        'relative_density',
        'other',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
