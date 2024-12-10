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
        return inertia('Settings/Declarations/DeclarationAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:50',
            'content' => 'required|max:255',
        ]);

        Declaration::create($validated);

        return redirect()->route('declarations.index')->with('message', 'Декларацијата е успешно додадена');
    }

    /**
     * Display the specified resource.
     */
    public function show(Declaration $declaration)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Declaration $declaration)
    {
        return inertia('Settings/Declarations/DeclarationEdit',[
            'declaration' => $declaration,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Declaration $declaration)
    {
        $validated = $request->validate([
            'title' => 'required|max:50',
            'content' => 'required|max:255',
        ]);

        $declaration->update($validated);

        return redirect()->route('declarations.index')->with('message', 'Декларацијата е успешно ажурирана');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Declaration $declaration)
    {
        $declaration->delete();

        return redirect()->route('declarations.index')->with('message', 'Декларацијата е успешно избришана');
    }
}
