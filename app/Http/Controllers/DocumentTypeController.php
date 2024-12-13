<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch document types with the latest document
        $documentTypes = DocumentType::with(['latestDocument' => function ($query) {
            $query->latest();
        }])->get();

        // dd($documentTypes->map(function ($documentType) {
        //     return $documentType->latestDocument;
        // }));
    
        // Pass the data to the Vue component
        return inertia('Documents/DocumentTypeSelector', [
            'documentTypes' => $documentTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentType $documentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentType $documentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentType $documentType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentType $documentType)
    {
        //
    }
}
