<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $countries = Country::when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('code', 'like', '%' . $request->search . '%');
        })->paginate(20)->withQueryString();

        return inertia('Settings/Countries', [
            'countries' => $countries,
            'searchTerm' => $request->search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Settings/CountryAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255', 'unique:countries'],
            'code' => ['required', 'max:255', 'unique:countries'],
        ]);
        Country::create($data);
        return redirect()->route('country.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        return inertia('Settings/CountryEdit', [
            'country' => $country
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'id' => 'required|integer|exists:countries,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10',
        ]);

        // Find the country by `id` in the request body
        $country = Country::findOrFail($validated['id']);
        $country->update($validated);

        return redirect()->route('country.index')->with('success', 'Country updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('country.index')->with('success', 'Country updated successfully.');
    }
}
