<?php

namespace App\Http\Controllers;

use App\Models\Declaration;
use App\Models\Tax;
use Inertia\Inertia;
use App\Models\Terms;
use App\Models\Driver;
use App\Models\Company;
use App\Models\Curency;
use App\Models\Product;
use App\Models\Vehicle;
use App\Models\Document;
use App\Models\Incoterm;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $documentTypes = DocumentType::all(); // Fetch all document types for the dropdown
        $clients = Company::where('is_customer', true)->get();

        $documents = Document::with('documentType', 'company', 'curency', 'packingList')
            ->when($request->type, function ($query) use ($request) {
                // Apply type filter only if 'type' is provided
                $query->where('document_type_id', $request->type);
            })
            ->when($request->year, function ($query) use ($request) {
                // Apply year filter only if 'year' is provided
                $query->whereYear('date', $request->year);
            })
            ->when($request->client, function ($query) use ($request) {
                // Apply year filter only if 'year' is provided
                $query->where('client_id', $request->client);
            })
            ->when($request->export, function ($query) use ($request) {
                // Apply filter for 'is_for_export' if 'export' checkbox is checked
                if ($request->export == 'извозни') {
                    $query->where('is_for_export', true);
                } elseif ($request->export == 'домашни') {
                    // If export is 'false', ensure only documents with is_for_export = false are shown
                    $query->where('is_for_export', false);
                }
            })
            ->paginate(20)
            ->withQueryString();  // Retains query parameters (for pagination)
            // dd($documents->pluck('packingList'));
        return inertia('Documents/DocumentsIndex', [
            'documents' => $documents,
            'documentTypes' => $documentTypes,
            'clients' => $clients,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(DocumentType $documentType)
    {
        $authUser = Auth::user();
        $curencies = Curency::all();
        $taxes = Tax::all();
        $terms = Terms::all();
        $incoterms = Incoterm::all();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();

        $companies = Company::select('id', 'name', 'is_customer')
            ->whereIn('is_customer', [true, false])
            ->get()
            ->groupBy('is_customer');

        return inertia('Documents/DocumentsAdd', [
            'authUser' => $authUser,
            'documentType' => $documentType,
            'ownerCompanies' => $companies->get(false, collect()), // companies where 'is_customer' is false
            'clientCompanies' => $companies->get(true, collect()), // companies where 'is_customer' is true
            'curencies' => $curencies,
            'taxes' => $taxes,
            'terms' => $terms,
            'incoterms' => $incoterms,
            'vehicles' => $vehicles,
            'drivers' => $drivers,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->merge([
            'tax_id' => $request->tax_id ?? 1,
            'curency_id' => $request->tax_id ?? 1,
        ]);

        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'owner_id' => 'required|exists:companies,id',
            'client_id' => 'required|exists:companies,id',
            'document_type_id' => 'required|exists:document_types,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'curency_id' => 'exists:curencies,id',
            'incoterm_id' => 'nullable|exists:incoterms,id',
            'tax_id' => 'exists:taxes,id',
            'term_id' => 'nullable|exists:terms,id',
            'is_translation' => 'boolean',
            'is_for_export' => 'boolean',
            'is_for_advanced_payment' => 'boolean',
            'document_no' => 'required|max:255',
            'drawing_no' => 'nullable|max:255',
            'date' => 'nullable|date',
            'advance_payment' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'delivery' => 'nullable|max:255',
        ]);
        // $validatedData['user_id'] = auth()->user()->id;

        // dd($validatedData);

        $document = Document::create($validatedData);

        return redirect()->route('products.create', [
            'document' => $document->id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        // dd($document);

        $curencies = Curency::all();
        $taxes = Tax::all();
        $terms = Terms::all();
        $incoterms = Incoterm::all();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        $documentTypes = DocumentType::all();

        $document->load('documentType', 'tax');

        $companies = Company::select('id', 'name', 'is_customer')
            ->whereIn('is_customer', [true, false])
            ->get()
            ->groupBy('is_customer');

        $declarations = Declaration::all();
        $selectedDeclarations = $document->declarations->pluck('id');

        return inertia('Documents/DocumentEditModal', [
            'document' => $document,
            'documentTypes' => $documentTypes,
            'ownerCompanies' => $companies->get(false, collect()), // companies where 'is_customer' is false
            'clientCompanies' => $companies->get(true, collect()), // companies where 'is_customer' is true
            'curencies' => $curencies,
            'taxes' => $taxes,
            'terms' => $terms,
            'incoterms' => $incoterms,
            'vehicles' => $vehicles,
            'drivers' => $drivers,
            'declarations' => $declarations,
            'selectedDeclarations' => $selectedDeclarations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        // Validate all fields coming from the user
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'owner_id' => 'required|exists:companies,id',
            'client_id' => 'required|exists:companies,id',
            'document_type_id' => 'required|exists:document_types,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'curency_id' => 'nullable|exists:curencies,id',
            'incoterm_id' => 'nullable|exists:incoterms,id',
            'tax_id' => 'nullable|exists:taxes,id',
            'term_id' => 'nullable|exists:terms,id',
            'is_translation' => 'boolean',
            'is_for_export' => 'boolean',
            'is_for_advanced_payment' => 'boolean',
            'document_no' => 'required|max:255',
            'drawing_no' => 'nullable|max:255',
            'date' => 'nullable|date',
            'advance_payment' => 'nullable|numeric',
            'discount' => 'nullable|numeric|min:0|max:100', // Ensure discount is a percentage
            'delivery' => 'nullable|max:255',
        ]);

        // Refresh the document's tax relationship to get the latest tax_rate
        if ($validatedData['tax_id']) {
            $tax = Tax::find($validatedData['tax_id']); // Fetch the updated tax from the database
            $taxRate = $tax ? $tax->tax_rate : 0; // Handle null gracefully
        } else {
            $taxRate = 0; // No tax ID provided
        }

        // Use the provided discount or fallback to the current document discount
        $discountRate = $validatedData['discount'] ?? $document->discount;

        // Recalculate fields
        $discountAmount = $document->total * ($discountRate / 100);


        $taxAmount = ($document->total - $discountAmount) * ($taxRate / 100);
        $docTotal = $document->total - $discountAmount + $taxAmount;
        $docGrandTotal = $docTotal - $validatedData['advance_payment'];
        $docAdvancedBase = $docGrandTotal/(1+($taxRate / 100));
        $docAdvancedTax = $docGrandTotal - $docAdvancedBase;
        // dd($validatedData['advance_payment']);

        // Merge recalculated fields with validated data
        $document->update(array_merge($validatedData, [
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
            'total_with_tax_and_discount' => $docTotal,
            'grand_total' => $docGrandTotal,
            'advanced_payment_tax' => $docAdvancedTax,
            'advanced_payment_base' => $docAdvancedBase,
        ]));

        // dd($document);

        // Redirect to products creation page
        return Inertia::location(route('products.create', [
            'document' => $document->id,
        ]));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        $document->delete();
        return redirect()->route('document.index')->with('message', 'Документот е успешно избришан.');
    }




    public function addEmptyRow(Document $document, Product $product)
    {
        // Retrieve the existing orders for the specified document as a collection
        $existingOrder = Product::where('document_id', $document->id)->get();

        // Define the empty row with the necessary values
        $emptyRow = new Product([
            "id" => $product->id,
            "document_id" => $document->id,
            "description" => null,
            "qty" => null,
            "single_price" => null,
            "total_price" => null
        ]);

        // Insert the empty row at the correct position in the collection
        $newOrder = $existingOrder->flatMap(function ($order) use ($emptyRow, $product) {
            return $order->id == $product->id ? collect([$emptyRow, $order]) : collect([$order]);
        });

        // Delete the existing orders from the database
        Product::where('document_id', $document->id)->delete();

        // Save each item in the new order collection to the database
        $newOrder->each(fn($order) => Product::create($order->toArray()));

        // Return the new order collection or a success message, if needed
        // return $newOrder;
        return redirect()
        ->route('products.create', ['document' => $document->id])
        ->with('message', 'Empty Row inserted successfully!');
    }

    public function convert(Document $document, DocumentType $documentTypeNew)
    {
        // Prepare document data to copy
        $documentData = [
            'user_id' => $document->user_id,
            'owner_id' => $document->owner_id,
            'client_id' => $document->client_id,
            'document_type_id' => $documentTypeNew->id,
            'vehicle_id' => $document->vehicle_id,
            'driver_id' => $document->driver_id,
            'curency_id' => $document->curency_id,
            'incoterm_id' => $document->incoterm_id,
            'tax_id' => $document->tax_id,
            'term_id' => $document->term_id,
            'is_translation' => $document->is_translation,
            'is_for_export' => $document->is_for_export,
            'is_for_advanced_payment' => $document->is_for_advanced_payment,
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
        ];
    
        // Create the new document
        $convertedDocument = Document::create($documentData);
    
        // Copy associated products
        $products = Product::where('document_id', $document->id)->get();
    
        foreach ($products as $product) {
            $productData = [
                'temperature_id' => $product->temperature_id,
                'voltage_id' => $product->voltage_id,
                'manufacturer_id' => $product->manufacturer_id,
                'category_id' => $product->category_id,
                'document_id' => $convertedDocument->id,
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
    
            // Use relationship to create product
            $convertedDocument->products()->create($productData);
        }
    
        return redirect()->route('document.index');
    }
    

    public function convertCompanyDocument(Document $document, DocumentType $documentTypeNew){
        // dd($document, $documentTypeNew);

        $products = Product::where('document_id', $document->id)->get();


        $documentData = ([
            'user_id' => $document->user_id,
            'owner_id' => $document->owner_id,
            'client_id'=> $document->client_id,
            'document_type_id' => $documentTypeNew->id,
            'vehicle_id'=> $document->vehicle_id,
            'driver_id'=> $document->driver_id,
            'curency_id'=> $document->curency_id,
            'incoterm_id'=> $document->incoterm_id,
            'tax_id'=> $document->tax_id,
            'term_id'=> $document->term_id,
            'is_translation'=> $document->is_translation,
            'is_for_export'=> $document->is_for_export,
            'is_for_advanced_payment' => $document->is_for_advanced_payment,
            'document_no'=> $document->document_no,
            'date'=> $document->date,
            'drawing_no'=> $document->drawing_no,
            'advance_payment'=> $document->advance_payment,
            'discount'=> $document->discount,
            'total'=> $document->total,
            'total_with_tax_and_discount'=> $document->total_with_tax_and_discount,
            'total_volume'=> $document->total_volume,
            'total_weight'=> $document->total_weight,
            'tax_amount'=> $document->tax_amount,
            'discount_amount'=> $document->discount_amount,
            'grand_total'=> $document->grand_total,
            'advanced_payment_base'=> $document->advanced_payment_base,
            'advanced_payment_tax'=> $document->advanced_payment_tax,
            'delivery'=> $document->delivery,
        ]);

        $convertedDocument = Document::create($documentData);

        foreach($products as $product){
            $productData = ([
                'temperature_id' => $product->temperature_id,
                'refrigerant_id'=> $product->refrigerant_id,
                'voltage_id'=> $product->voltage_id,
                'manufacturer_id'=> $product->manufacturer_id,
                'category_id'=> $product->category_id,
                'document_id'=> $convertedDocument->id,
                'model_id'=> $product->model_id,
                'product_code'=> $product->product_code,
                'serial_no'=> $product->serial_no,
                'description'=> $product->description,
                'length'=> $product->length,
                'width'=> $product->width,
                'height'=> $product->height,
                'weight'=> $product->weight,
                'qty'=> $product->qty,
                'single_price'=> $product->single_price,
                'total_price'=> $product->total_price,
                'product_total_volume'=> $product->product_total_volume,
                'product_total_weight'=> $product->product_total_weight,
                'hfc_qty'=> $product->hfc_qty,
                'co2'=> $product->co2,
                'power'=> $product->power,
                'current'=> $product->current,
            ]);

            $convertedDocumentProducts = Product::create($productData);

        }

        return redirect()->route('company.show', ['company' => $document->client_id]);    }

}
