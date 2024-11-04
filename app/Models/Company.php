<?php

namespace App\Models;

use App\Models\Place;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Customer;
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
        'place_id',
        'is_customer',
        'address',
        'web',

    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
