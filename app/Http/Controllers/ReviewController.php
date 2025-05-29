<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Review;

class ReviewController extends Controller
{
      public function index()
    {
        return Inertia::render('Review/Index', [
        'messages' => Review::all()->map(function ($message) {
            return [
                'id' => $message->id,
                'name' => $message->name,
                'email' => $message->email,
                'rating' => $message->rating,
                'isRead' => $message->isRead,
                'message' => $message->message,
                'isPublish' => $message->isPublish ==1 ? true : false, // Assuming you have an 'is_publish' column
                'created_at' => $message->created_at->format('Y-m-d H:i'), // format as needed
            ];
        }),
    ]);
    }

    public function read($id)
    {
        $message = Review::findOrFail($id);
        $message->isRead = true; // Assuming you have an 'is_read' column
        $message->save();

        return redirect()->route('reviews.index')->with('success', 'Message marked as read.');
    }

    public function publish(Request $request,$id)
    {
        $message = Review::findOrFail($id);
        $message->isPublish = $request->input('is_published'); // Assuming you have an 'is_publish' column
        $message->save();

        return redirect()->route('reviews.index')->with('success', 'Message published successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Review::create([
            'name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating,
            'isRead' => false, // Default to unread
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
    public function show()
    {
        $review = Review::where('isPublish', 1)->get();;

        return response()->json([
            'review' => $review,
        ]);
    }
}
