<?php

namespace App\Models;

use App\Models\DocumentNote;
use Illuminate\Database\Eloquent\Model;

class NoteType extends Model
{
    protected $fillable = [
        'note_type',
    ];

    public function documentNotes()
    {
        return $this->hasMany(DocumentNote::class);
    }
}
