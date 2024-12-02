<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Document;
use App\Models\PackingList;
use App\Http\Requests\StorePackingListRequest;
use App\Http\Requests\UpdatePackingListRequest;

class PackingListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Document $document)
    {

        // Load related data for the document
        $document->load('documentType', 'company', 'curency', 'tax');
        // dd($document->id);

        
        // Fetch products associated with the document and load related data
        $products = Product::where('document_id', $document->id)->get();
        $products->load('manufacturers.place.country');
        
        // dd($document);
        // Create Packing List
        $packingList = PackingList::create([
            'user_id' => $document->user_id,
            'owner_id' => $document->owner_id,
            'client_id' => $document->client_id,
            'document_id' => $document->id,
            'vehicle_id' => $document->vehicle_id,
            'driver_id' => $document->driver_id,
            'curency_id' => $document->curency_id,
            'incoterm_id' => $document->incoterm_id,
            'tax_id' => $document->tax_id,
            'term_id' => $document->term_id,
            'is_translation' => $document->is_translation,
            'is_for_export' => $document->is_for_export,
            'document_no' => $document->document_no,
            'drawing_no' => $document->drawing_no,
            'date' => $document->date,
            'advance_payment' => $document->advance_payment,
            'discount' => $document->discount,
            'delivery' => $document->delivery,
        ]);
        // dd('packing_list_id', $packingList->id,);
    
        // Loop through document products and add them to the created Packing List
        foreach ($products as $product) {
            $newProduct = $product->replicate(); // Creates a new instance
            $newProduct->packing_list_id = $packingList->id;
            $newProduct->save();
        }
    
        // Return response with the created packing list and related data
        return inertia('PackingList/PackingListAdd', [
            'document' => $document,
            'products' => $products,
            'packing-list' => $packingList,
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackingListRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PackingList $packingList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackingList $packingList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackingListRequest $request, PackingList $packingList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackingList $packingList)
    {
        //
    }
}
