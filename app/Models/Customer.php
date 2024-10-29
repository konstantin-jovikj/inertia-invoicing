<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_type_id',
    ];

    public function companies(){
        return $this->hasMany(Company::class);
    }
}
