<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Product;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;

class PackingList extends Model
{
    protected $fillable = [
        'user_id',
        'owner_id',
        'client_id',
        'document_id',
        'vehicle_id',
        'driver_id',
        'curency_id',
        'incoterm_id',
        'packing_list_id',
        'tax_id',
        'term_id',
        'is_translation',
        'is_for_export',
        'print_price',
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
        'delivery',
    ];


    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'packing_list_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'client_id');
    }
}
