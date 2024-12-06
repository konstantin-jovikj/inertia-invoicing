<?php

namespace App\Models;

use App\Models\Voltage;
use App\Models\Category;
use App\Models\Document;
use App\Models\PackingList;
use App\Models\Refrigerant;
use App\Models\Temperature;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'temperature_id',
        'refrigerant_id',
        'voltage_id',
        'manufacturer_id',
        'category_id',
        'document_id',
        'packing_list_id',
        'model_id',
        'refrigerant_id',
        'product_code',
        'serial_no',
        'description',
        'length',
        'width',
        'height',
        'weight',
        'qty',
        'single_price',
        'total_price',
        'product_total_volume',
        'product_total_weight',
        'hfc_qty',
        'co2',
        'power',
        'current',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function packingList()
    {
        return $this->belongsTo(PackingList::class);
    }

    public function temperature()
    {
        return $this->belongsTo(Temperature::class);
    }

    public function voltage()
    {
        return $this->belongsTo(Voltage::class);
    }

    public function manufacturers()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function refrigerant()
    {
        return $this->belongsTo(Refrigerant::class);
    }
}
