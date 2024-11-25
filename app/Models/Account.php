<?php

namespace App\Models;

use App\Models\Bank;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'company_id',
        'bank_id',
        'is_for_export',
        'is_active',
        'giro_account',
        'account_no',
        'swift',
        'iban',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
