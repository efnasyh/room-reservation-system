<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Event;
use App\Models\StudentEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
{
    $userId = Auth::id();

    // Get event IDs the user has registered for
    $registeredEventIds = StudentEvent::where('user_id', $userId)->pluck('event_id');

    // Get only the approved events the user has registered for
    $events = Event::whereIn('id', $registeredEventIds)
                   ->where('status', 'approved')
                   ->with(['feedbacks' => function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                   }])
                   ->get();

    return view('feedback.index', compact('events'));
}
    
    /**
     * Show the form for creating a new resource.
     */
    public function create($event_id)
{
    $event = Event::findOrFail($event_id);

    // Check if user is registered
    $isRegistered = \App\Models\StudentEvent::where('event_id', $event_id)
                    ->where('user_id', Auth::id())
                    ->exists();

    if (!$isRegistered) {
        return redirect()->route('feedback.index')->with('error', 'You are not registered for this event.');
    }

    // Check if feedback already submitted
    $existingFeedback = Feedback::where('event_id', $event_id)
                                ->where('user_id', Auth::id())
                                ->first();

    if ($existingFeedback) {
        return redirect()->route('feedback.index')->with('error', 'You have already submitted feedback for this event.');
    }

    return view('feedback.create', compact('event'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $event_id)
    {
        $request->validate([
            'feedback_comments' => 'required|string',
            'improvement_suggestions' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);
    
          // Check again to prevent duplicates (even if someone bypasses frontend)
        $existing = Feedback::where('event_id', $event_id)
                            ->where('user_id', Auth::id())
                            ->exists();

        if ($existing) {
            return redirect()->route('feedback.index')->with('error', 'Feedback already submitted.');
        }


        Feedback::create([
            'event_id' => $event_id,
            'user_id' => Auth::id(),
            'feedback_comments' => $request->feedback_comments,
            'rating' => $request->rating,
            'improvement_suggestions' => $request->improvement_suggestions,
        ]);
    
        return redirect()->route('feedback.index')->with('success', 'Feedback submitted!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
