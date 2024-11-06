<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $fillable = [
        'type',
    ];


    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
