<?php

namespace App\Http\Controllers;

use App\Models\Curency;
use Illuminate\Http\Request;

class CurencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Curency::paginate(20);
        return inertia('Settings/Currency/CurrencyIndex', [
            'currencies' => $currencies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Settings/Currency/CurrencyAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'code' => 'required',
            'symbol' => 'required',
            'name' => 'required',
        ]);

        Curency::create($validated);

        return redirect()->route('currency.index')->with('message', 'Новата Валута е успешно додадена');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curency $curency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curency $curency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curency $curency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curency $curency)
    {
        $curency->delete();
        return redirect()->route('currency.index')->with('message', 'Валутата е успешно избришана');
    }
}
