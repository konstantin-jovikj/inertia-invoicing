<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $banks = Bank::when($request->search, function ($query) use ($request) {
            $query->where('name_cyr', 'like', '%' . $request->search . '%')
                ->orWhere('name_lat', 'like', '%' . $request->search . '%');
        })->paginate(20)->withQueryString();

        return inertia('Banks/BanksIndex', [
            'banks' => $banks,
            'searchTerm' => $request->search,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Banks/BankAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_cyr' => 'required|string|max:255',
            'name_lat' => 'required|string|max:255',
            'address_cyr' => 'string|max:255',
            'address_lat' => 'string|max:255',
        ]);
        $bank = Bank::create($validatedData);

        return redirect()->route('banks.index')->with('message', 'Банката е успешно додадена.');
        ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        // dd($bank);
        return inertia('Banks/BankEdit', [
            'bank' => $bank,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        // dd($bank);
        $validatedData = $request->validate([
            'name_cyr' => 'required|string|max:255',
            'name_lat' => 'required|string|max:255',
            'address_cyr' => 'string|max:255',
            'address_lat' => 'string|max:255',
        ]);
        $bank->update($validatedData);

        return redirect()->route('banks.index')->with('message', 'Банката е успешно Ажурирана.');
        ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();
        return redirect()->route('banks.index')->with('message', 'Банката е успешно избришана.');
    }
}
