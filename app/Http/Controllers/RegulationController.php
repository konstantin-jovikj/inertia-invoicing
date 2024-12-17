<?php

namespace App\Http\Controllers;

use App\Models\Regulation;
use Illuminate\Http\Request;

class RegulationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regulations = Regulation::all();
        return inertia('Regulations/RegulationsIndex', [
            'regulations' => $regulations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Regulations/RegulationAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'regulation' => 'required|max:50',
            'description' => 'required|max:255',
        ]);

        Regulation::create($validated);

        return redirect()->route('regulations.index')->with('message', 'Регулативата е успешно додадена');
    }

    /**
     * Display the specified resource.
     */
    public function show(Regulation $regulation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Regulation $regulation)
    {
        return inertia('Regulations/RegulationEdit', [
            'regulation' => $regulation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Regulation $regulation)
    {
        $validated = $request->validate([
            'regulation' => 'required|max:50',
            'description' => 'required|max:255',
        ]);

        $regulation->update($validated);

        return redirect()->route('regulations.index')->with('message', 'Регулативата е успешно додадена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Regulation $regulation)
    {
        if ($regulation) {
            $regulation->delete();
        }
        return redirect()->route('regulations.index')->with('message', 'Регулативата е успешно избришана');
    }
}
