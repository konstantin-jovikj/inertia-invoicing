<?php

namespace App\Http\Controllers;

use App\Models\CustomerType;
use Illuminate\Http\Request;

class CustomerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customerTypes = CustomerType::paginate(20)->withQueryString();

        return inertia('Settings/CustomerType/CustomerTypeIndex', [
            'customer_types' => $customerTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Settings/CustomerType/CustomerTypeAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            //    dd($request);
               $data = $request->validate([
                'type' => ['required', 'max:255', 'unique:customer_types'],
            ]);
            CustomerType::create($data);
            return redirect()->route('customertype.index')->with('message', 'Новиот тип на Коминтент е успешно додаден');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerType $customerType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerType $customerType)
    {
        // dd($customerType);
        return inertia('Settings/CustomerType/CustomerTypeEdit',[
            'customerType' => $customerType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerType $customerType)
    {
        $validated = $request->validate([
            'type' => ['required', 'max:255', 'unique:customer_types'],
        ]);

        // Update the record

        $customerType->update($validated);

        return redirect()->route('customertype.index')->with('message', 'Типот на Коминтент е успешно едитиран');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerType $customerType)
    {
        $customerType->delete();
        return redirect()->route('customertype.index')->with('message', 'Типот на Коминтент е успешно избришан.');
    }
}
