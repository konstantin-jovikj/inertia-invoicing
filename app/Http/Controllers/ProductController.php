<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\ProductModel;
use App\Models\Refrigerant;
use App\Models\Temperature;
use App\Models\Voltage;
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
        $document->load('documentType', 'company', 'curency', 'tax');
        // dd($document->company);

        $products = Product::where('document_id', $document->id)->get();
        $products->load('manufacturers.place.country');

        return inertia('Products/ProductsAdd', [
            'document' => $document,
            'products' => $products,
        ]);
    }

    public function createModal(Document $document)
    {
        // dd($document);
        $document->load('documentType', 'company', 'tax');
        $manufacturers = Manufacturer::all();
        $voltages = Voltage::all();
        $categories = Category::all();
        $models = ProductModel::all();
        $refrigerants = Refrigerant::all();
        $temperatures = Temperature::all();
        // dd($document->company);

        // $products = Product::where('document_id', $document->id)->get();

        return Inertia::modal('Products/ProductAddModal', [
            'document' => $document,
            'manufacturers' => $manufacturers,
            'voltages' => $voltages,
            'categories' => $categories,
            'models' => $models,
            'refrigerants' => $refrigerants,
            'temperatures' => $temperatures,

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
            'product_code' => 'nullable|max:20',
            'total_price' => 'nullable|numeric|min:0',
            'serial_no' => 'nullable|max:20',
            'manufacturer_id' => 'nullable|exists:manufacturers,id',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'voltage_id' => 'nullable|exists:voltages,id',
            'current' => 'nullable|numeric|min:0',
            'power' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'model_id' => 'nullable|exists:product_models,id',
            'refrigerant_id' => 'nullable|exists:refrigerants,id',
            'temperature_id' => 'nullable|exists:temperatures,id',
            'hfc_qty' => 'nullable|numeric|min:0,01',
        ]);

        // Calculate total price of product
        $totalPrice = $request->qty * $request->single_price;
        // Calculate total volume of product
        $productTotalVolume = $request->qty * (($request->length * $request->width * $request->height) / 1000000);
        // Calculate total weight of product
        $productTotalWeight = $request->qty * $request->weight;


        // Create the product
        $product = Product::create([
            'document_id' => $request->document_id,
            'description' => $request->description,
            'qty' => $request->qty,
            'single_price' => $request->single_price,
            'total_price' => $totalPrice,
            'product_code' => $request->product_code,
            'serial_no' => $request->serial_no,
            'manufacturer_id' => $request->manufacturer_id,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'weight' => $request->weight,
            'voltage_id' => $request->voltage_id,
            'current' => $request->current,
            'power' => $request->power,
            'category_id' => $request->category_id,
            'model_id' => $request->model_id,
            'refrigerant_id' => $request->refrigerant_id,
            'temperature_id' => $request->temperature_id,
            'product_total_volume' => $productTotalVolume,
            'product_total_weight' => $productTotalWeight,
            'hfc_qty' => $request->hfc_qty,
        ]);

        // Calculate CO2 impact of product
        if ($request->hfc_qty) {
            $product->co2 = $request->hfc_qty * $product->refrigerant->gwp;
            $product->save();
        }
        // Find the document using the provided document_id
        $document = Document::findOrFail($request->document_id);

        // Update the document's total
        $document->total += $totalPrice;
        $document->total_volume += $productTotalVolume;
        $document->total_weight += $productTotalWeight;
        $document->discount_amount = $document->total * ($document->discount / 100);
        $document->tax_amount = $document->total * ($document->tax->tax_rate / 100);
        $document->total_with_tax_and_discount = $document->total - $document->discount_amount + $document->tax_amount;

        $document->grand_total = $document->total_with_tax_and_discount - $document->advance_payment;
        $document->advanced_payment_base = $document->grand_total/(1+$document->tax->tax_rate / 100);
        $document->advanced_payment_tax = $document->grand_total - $document->advanced_payment_base;

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
        // dd($product);

        // $document->load('documentType', 'company');
        $manufacturers = Manufacturer::all();
        $voltages = Voltage::all();
        $categories = Category::all();
        $models = ProductModel::all();
        $refrigerants = Refrigerant::all();
        $temperatures = Temperature::all();


        return inertia('Products/ProductsEditModal', [
            'product' => $product ?? null, // Ensure product is passed
            'manufacturers' => $manufacturers,
            'voltages' => $voltages,
            'categories' => $categories,
            'models' => $models,
            'refrigerants' => $refrigerants,
            'temperatures' => $temperatures,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'description' => 'nullable|string|max:255',
            'qty' => 'nullable|numeric|min:1',
            'single_price' => 'nullable|numeric|min:0',
            'product_code' => 'nullable|max:20',
            'total_price' => 'nullable|numeric|min:0',
            'serial_no' => 'nullable|max:20',
            'manufacturer_id' => 'nullable|exists:manufacturers,id',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'voltage_id' => 'nullable|exists:voltages,id',
            'current' => 'nullable|numeric|min:0',
            'power' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'model_id' => 'nullable|exists:product_models,id',
            'refrigerant_id' => 'nullable|exists:refrigerants,id',
            'temperature_id' => 'nullable|exists:temperatures,id',
            'hfc_qty' => 'nullable|numeric|min:0,01',
        ]);

        // Calculate total price of product
        $totalPrice = $request->qty * $request->single_price;
        // Calculate total volume of product
        $productTotalVolume = $request->qty * (($request->length * $request->width * $request->height) / 1000000);
        // Calculate total weight of product
        $productTotalWeight = $request->qty * $request->weight;


        // Create the product
        $product ->update([
            'document_id' => $request->document_id,
            'description' => $request->description,
            'qty' => $request->qty,
            'single_price' => $request->single_price,
            'total_price' => $totalPrice,
            'product_code' => $request->product_code,
            'serial_no' => $request->serial_no,
            'manufacturer_id' => $request->manufacturer_id,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'weight' => $request->weight,
            'voltage_id' => $request->voltage_id,
            'current' => $request->current,
            'power' => $request->power,
            'category_id' => $request->category_id,
            'model_id' => $request->model_id,
            'refrigerant_id' => $request->refrigerant_id,
            'temperature_id' => $request->temperature_id,
            'product_total_volume' => $productTotalVolume,
            'product_total_weight' => $productTotalWeight,
            'hfc_qty' => $request->hfc_qty,
        ]);

        // Calculate CO2 impact of product
        if ($request->hfc_qty) {
            $product->co2 = $request->hfc_qty * $product->refrigerant->gwp;
            $product->save();
        }
        // Find the document using the provided document_id
        $document = Document::findOrFail($product->document_id);


        // Reset document

        $document->total = 0;
        $document->total_volume = 0;
        $document->total_weight = 0;
        $document->discount_amount = 0;
        $document->tax_amount = 0;
        $document->total_with_tax_and_discount = 0;

        $document->grand_total = 0;
        $document->advanced_payment_base = 0;
        $document->advanced_payment_tax = 0;

        // Update the document's total
        $document->total += $totalPrice;
        $document->total_volume += $productTotalVolume;
        $document->total_weight += $productTotalWeight;
        $document->discount_amount = $document->total * ($document->discount / 100);
        $document->tax_amount = $document->total * ($document->tax->tax_rate / 100);
        $document->total_with_tax_and_discount = $document->total - $document->discount_amount + $document->tax_amount;

        $document->grand_total = $document->total_with_tax_and_discount - $document->advance_payment;
        $document->advanced_payment_base = $document->grand_total/(1+$document->tax->tax_rate / 100);
        $document->advanced_payment_tax = $document->grand_total - $document->advanced_payment_base;

        $document->update(); // Save the updated document

        // Return a success response with the created product
        return redirect()
            ->route('products.create', ['document' => $request->document_id])
            ->with('message', 'Product saved successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        
        $document = Document::findOrFail($product->document_id);

                // Calculate total price of product
                $totalPrice = $product->qty * $product->single_price;
                // Calculate total volume of product
                $productTotalVolume = $product->qty * (($product->length * $product->width * $product->height) / 1000000);
                // Calculate total weight of product
                $productTotalWeight = $product->qty * $product->weight;

                // Find the document using the provided document_id

                // Update the document's total
                $document->total -= $totalPrice;
                $document->total_volume -= $productTotalVolume;
                $document->total_weight -= $productTotalWeight;
                $document->discount_amount = $document->total * ($document->discount / 100);
                $document->tax_amount = $document->total * ($document->tax->tax_rate / 100);
                $document->total_with_tax_and_discount = $document->total - $document->discount_amount + $document->tax_amount;
        
                $document->grand_total = $document->total_with_tax_and_discount - $document->advance_payment;
                $document->advanced_payment_base = $document->grand_total/(1+$document->tax->tax_rate / 100);
                $document->advanced_payment_tax = $document->grand_total - $document->advanced_payment_base;

                $product->delete();
                $document->save(); // Save the updated document

        return Inertia::location(route('products.create', [
            'document' => $product->document_id,
        ]));
    }

}
