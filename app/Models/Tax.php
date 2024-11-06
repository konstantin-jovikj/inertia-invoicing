<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = [
        'tax_rate',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
