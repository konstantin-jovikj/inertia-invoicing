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
        // dd($document);
        $document->load('documentType', 'company', 'curency', 'tax');
        // dd($document->company);

        $products = Product::where('document_id', $document->id)->get();
        $products->load('manufacturers.place.country');


        //create Packing List
        //Loop through document products and add them to the created Packing List
        //include calculated fields

        //change the inertia return bellow

        return inertia('Products/ProductsAdd', [
            'document' => $document,
            'products' => $products,
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
