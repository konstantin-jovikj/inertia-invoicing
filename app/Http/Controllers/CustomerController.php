<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Customer;
use App\Models\CustomerType;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
        $customerTypes = CustomerType::all();
        return inertia('Customers/CustomerAdd',[
            'customer_types' => $customerTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                   //    dd($request);
                   $validated = $request->validate([
                    'customer_type_id' => ['required', 'integer'],
                ]);
                $customer = Customer::create($validated);
                $places = Place::all();
                // dd($customer);
                // return redirect()->route('company.create', ['customer' => $customer]);

                return inertia('Companies/CompanyAdd',[
                    'customer' => $customer,
                    'places' => $places,
                   ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
