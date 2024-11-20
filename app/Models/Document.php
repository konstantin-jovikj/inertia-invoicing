<?php

namespace App\Models;

use App\Models\Tax;
use App\Models\User;

use App\Models\Terms;
use App\Models\Driver;
use App\Models\Company;
use App\Models\Curency;
use App\Models\Product;
use App\Models\Vehicle;
use App\Models\Incoterm;
use App\Models\Declaration;
use App\Models\DocumentNote;
use App\Models\DocumentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'owner_id',
        'client_id',
        'document_type_id',
        'vehicle_id',
        'driver_id',
        'curency_id',
        'incoterm_id',
        'tax_id',
        'term_id',
        'is_translation',
        'is_for_export',
        'document_no',
        'date',
        'drawing_no',
        'advance_payment',
        'discount',
        'total',
        'total_with_tax_and_discount',
        'total_volume',
        'total_weight',
        'tax_amount',
        'discount_amount',
        'grand_total',
        'advanced_payment_base',
        'advanced_payment_tax',
    ];

    // protected $casts = [
    //     'is_translation' => 'boolean',
    //     'is_for_export' => 'boolean',
    //     'date' => 'datetime',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function incoterm()
    {
        return $this->belongsTo(Incoterm::class);
    }

    public function curency()
    {
        return $this->belongsTo(Curency::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function term()
    {
        return $this->belongsTo(Terms::class);
    }

    public function documentNotes()
    {
        return $this->hasMany(DocumentNote::class);
    }

    public function declarations()
    {
        return $this->belongsToMany(Declaration::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'client_id');
    }
}
