<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Bank;
use App\Models\Company;
use Illuminate\Http\Request;

class AccountController extends Controller
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
    public function create(Company $company)
    {
        $banks = Bank::all();
        return inertia('Accounts/AccountAdd', [
            'banks' => $banks,
            'company' => $company,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'bank_id' => 'required|exists:banks,id',
            'is_for_export' => 'boolean',
            'giro_account' => 'nullable|max:20',
            'account_no' => 'nullable|max:20',
            'swift' => 'nullable|max:20',
            'iban' => 'nullable|max:20',
        ]);

        $account = Account::create($validatedData);
        return redirect()->route('companies.index')->with('message', 'Банкарската сметка е успешно додадена.');
    }

    public function toggleActive(Account $account)
    {
        // dd($account);
        $account->is_active = !$account->is_active;
        $account->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
    }
}
