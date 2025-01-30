<?php

namespace App\Http\Controllers;

use App\Models\Declaration;
use App\Models\Place;
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
use App\Services\documentService;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{

    protected $documentService;

    public function __construct(documentService $documentService)
    {
        $this->documentService = $documentService;
    }


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
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString(); // Retains query parameters (for pagination)
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
        $places = Place::all();

        $companies = Company::select('id', 'name', 'is_customer')
            ->whereIn('is_customer', [true, false])
            ->get()
            ->groupBy('is_customer');
        $latestDoc = Document::where('document_type_id', $documentType->id)
            ->latest()
            ->first();

        if ($documentType->id == 7) {
            return inertia('Documents/TravelOrderAdd', [
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
                'places' => $places,
                'latestDoc' => $latestDoc,
            ]);
        } else {
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
                'places' => $places,
                'latestDoc' => $latestDoc,
            ]);
        }
    }

    private function validateDocument(Request $request)
    {
        $request->merge([
            'tax_id' => $request->tax_id ?? 1,
            'curency_id' => $request->curency_id ?? 1,
        ]);

        return $request->validate([
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
            'load_date' => 'nullable|date',
            'unload_date' => 'nullable|date',
            'load_place_id' => 'nullable|exists:places,id',
            'unload_place_id' => 'nullable|exists:places,id',
            'marking' => 'nullable|max:255',
            'boxes_nr' => 'nullable|numeric',
            'packaging_type' => 'nullable|max:255',
            'goods_type' => 'nullable|max:255',
            'instruction' => 'nullable|max:255',
            'picked_up_by' => 'nullable|max:255',
            'note' => 'nullable',
            'incoterm_place_id' => 'nullable|exists:places,id',
            'print_price' => 'boolean',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $this->validateDocument($request);
        $document = $this->documentService->createDocument($validatedData);

        return redirect()->route(
            $request->document_type_id == 7 ? 'travelorder.view' : 'products.create',
            ['document' => $document->id]
        );
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
    public function edit(Document $document, documentService $documentService)
    {
        $resources = $documentService->getDocumentResources();

        $document->load('documentType', 'tax');
        $selectedDeclarations = $document->declarations->pluck('id');

        return inertia('Documents/DocumentEditModal', [
            'document' => $document,
            'documentTypes' => $resources['documentTypes'],
            'ownerCompanies' => $resources['companies']->get(false, collect()), // companies where 'is_customer' is false
            'clientCompanies' => $resources['companies']->get(true, collect()), // companies where 'is_customer' is true
            'curencies' => $resources['curencies'],
            'taxes' => $resources['taxes'],
            'terms' => $resources['terms'],
            'incoterms' => $resources['incoterms'],
            'vehicles' => $resources['vehicles'],
            'drivers' => $resources['drivers'],
            'declarations' => $resources['declarations'],
            'selectedDeclarations' => $selectedDeclarations,
            'places' => $resources['places'],
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        // Step 1: Validate the request data
        $validatedData = $this->validateDocument($request);

        // Step 2: Fetch the updated tax rate
        $tax = Tax::find($validatedData['tax_id'] ?? $document->tax_id); // Use the new tax_id or fall back to the existing one
        $taxRate = $tax ? $tax->tax_rate : 0; // Gracefully handle a null tax

        // Step 3: Use the provided discount or fallback to the current document discount
        $discountRate = $validatedData['discount'] ?? $document->discount;

        // Initialize variables for recalculations
        $discountAmount = 0;
        $taxAmount = 0;
        $docTotal = 0;
        $docGrandTotal = 0;
        $docAdvancedBase = 0;
        $docAdvancedTax = 0;

        // Step 4: Perform recalculations based on currency
        if ($document->curency_id == 1) {
            $discountAmount = round($document->total * ($discountRate / 100));
            $taxAmount = round(($document->total - $discountAmount) * ($taxRate / 100));
            $docTotal = round($document->total - $discountAmount + $taxAmount);
            $docGrandTotal = round($docTotal - ($validatedData['advance_payment'] ?? 0));
            $docAdvancedBase = round($docGrandTotal / (1 + $taxRate / 100));
            $docAdvancedTax = round($docGrandTotal - $docAdvancedBase);
        } else {
            $discountAmount = $document->total * ($discountRate / 100);
            $taxAmount = ($document->total - $discountAmount) * ($taxRate / 100);
            $docTotal = $document->total - $discountAmount + $taxAmount;
            $docGrandTotal = $docTotal - ($validatedData['advance_payment'] ?? 0);
            $docAdvancedBase = $docGrandTotal / (1 + $taxRate / 100);
            $docAdvancedTax = $docGrandTotal - $docAdvancedBase;
        }

        // Step 5: Update the document with recalculated fields
        $document->update(array_merge($validatedData, [
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
            'total_with_tax_and_discount' => $docTotal,
            'grand_total' => $docGrandTotal,
            'advanced_payment_tax' => $docAdvancedTax,
            'advanced_payment_base' => $docAdvancedBase,
        ]));

        // Step 6: Redirect to the appropriate route
        return Inertia::location(
            $document->document_type_id == 7
            ? route('travelorder.view', ['document' => $document->id])
            : route('products.create', ['document' => $document->id])
        );
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
            'id' => $product->id,
            'document_id' => $document->id,
            'description' => null,
            'qty' => null,
            'single_price' => null,
            'total_price' => null,
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
        $documentData = $this->documentService->prepareDocumentData($document, $documentTypeNew);

        // Create the new document
        $convertedDocument = Document::create($documentData);

        // Copy associated products
        $products = Product::where('document_id', $document->id)
            ->whereNull('packing_list_id')
            ->get();

        foreach ($products as $product) {
            $productData = $this->documentService->prepareProductData($product, $convertedDocument->id);
            $convertedDocument->products()->create($productData);
        }

        return redirect()->route('document.index');
    }

    public function convertCompanyDocument(Document $document, DocumentType $documentTypeNew)
    {
        $documentData = $this->documentService->prepareDocumentData($document, $documentTypeNew);

        // Create the new document
        $convertedDocument = Document::create($documentData);

        // Copy associated products
        $products = Product::where('document_id', $document->id)
            ->whereNull('packing_list_id')
            ->get();

        foreach ($products as $product) {
            $productData = $this->documentService->prepareProductData($product, $convertedDocument->id);
            $convertedDocument->products()->create($productData);
        }

        return redirect()->route('company.show', ['company' => $document->client_id]);
    }


    public function viewTravelOrder(Document $document)
    {
        // dd($document);
        $ownerId = $document->owner_id;
        $clientId = $document->client_id;
        $client = Company::findOrFail($clientId);
        $owner = Company::findOrFail($ownerId);

        $client->load('place.country');
        $owner->load('place.country');

        $document->load('company', 'vehicle', 'place.country', 'load_place', 'unload_place');
        return inertia('Documents/TravelOrderView', [
            'document' => $document,
            'client' => $client,
            'owner' => $owner,
        ]);
    }

    public function editTravelOrder(Document $document)
    {
        // Eager load relations for companies
        $client = Company::with('place.country')->findOrFail($document->client_id);
        $owner = Company::with('place.country')->findOrFail($document->owner_id);
        $ownerCompanies = Company::where('customer_id', null)->get();
        $clientCompanies = Company::whereNotNull('customer_id')->get();
        $documentType = DocumentType::all();
        $places = Place::with('country')->get();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        $curencies = Curency::all();
        $taxes = Tax::all();
        $terms = Terms::all();
        $incoterms = Incoterm::all();

        // Eager load document relations
        $document->load(['company', 'vehicle', 'place.country', 'load_place', 'unload_place', 'tax']);

        // dd($document);

        // Return Inertia response
        return inertia('Documents/TravelOrderEdit', [
            'document' => $document,
            'client' => $client,
            'owner' => $owner,
            'documentType' => $documentType,
            'ownerCompanies' => $ownerCompanies,
            'clientCompanies' => $clientCompanies,
            'places' => $places,
            'vehicles' => $vehicles,
            'drivers' => $drivers,
            'curencies' => $curencies,
            'taxes' => $taxes,
            'terms' => $terms,
            'incoterms' => $incoterms,
        ]);
    }

    public function updateTravelOrder(Request $request, Document $document)
    {
    }

    public function createClientDocument(Company $company, DocumentType $documentType)
    {
        $owner = Company::whereNull('customer_id')->first();

        if (!$owner) {
            return back()->with('error', 'Компанијата не е пронајдена.');
        }

        $newDocData = [
            'user_id' => Auth::id(),
            'owner_id' => $owner->id,
            'client_id' => $company->id,
            'document_type_id' => $documentType->id,
            'curency_id' => 1,
            'tax_id' => 1,
            'document_no' => 'XXX-XX',
            'date' => now(),
        ];

        $document = Document::create($newDocData);

        return redirect()->route('document.index')->with('success', 'Документот е успешно креиран!');
    }

}
