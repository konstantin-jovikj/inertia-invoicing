<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Directive;
use App\Models\Regulation;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $regulations = Regulation::all();
        $directives = Directive::all();
        $category->load('regulations','directives');
        // dd($category);

        return inertia('Categories/CategoryAssociationsEdit', [
            'category' => $category,
            'regulations' => $regulations,
            'directives' => $directives,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }

    public function toggleRegulation(Request $request, Category $category)
{
    $validated = $request->validate([
        'regulation_id' => 'required|exists:regulations,id',
        'associate' => 'required|boolean',
    ]);

    if ($validated['associate']) {
        $category->regulations()->attach($validated['regulation_id']);
    } else {
        $category->regulations()->detach($validated['regulation_id']);
    }

    return back()->with('message', 'Регулативата е успешно ажурирана.');
}

public function toggleDirective(Request $request, Category $category)
{
    $validated = $request->validate([
        'directive_id' => 'required|exists:directives,id',
        'associate' => 'required|boolean',
    ]);

    if ($validated['associate']) {
        $category->directives()->attach($validated['directive_id']);
    } else {
        $category->directives()->detach($validated['directive_id']);
    }

    return back()->with('message', 'Директивата е успешно ажурирана.');
}

}
