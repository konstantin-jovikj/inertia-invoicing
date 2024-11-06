<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;

class Declaration extends Model
{
    protected $fillable = [
        'title',
        'content',
    ];

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }
}
