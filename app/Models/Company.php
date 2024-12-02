<?php

namespace App\Models;

use App\Models\Place;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
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
        'email',
        'phone',
        'notes',
        'mobile',

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

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function packingLists()
    {
        return $this->hasMany(PackingList::class);
    }
}
