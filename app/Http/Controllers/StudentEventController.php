<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\StudentEvent;
use Illuminate\Http\Request;

class StudentEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $event = Event::findOrFail($id);
         $user = auth()->user();
        return view('events.registerEventForm', compact('event', 'user'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'matric_no' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'faculty' => 'required|string',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
        ]);
    
        StudentEvent::create([
            'user_id' => auth()->id(),
            'event_id' => $id,
            'student_name' => $request->student_name,
            'matric_no' => $request->matric_no,
            'email' => $request->email,
            'phone' => $request->phone,
            'faculty' => $request->faculty,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status, // update your form to capture this
        ]);

           // Store matric_no in session
            session(['registered_matric_no' => $request->matric_no]);
    
        return redirect()->route('events.register', ['id' => $id])->with('success', 'You have successfully registered!');
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentEvent $studentEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentEvent $studentEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentEvent $studentEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentEvent $studentEvent)
    {
        //
    }
}
