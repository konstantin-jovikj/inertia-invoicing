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

    public function directivesAll()
    {
        $directives = Directive::all();
        return inertia('Directives/DirectivesIndex', [
            'directives' => $directives,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Directives/DirectiveAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'directive' => 'required|max:50',
            'description' => 'required|max:255',
        ]);

        Directive::create($validated);

        return redirect()->route('directivesAll.index')->with('message', 'Директивата е успешно додадена');
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
        return inertia('Directives/DirectiveEdit', [
            'directive' => $directive,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Directive $directive)
    {
        $validated = $request->validate([
            'directive' => 'required|max:50',
            'description' => 'required|max:255',
        ]);

        $directive->update($validated);

        return redirect()->route('directivesAll.index')->with('message', 'Директивата е успешно Ажурирана');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Directive $directive)
    {
        if ($directive) {
            $directive->delete();
        }
        return redirect()->route('directivesAll.index')->with('message', 'Директивата е успешно избришана');
    }
}
