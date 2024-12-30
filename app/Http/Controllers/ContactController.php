<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
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
        $company->load('place.country');

        return inertia('Contacts/ContactAdd',[
            'company' => $company
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'mob' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'position' => 'nullable|string|max:50',

        ]);

        $company = Contact::create($validatedData);

        // return inertia('Companies/CompaniesIndex');
        return redirect()->route('companies.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        $contact->load('company.place.country');
    
        return inertia('Contacts/ContactEdit', [
            'contact' => $contact,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'mob' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'position' => 'nullable|string|max:50',

        ]);

        $contact->update($validatedData);

        // return inertia('Companies/CompaniesIndex');
        return redirect()->route('company.show',[
            'company' => $contact->company_id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $companyId = $contact->company_id;
        $contact->delete();

        return redirect()->route('company.show', $companyId)
            ->with('message', 'Контактот е успешно избришан.');
    }
}
