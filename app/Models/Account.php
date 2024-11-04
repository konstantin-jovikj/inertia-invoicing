<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'company_id',
        'bank_id',
        'is_for_export',
        'giro_account',
        'account_no',
        'swift',
        'iban',
    ];
}
