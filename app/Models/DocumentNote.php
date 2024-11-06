<?php

namespace App\Models;

use App\Models\Document;
use App\Models\NoteType;
use Illuminate\Database\Eloquent\Model;

class DocumentNote extends Model
{
    protected $fillable = [
        'document_id',
        'note_type_id',
        'note_text',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function noteType()
    {
        return $this->belongsTo(NoteType::class);
    }
}
