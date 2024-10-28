<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Country;
use Illuminate\Http\Request;


class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $places = Place::with('country')->when($request->search, function ($query) use ($request) {
            $query->where('place', 'like', '%' . $request->search . '%')
                ->orWhere('zip', 'like', '%' . $request->search . '%');
        })->paginate(20)->withQueryString();



        return inertia('Settings/Places/PlacesIndex', [
            'places' => $places,
            'searchTerm' => $request->search,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();

        return inertia('Settings/Places/PlacesAdd', [
            'countries' => $countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $data = $request->validate([
            'zip' => ['required', 'max:6', 'unique:places'],
            'place' => ['required', 'max:255', 'unique:places'],
            'country_id' => ['required'],
        ]);
        Place::create($data);
        return redirect()->route('place.index')->with('message', 'Местото / Градот е успешно додадена');
    }

    /**
     * Display the specified resource.
     */
    public function show(Place $place)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Place $place)
    {
        $countries = Country::all();

        return inertia('Settings/Places/PlacesEdit', [
            'place' => $place,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Place $place)
    {


        // Validate data
        $validated = $request->validate([
            'id' => 'required|integer|exists:places,id',
            'country_id' => 'required|integer|exists:countries,id',
            'place' => 'required|string|max:255',
            'zip' => 'required|string|max:6',
        ]);

        // Update the record

        $place->update($validated);

        return redirect()->route('place.index')->with('message', 'Градот / Местото е успешно едитирано');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        $place->delete();
        return redirect()->route('place.index')->with('message', 'Градот / Местото е успешно избришано.');
    }
}
