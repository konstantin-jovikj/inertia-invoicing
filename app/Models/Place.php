<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'zip',
        'place',
        'country_id'
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
