<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::paginate(20);
        return inertia('Settings/Vehicles/VehiclesIndex', [
            'vehicles' => $vehicles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Settings/Vehicles/VehiclesAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'model' => 'required|max:15',
            'type' => 'required|max:15',
            'register_plate_number' => 'nullable|max:12',
            'max_weight_loaded' => 'nullable|max:6',
            'max_weight_empty' => 'nullable|max:6',
            'payload' => 'nullable|max:6',
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')->with('message', 'Возилото е успешно додаден');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return inertia('Settings/Vehicles/VehiclesEdit', [
            'vehicle' => $vehicle,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'model' => 'required|max:15',
            'type' => 'required|max:15',
            'register_plate_number' => 'nullable|max:12',
            'max_weight_loaded' => 'nullable|max:6',
            'max_weight_empty' => 'nullable|max:6',
            'payload' => 'nullable|max:6',
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.index')->with('message', 'Возилото е успешно Ажурирано');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('message', 'Возилото е успешно избришанo');
    }
}
