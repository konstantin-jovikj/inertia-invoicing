<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
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

        $document->load('documentType', 'company');
        // dd($document->company);

        $products = Product::where('document_id', $document->id)->get();

        return inertia('Products/ProductsAdd', [
            'document' => $document,
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $product = Product::create([
            'document_id' => $request->document_id,
            'description' => $request->description,
            'qty' => $request->qty,
            'single_price' => $request->single_price,
            'total_price' => $request->total_price,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        dd($request->all());
        $product->update([
            'document_id' => $request->document_id,
            'description' => $request->description,
            'qty' => $request->qty,
            'single_price' => $request->single_price,
            'total_price' => $request->total_price,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
