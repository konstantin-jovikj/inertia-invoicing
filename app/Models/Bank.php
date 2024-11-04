<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'name_cyr',
        'name_lat',
        'address_cyr',
        'address_lat',
    ];
}
