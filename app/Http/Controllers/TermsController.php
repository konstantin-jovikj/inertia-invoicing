<?php

namespace App\Http\Controllers;

use App\Models\Terms;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $terms = Terms::all();
        return inertia('Settings/Terms/TermsIndex', [
            'terms' => $terms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Settings/Terms/TermsAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'term' => 'required|max:255',
        ]);

        Terms::create($validated);

        return redirect()->route('terms.index')->with('message', 'Условот е успешно додаден');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Terms $terms)
    {
        return inertia ('Settings/Terms/TermsEdit', [
            'terms' => $terms,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Terms $terms)
    {
        $validated = $request->validate([
            'term' => 'required|max:255',
        ]);

        $terms->update($validated);

        return redirect()->route('terms.index')->with('message', 'Условот е успешно Ажуриран');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Terms $terms)
    {
        if ($terms) {
            $terms->delete();
        }
        return redirect()->route('terms.index')->with('message', 'Условот е успешно избришан');
    }
}
