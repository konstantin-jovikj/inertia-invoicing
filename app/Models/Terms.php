<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    protected $fillable = [
        'term',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
