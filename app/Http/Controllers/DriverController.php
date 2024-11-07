<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = Driver::paginate(20);
        return inertia('Settings/Drivers/DriversIndex', [
            'drivers' => $drivers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Settings/Drivers/DriversAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|max:30',
            'surname' => 'required|max:30',
            'licence_no' => 'nullable|max:30',
            'personal_id_no' => 'nullable|max:30',
        ]);

        Driver::create($validated);

        return redirect()->route('drivers.index')->with('message', 'Возачот е успешно додаден');
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        return inertia('Settings/Drivers/DriverEdit', [
            'driver' => $driver,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        // dd($request->all(), $driver);
        $validated = $request->validate([
            'name' => 'required|max:30',
            'surname' => 'required|max:30',
            'licence_no' => 'nullable|max:30',
            'personal_id_no' => 'nullable|max:30',
        ]);

        $driver->update($validated);

        return redirect()->route('drivers.index')->with('message', 'Возачот е успешно ажуриран');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {

        $driver->delete();
        return redirect()->route('drivers.index')->with('message', 'Возачот е успешно избришан');
    }
}
