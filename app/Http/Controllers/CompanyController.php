<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Document;
use Illuminate\Support\Arr;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $isCustomer = request()->routeIs('companies.index') ? 1 : 0;

        $companies = Company::with('place.country')->where('is_customer', $isCustomer) // eager load relationships
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhereHas('place', function ($query) use ($request) {
                        $query->where('place', 'like', '%' . $request->search . '%');
                    });
            })
            ->paginate(20)
            ->withQueryString();

        return inertia('Companies/CompaniesIndex', [
            'companies' => $companies,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Customer $customer)
    {
        // dd($customer);

        // $isCustomer = request()->routeIs('companies.index') ? 1 : 0;
        $places = Place::all();
        return inertia('Companies/CompanyAdd', [
            'places' => $places,
            'customer' => $customer,
            // 'isCustomer' => $isCustomer,
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
            'place_id' => 'nullable|exists:places,id',
            'name' => 'required|string|max:255',
            'reg_number' => 'nullable|string|max:50',
            'tax_number' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional, adjust size limit as needed
            'cert' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional, adjust size limit as needed
            'web' => 'nullable',
            'address' => 'nullable|string|max:255',
            'phone'=> "nullable",
            'mobile' => "nullable",
            'email' => "nullable",
            'notes' => "nullable",
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

        // Eager load the place and place->country relationship
        $company->load('place.country');
        $company->logo = Storage::url($company->logo);

        // return inertia('Contacts/ContactAdd', [
        //     'company' => $company,
        // ]);

        if ($validatedData['is_customer']) {
            return redirect()->route('companies.index');
        } else {
            return redirect()->route('companies.notcustomer.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company, Request $request)
    {
        $documentTypes = DocumentType::all(); // Fetch all document types for the dropdown
        $clients = Company::where('is_customer', true)->get();

        $documents = Document::with('documentType', 'company', 'curency')
            ->when($request->type, function ($query) use ($request) {
                // Apply type filter only if 'type' is provided
                $query->where('document_type_id', $request->type);
            })
            ->when($request->year, function ($query) use ($request) {
                // Apply year filter only if 'year' is provided
                $query->whereYear('date', $request->year);
            })
            ->where('client_id', $company->id)
            ->when($request->export, function ($query) use ($request) {
                // Apply filter for 'is_for_export' if 'export' checkbox is checked
                if ($request->export == 'извозни') {
                    $query->where('is_for_export', true);
                } elseif ($request->export == 'домашни') {
                    // If export is 'false', ensure only documents with is_for_export = false are shown
                    $query->where('is_for_export', false);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString(); 
        // Eager load the place and place->country relationship
        $company->load('place.country', 'contacts', 'accounts.bank');
        //  dd($company);
        return inertia('Companies/CompanyShow', [
            'company' => $company,
             'documents' => $documents,
            'documentTypes' => $documentTypes,
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $places = Place::with('country')->get();

        return inertia('Companies/CompanyEdit', [
            'places' => $places,
            'company' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:companies,id'],
            'user_id' => ['required', 'exists:users,id'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'place_id' => ['nullable', 'exists:places,id'],
            'name' => ['required', 'string', 'max:255'],
            'reg_number' => ['nullable', 'string', 'max:50'],
            'tax_number' => ['nullable', 'string', 'max:50'],
            'web' => ['nullable'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone'=> ['nullable'],
            'mobile' => ['nullable'],
            'email' => ['nullable'],
            'notes' => ['nullable'],
        ]);

        $validated['customer_id'] = $company->customer_id;
        $validated['is_customer'] = $company->is_customer;


        $company->update($validated);

        if ($validated['is_customer']) {
            return redirect()->route('companies.index');
        } else {
            return redirect()->route('companies.notcustomer.index');
        }
    }

    public function editLogo(Company $company)
    {
        return inertia('Companies/CompanyLogoEdit', [
            'company' => $company,
        ]);
    }

    public function updateLogo(Request $request, Company $company)
    {

        $validated = $request->validate([
            'logo' => 'nullable|image|max:6144', // 6MB max
            'cert' => 'nullable|image|max:6144', // 6MB max
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');

            $company->logo = $logoPath;
            $company->save();
        }

        if ($request->hasFile('cert')) {
            $certPath = $request->file('cert')->store('certs', 'public');

            $company->cert = $certPath;
            $company->save();
        }


        return redirect()->route('companies.notcustomer.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('message', 'Компанијата е успешно избришана.');
    }
}
