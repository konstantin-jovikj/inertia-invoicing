<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Declaration;
use Illuminate\Http\Request;

class DeclarationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $declarations = Declaration::paginate(10);
        // dd($declarations);

        return inertia('Settings/Declarations/DeclarationsIndex', [
            'declarations' => $declarations,
        ]);
    }

    public function toggleDeclaration(Declaration $declaration, Document $document)
    {
        if ($declaration->documents()->where('document_id', $document->id)->exists()) {
            // Detach the document if it is associated
            $declaration->documents()->detach($document->id);
        } else {
            // Attach the document if it is not associated
            $declaration->documents()->attach($document->id);
        }
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
    public function show(Declaration $declaration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Declaration $declaration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Declaration $declaration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Declaration $declaration)
    {
        //
    }
}
