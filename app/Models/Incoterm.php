<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;

class Incoterm extends Model
{
    protected $fillable = [
        'shortcut',
        'short_description',
        'description',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
