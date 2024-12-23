<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Regulation extends Model
{

    protected $fillable = [
        'regulation',
        'description',
    ];


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_directive_regulation');
    }
}
