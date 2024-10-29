<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'reg_number',
        'tax_number',
        'logo',
        'cert',
        'user_id',
        'customer_id',
        'is_customer',
        'web',

    ];
}
