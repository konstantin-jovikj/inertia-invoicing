<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'licence_no',
        'personal_id_no',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
