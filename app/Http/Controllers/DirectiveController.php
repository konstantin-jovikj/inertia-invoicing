<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Directive;
use Illuminate\Http\Request;

class DirectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoryDirectivesAndRegulations = Category::with('directives', 'regulations')->get();
        // dd($categoryDirectivesAndRegulations);
        return inertia('DirectivesAssociations/DirectivesAssociationsIndex',[
            'categoryDirectivesAndRegulations' => $categoryDirectivesAndRegulations,
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
    public function show(Directive $directive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Directive $directive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Directive $directive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Directive $directive)
    {
        //
    }
}
