<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Country;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Validator;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manufacturers = Manufacturer::all();
        $manufacturers ->load('place.country');

        return inertia('Manufacturers/ManufacturersIndex',[
            'manufacturers' => $manufacturers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        $places = Place::with('country')->get();
        return inertia('Manufacturers/ManufacturerAdd', [
            'places' => $places,
            'countries' => $countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:30',
            'address' => 'required|max:80',
            'place_id' => 'required|exists:places,id',
            'country_id' => 'required|exists:countries,id',
        ]);
    
        // Ensure the place_id belongs to the selected country_id
        $place = Place::where('id', $validated['place_id'])
                      ->where('country_id', $validated['country_id'])
                      ->first();
    
        if (!$place) {
            return back()->withErrors([
                'place_id' => 'Селектираното место не припаѓа на селектираната земја',
            ])->withInput();
        }
    
        // Create the manufacturer
        Manufacturer::create($validated);
    
        // Redirect with success message
        return redirect()->route('manufacturers.index')
                         ->with('message', 'Производителот е успешно додаден.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Manufacturer $manufacturer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manufacturer $manufacturer)
    {
        $countries = Country::all();
        $places = Place::with('country')->get();
        $manufacturer ->load('place.country');
        return inertia('Manufacturers/ManufacturerEdit', [
            'places' => $places,
            'countries' => $countries,
            'manufacturer' => $manufacturer,
        ]);
        // dd($manufacturer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manufacturer $manufacturer)
    {
        $validated = $request->validate([
            'name' => 'required|max:30',
            'address' => 'required|max:80',
            'place_id' => 'required|exists:places,id',
            'country_id' => 'required|exists:countries,id',
        ]);
    
        // Ensure the place_id belongs to the selected country_id
        $place = Place::where('id', $validated['place_id'])
                      ->where('country_id', $validated['country_id'])
                      ->first();
    
        if (!$place) {
            return back()->withErrors([
                'place_id' => 'Селектираното место не припаѓа на селектираната земја',
            ])->withInput();
        }
    
        // Create the manufacturer
        $manufacturer->update($validated);
    
        // Redirect with success message
        return redirect()->route('manufacturers.index')
                         ->with('message', 'Производителот е успешно ажуриран.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manufacturer $manufacturer)
    {
        if($manufacturer){
            $manufacturer->delete();
            return redirect()->route('manufacturers.index')->with('message', 'Производителот е успешно избришан');
        }else{
            return redirect()->route('manufacturers.index')->with('message', 'Производителот не е пронајден');
        }
    }
}
