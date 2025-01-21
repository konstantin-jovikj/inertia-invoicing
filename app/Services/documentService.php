<?php

namespace App\Services;

use App\Models\Tax;
use App\Models\Place;
use App\Models\Terms;
use App\Models\Company;
use App\Models\Curency;
use App\Models\Product;
use App\Models\Vehicle;
use App\Models\Document;
use App\Models\Incoterm;
use App\Models\DocumentType;
use App\Models\Declaration;
use Illuminate\Http\Request;
use App\Models\Driver;

class documentService
{

    //  Create a new document
    public function createDocument(array $validatedData)
    {
        if (isset($validatedData['load_date'])) {
            $validatedData['date'] = $validatedData['load_date'];
        }

        return Document::create($validatedData);
    }

    // Load all resources needed for the document edit
    public function getDocumentResources()
    {
        return [
            'curencies' => Curency::all(),
            'taxes' => Tax::all(),
            'terms' => Terms::all(),
            'incoterms' => Incoterm::all(),
            'vehicles' => Vehicle::all(),
            'drivers' => Driver::all(),
            'documentTypes' => DocumentType::all(),
            'places' => Place::all(),
            'companies' => Company::select('id', 'name', 'is_customer')
                ->whereIn('is_customer', [true, false])
                ->get()
                ->groupBy('is_customer'),
            'declarations' => Declaration::all(),
        ];
    }

    public function prepareDocumentData(Document $document, int $newDocumentTypeId): array
    {
        $document->load('load_place', 'unload_place', 'owner', 'company');

        return [
            'user_id' => $document->user_id,
            'owner_id' => $document->owner_id,
            'client_id' => $document->client_id,
            'document_type_id' => $newDocumentTypeId,
            'vehicle_id' => $document->vehicle_id,
            'driver_id' => $document->driver_id,
            'curency_id' => $document->curency_id,
            'incoterm_id' => $document->incoterm_id,
            'tax_id' => $document->tax_id,
            'term_id' => $document->term_id,
            'is_translation' => $document->is_translation,
            'is_for_export' => $document->is_for_export,
            'is_for_advanced_payment' => $document->is_for_advanced_payment,
            'print_price' => $document->print_price,
            'document_no' => $document->document_no,
            'date' => $document->date,
            'drawing_no' => $document->drawing_no,
            'advance_payment' => $document->advance_payment,
            'discount' => $document->discount,
            'total' => $document->total,
            'total_with_tax_and_discount' => $document->total_with_tax_and_discount,
            'total_volume' => $document->total_volume,
            'total_weight' => $document->total_weight,
            'tax_amount' => $document->tax_amount,
            'discount_amount' => $document->discount_amount,
            'grand_total' => $document->grand_total,
            'advanced_payment_base' => $document->advanced_payment_base,
            'advanced_payment_tax' => $document->advanced_payment_tax,
            'delivery' => $document->delivery,
            'load_date' => $document->date,
            'unload_date' => $document->date,
            'load_place_id' => $document->owner->place_id,
            'unload_place_id' => $document->company->place->id,
            'marking' => '',
            'boxes_nr' => '',
            'packaging_type' => '',
            'goods_type' => '',
            'instruction' => '',
            'picked_up_by' => '',
            'note' => $document->note,
            'incoterm_place_id' => $document->incoterm_place_id,
        ];
    }

    public function prepareProductData(Product $product, int $newDocumentId): array
    {
        return [
            'temperature_id' => $product->temperature_id,
            'voltage_id' => $product->voltage_id,
            'manufacturer_id' => $product->manufacturer_id,
            'category_id' => $product->category_id,
            'document_id' => $newDocumentId,
            'packing_list_id' => $product->packing_list_id,
            'model_id' => $product->model_id,
            'refrigerant_id' => $product->refrigerant_id,
            'product_code' => $product->product_code,
            'serial_no' => $product->serial_no,
            'description' => $product->description,
            'length' => $product->length,
            'width' => $product->width,
            'height' => $product->height,
            'weight' => $product->weight,
            'qty' => $product->qty,
            'single_price' => $product->single_price,
            'total_price' => $product->total_price,
            'product_total_volume' => $product->product_total_volume,
            'product_total_weight' => $product->product_total_weight,
            'hfc_qty' => $product->hfc_qty,
            'co2' => $product->co2,
            'power' => $product->power,
            'current' => $product->current,
        ];
    }

};