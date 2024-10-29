<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Companies/CompaniesIndex');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Customer $customer)
    {
        // dd($customer);
       return inertia('Companies/CompanyAdd',[
        'customer' => $customer,
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'customer_id' => 'nullable|exists:customers,id',
            'name' => 'required|string|max:255',
            'reg_number' => 'nullable|string|max:50',
            'tax_number' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional, adjust size limit as needed
            'cert' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional, adjust size limit as needed
            'web' => 'nullable'
        ]);

        // Set is_customer to true if customer_id is provided, else false
        $validatedData['is_customer'] = !empty($validatedData['customer_id']);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validatedData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Handle cert upload
        if ($request->hasFile('cert')) {
            $validatedData['cert'] = $request->file('cert')->store('certs', 'public');
        }

        // Create the company
        $company = Company::create($validatedData);

        return inertia('Contacts/ContactAdd', [
            'company' => $company,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
