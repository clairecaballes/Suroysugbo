<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessageController extends Controller
{
    
    public function index()
    {
        return Inertia::render('Messages/Index', [
        'messages' => Message::all()->map(function ($message) {
            return [
                'id' => $message->id,
                'name' => $message->name,
                'email' => $message->email,
                'subject' => $message->subject,
                'message' => $message->message,
                'created_at' => $message->created_at->format('Y-m-d H:i'), // format as needed
            ];
        }),
    ]);
    }

    public function read($id)
    {
        $message = Message::findOrFail($id);
        $message->is_read = true; // Assuming you have an 'is_read' column
        $message->save();

        return redirect()->route('messages.index')->with('success', 'Message marked as read.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
    public function show($id)
    {
        // Retrieve the message from the database
        // ...

        return view('message.show', compact('message'));
    }
}
