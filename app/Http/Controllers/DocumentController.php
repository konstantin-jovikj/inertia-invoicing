<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Document;
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

        $companies = Company::select('id', 'name', 'is_customer')
        ->whereIn('is_customer', [true, false])
        ->get()
        ->groupBy('is_customer');

    return inertia('Documents/DocumentsAdd', [
        'authUser' => $authUser,
        'documentType' => $documentType,
        'ownerCompanies' => $companies->get(false, collect()), // companies where 'is_customer' is false
        'clientCompanies' => $companies->get(true, collect()),  // companies where 'is_customer' is true
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
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
}
