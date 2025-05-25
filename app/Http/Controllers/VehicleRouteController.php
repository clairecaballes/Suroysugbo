<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class VehicleRouteController extends Controller
{
    public function index()
    {
       
        return Inertia::render('VehicleRoute/Index', [
            'vehicleRoutes' => [], // Replace with actual data retrieval logic
        ]);
    }

    public function show($id)
    {
        // Logic to retrieve and display a specific vehicle route
        return view('vehicle-route.show', compact('id'));
    }

    public function create()
    {
        // Logic to show a form for creating a new vehicle route
        return view('vehicle-route.create');
    }

    public function store(Request $request)
    {
        // Logic to store a new vehicle route
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Store the route in the database
        // ...

        return redirect()->route('vehicle-route.index')->with('success', 'Vehicle route created successfully!');
    }
}
