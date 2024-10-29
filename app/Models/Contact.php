<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'company_id',
        'first_name',
        'last_name',
        'phone',
        'mob',
        'email',
        'position',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
