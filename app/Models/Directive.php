<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Directive extends Model
{

    protected $fillable = [
        'directive',
        'description',
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_directive_regulation');
    }
    
}
