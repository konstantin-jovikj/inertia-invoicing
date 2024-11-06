<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;

class Curency extends Model
{
    protected $fillable = [
        'code',
        'symbol',
        'name',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
