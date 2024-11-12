<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Document;
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
        // dd($document);
        $document->load('documentType', 'company', 'curency');
        // dd($document->company);

        $products = Product::where('document_id', $document->id)->get();

        return inertia('Products/ProductsAdd', [
            'document' => $document,
            'products' => $products,
        ]);
    }

    public function createModal(Document $document)
    {
        // dd($document);
        $document->load('documentType', 'company');
        // dd($document->company);

        // $products = Product::where('document_id', $document->id)->get();

        return Inertia::modal('Products/ProductAddModal', [
            'document' => $document,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation (optional)
        $validated = $request->validate([
            'description' => 'nullable|string|max:255',
            'qty' => 'nullable|numeric|min:1',
            'single_price' => 'nullable|numeric|min:0',
        ]);

        // Calculate total price of product
        $totalPrice = $request->qty * $request->single_price;

        // Find the document using the provided document_id
        $document = Document::findOrFail($request->document_id);

        // Create the product
        $product = Product::create([
            'document_id' => $request->document_id,
            'description' => $request->description,
            'qty' => $request->qty,
            'single_price' => $request->single_price,
            'total_price' => $totalPrice,
        ]);

        // Update the document's total
        $document->total += $totalPrice;
        $document->save(); // Save the updated document

        // Return a success response with the created product
        return redirect()
            ->route('products.create', ['document' => $request->document_id])
            ->with('message', 'Product saved successfully!');
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
        dd($product);
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
        $product->delete();
    }

}
