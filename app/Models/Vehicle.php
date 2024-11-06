<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'model',
        'type',
        'register_plate_number',
        'max_weight_loaded',
        'max_weight_empty',
        'payload',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
