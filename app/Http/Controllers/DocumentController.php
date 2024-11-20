<?php

namespace App\Http\Controllers;

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

        $documents = Document::with('documentType', 'company', 'curency')
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
            'document_no' => 'required|max:255',
            'drawing_no' => 'nullable|max:255',
            'date' => 'nullable|date',
            'advance_payment' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
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
            'document_no' => 'required|max:255',
            'drawing_no' => 'nullable|max:255',
            'date' => 'nullable|date',
            'advance_payment' => 'nullable|numeric',
            'discount' => 'nullable|numeric|min:0|max:100', // Ensure discount is a percentage
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
        $taxAmount = $document->total * ($taxRate / 100);

        // Merge recalculated fields with validated data
        $document->update(array_merge($validatedData, [
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
        ]));

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

}
