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
        $categories = Category::all();
        return inertia('Categories/CategoriesIndex', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Categories/CategoryAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
        ]);
        Category::create($data);
        return redirect()->route('categories.index')->with('message', 'Категоријата е успешно додадена');
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


    public function editCatName(Category $category)
    {
        return inertia('Categories/CategoryEdit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
       
        $data = $request->validate([
            'name' => ['required'],
        ]);
        $category->update($data);
        return redirect()->route('categories.index')->with('message', 'Категоријата е успешно ажурирана');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('message', 'Категоријата е успешно избришанa');
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
