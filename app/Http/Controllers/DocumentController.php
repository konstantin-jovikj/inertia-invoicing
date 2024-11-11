<?php

namespace App\Http\Controllers;

use App\Models\Tax;
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
    public function index()
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }

    public function addEmptyRow(Document $document, Product $product)
    {
        dd($document, $product);
        $existingOrder = Product::where('document_id', $document->id )->get();
        dd($existingOrder);
    }
}
