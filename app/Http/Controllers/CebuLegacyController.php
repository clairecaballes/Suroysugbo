<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CebuLegacyController extends Controller
{
    public function index()
    {
        return view('cebu-legacy');
    }

    public function show($id)
    {
        // Logic to retrieve and display a specific Cebu legacy item
        return view('cebu-legacy.show', compact('id'));
    }

    public function create()
    {
        // Logic to show a form for creating a new Cebu legacy item
        return view('cebu-legacy.create');
    }

    public function store(Request $request)
    {
        // Logic to store a new Cebu legacy item
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Store the item in the database
        // ...

        return redirect()->route('cebu-legacy.index')->with('success', 'Cebu legacy item created successfully!');
    }
}
