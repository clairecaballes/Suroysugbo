<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    
    public function index()
    {
        return view('message');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Store the message in the database or send an email
        // ...

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
    public function show($id)
    {
        // Retrieve the message from the database
        // ...

        return view('message.show', compact('message'));
    }
}
