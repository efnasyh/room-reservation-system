<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Comment;
use App\Models\StudentEvent;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventNotification;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Display the "Apply Event" form
    public function create()
    {
        return view('events.create');
    }

    // Display all events
    public function index()
    {
        // Get all events
        $events = Event::all();

        // Pass events to the view
        return view('events.index', compact('events'));
    }

    // Handle form submission and store event in the database
    public function store(Request $request)
{
    // Validate the request
    $request->validate([
        'applicant_name' => 'required|string|max:255',
        'matric_no' => 'required|string|max:50',
        'position' => 'required|string|max:255',
        'phone_no' => 'required|string|max:15',
        'fee' => 'required|numeric|min:5',
        'club_name' => 'required|string|max:255',
        'advisor_name' => 'required|string|max:255',
        'email' => 'required|email',
        'program_name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'date' => 'required|date|after:today',
        'allocation_requested' => 'required|integer|min:0',
        'participants' => 'required|integer|min:1',
        'paperwork' => 'required|file|mimes:pdf|max:2048', // Ensure it's a PDF
    ]);

    // Get authenticated user ID
    $userId = Auth::id();

    // Ensure user is logged in
    if (!$userId) {
        return redirect()->route('login')->with('error', 'You must log in to apply for an event.');
    }

    // Store the uploaded paperwork
    $paperworkPath = $request->file('paperwork')->store('paperwork', 'public'); // Store the file

    // Create the event record
    Event::create([
        'user_id' => $userId,
        'applicant_name' => $request->applicant_name,
        'matric_no' => $request->matric_no,
        'position' => $request->position,
        'phone_no' => $request->phone_no,
        'club_name' => $request->club_name,
        'advisor_name' => $request->advisor_name,
        'email' => $request->email,
        'program_name' => $request->program_name,
        'location' => $request->location,
        'date' => $request->date,
        'allocation_requested' => $request->allocation_requested,
        'participants' => $request->participants,
        'paperwork' => $paperworkPath, // Store the path in the event record
        'fee' => $request->fee,
        'status' => 'pending',
    ]);

    // Redirect with success message
    return redirect()->route('events.create')->with('message', 'Event applied successfully!');
}


    // Display the authenticated user's event status
    public function eventStatus()
    {
        $userId = Auth::id();
    
        if (!$userId) {
            return redirect()->route('login')->with('error', 'You must log in to view your events.');
        }
    
        // Ensure you're retrieving the correct events
        $events = Event::where('user_id', $userId)->get();
    
        return view('events.event_status', compact('events'));
    }
    

    public function addComment(Request $request, $eventId)
{
    $request->validate([
        'comment' => 'required|string|max:255',
    ]);

    $event = Event::findOrFail($eventId);
    $event->comments()->create([
        'content' => $request->comment,
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('events.eventRequestedList')->with('message', 'Comment added successfully.');
}   
// public function eventRequestedList()
// {
//     $events = Event::where('status', 'pending')->with('comments')->paginate(10);
//     return view('events.eventRequestedList', compact('events'));
// }

public function eventRequestedList()
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'You must log in to view event requests.');
    }
    // Fetch events based on role
    if ($user->role === 'mpp') {
        // MPP can only see events with allocation below RM5000
        $events = Event::where('status', 'pending')
            ->where('allocation_requested', '<', 5000)
            ->with('comments')
            ->paginate(10);
    } elseif ($user->role === 'admin') {
        // Admin can only see events with allocation RM5000 and above
        $events = Event::where('status', 'pending')
            ->where('allocation_requested', '>=', 5000)
            ->with('comments')
            ->paginate(10);
    } else {
        // Other users not authorized
        return redirect()->back()->with('error', 'You are not authorized to view this page.');
    }

    return view('events.eventRequestedList', compact('events'));
}

    

    public function updateStatus(Request $request, Event $event)
    {   
        // Validate the status
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // Ensure there is at least one comment before allowing a status change
        if ($event->comments->count() == 0) {
            return redirect()->back()->with('error', 'Please add a comment before updating the status.');
        }

        // Update the status
        $event->status = $request->status;
        $event->save();
    
        // Redirect back with a success message
        return redirect()->route('events.eventRequestedList')->with('message', 'Event status updated successfully!');
    }
    
    public function comments($eventId)
{
    // Fetch the event and its associated comments
    $event = Event::with('comments')->findOrFail($eventId);

    // Return the view and pass the event and its comments
    return view('events.comments', compact('event'));
}

public function showEventStatus()
{
    $events = Event::with('comments')->get(); // Eager loading comments

    return view('event_status', compact('events'));
}

// Handle updating event status and adding a comment
public function updateStatusAndComment(Request $request, $eventId)
{
    $request->validate([
        'status' => 'required|in:pending,approved,rejected',
        'comment' => 'nullable|string|max:255',
    ]);

    $event = Event::findOrFail($eventId);
    $event->status = $request->status;
    $event->save();

    if ($request->comment) {
        $event->comments()->create([
            'content' => $request->comment,
            'user_id' => Auth::id(),
        ]);
    }

    return redirect()->route('events.eventRequestedList')->with('message', 'Event status and comment updated successfully.');
}

public function download($id)
{
    $event = Event::findOrFail($id);
    $pathToFile = storage_path('app/public/events/paperwork/' . $event->paperwork);

    // Check if the file exists
    if (file_exists($pathToFile)) {
        return response()->download($pathToFile);
    } else {
        return redirect()->route('events.eventRequestedList')->with('error', 'File not found.');
    }
}


public function eventCalendar()
{
    // Fetch events from the database (replace this with your actual logic)
    $events = Event::where('status', 'approved')->get();

    // Return the view with the events data
    return view('events.event_calendar', ['events' => $events]);
}

public function showCalendar()
{
    $events = Event::all(); // Replace with your event retrieval logic
    return view('events.event_calendar', ['events' => $events]);
}

public function destroy($id)
{
    $event = Event::findOrFail($id);

    // Ensure only the owner can delete their events
    if ($event->user_id !== Auth::id()) {
        return redirect()->route('events.status')->with('error', 'You are not authorized to delete this event.');
    }

    // Delete the event
    $event->delete();

    return redirect()->route('events.status')->with('message', 'Event deleted successfully!');
}



public function eventReport() //MPP HEP -> TOTAL EVENTS BY CLUB
{
    // Get the count of events grouped by club_name
    $eventsPerClub = DB::table('club_associations')
        ->leftJoin('events', 'club_associations.club_name', '=', 'events.club_name')
        ->select('club_associations.club_name', DB::raw('count(events.id) as total_events'))
        ->groupBy('club_associations.club_name')
        ->get();

    return view('events.report', compact('eventsPerClub'));
}

// public function eventListReport()
// {
//     // Retrieve all events with their related data
//     $events = Event::all();

//     return view('events.list-report', compact('events'));
// }

// public function eventListReport(Request $request) //MPP HEP -> EVENT DETAILS OF EVERY CLUB
// {
//     $search = $request->query('search');

//     $query = Event::query();

//     if ($search) {
//         $query->where('program_name', 'like', "%$search%")
//               ->orWhere('club_name', 'like', "%$search%");
//     }

//     $events = $query->get();

//     return view('events.list-report', compact('events', 'search'));
// }
public function eventListReport(Request $request)
{
    $search = $request->query('search');

    $query = Event::query();

    if ($search) {
        $query->where('program_name', 'like', "%$search%")
              ->orWhere('club_name', 'like', "%$search%");
    }

    $events = $query->get();

    $totalEvents = $events->count();

    // Only approved events
    $approvedEvents = $events->where('status', 'approved');

    // Join with club_associations to get categories
    $byAssociation = DB::table('events')
        ->join('club_associations', DB::raw('LOWER(events.club_name)'), '=', DB::raw('LOWER(club_associations.club_name)'))
        ->where('events.status', 'approved')
        ->where('club_associations.categories_type', 'Association / Club')
        ->count();

    $byUniform = DB::table('events')
        ->join('club_associations', DB::raw('LOWER(events.club_name)'), '=', DB::raw('LOWER(club_associations.club_name)'))
        ->where('events.status', 'approved')
        ->where('club_associations.categories_type', 'Uniform')
        ->count();

    $byResidential = DB::table('events')
        ->join('club_associations', DB::raw('LOWER(events.club_name)'), '=', DB::raw('LOWER(club_associations.club_name)'))
        ->where('events.status', 'approved')
        ->where('club_associations.categories_type', 'Residential College')
        ->count();

    $approved = $approvedEvents->count();
    $rejected = $events->where('status', 'rejected')->count();

    return view('events.list-report', compact(
        'events', 'search', 'totalEvents',
        'byAssociation', 'byUniform', 'byResidential',
        'approved', 'rejected'
    ));
}


// public function report(Request $request)
// {
//     $filter = $request->query('filter');

//     $query = \DB::table('club_associations')
//         ->leftJoin('events', function ($join) {
//             $join->on('club_associations.club_name', '=', 'events.club_name')
//                  ->where('events.status', 'Approved');
//         });

//     // Apply category filter (only on club_associations table)
//     if ($filter && $filter !== 'All') {
//         $query->where('club_associations.categories_type', $filter);
//     }

//     $eventsPerClub = $query
//         ->select('club_associations.club_name', \DB::raw('COUNT(events.id) as total_events'))
//         ->groupBy('club_associations.club_name')
//         ->get();

//     return view('events.report', compact('eventsPerClub'));
// }


public function report(Request $request)
{
    $filter = $request->query('filter');
    $search = $request->query('search');

    // Get base query for events per club
    $query = DB::table('club_associations')
        ->leftJoin('events', function ($join) {
            $join->on('club_associations.club_name', '=', 'events.club_name')
                 ->where('events.status', 'Approved');
        });

    if ($filter && $filter !== 'All') {
        $query->where('club_associations.categories_type', $filter);
    }

    if ($search) {
        $query->where('club_associations.club_name', 'like', '%' . $search . '%');
    }

    $eventsPerClub = $query
        ->select('club_associations.club_name', DB::raw('COUNT(events.id) as total_events'))
        ->groupBy('club_associations.club_name')
        ->get();

    // Total number of approved events
    $totalEvents = DB::table('events')->where('status', 'Approved')->count();

    // Total number of clubs by category
    $residentialClubCount = DB::table('club_associations')->where('categories_type', 'Residential College')->count();
    $uniformClubCount = DB::table('club_associations')->where('categories_type', 'Uniform')->count();
    $associationClubCount = DB::table('club_associations')->where('categories_type', 'Association / Club')->count();

    return view('events.report', [
        'eventsPerClub' => $eventsPerClub,
        'totalEvents' => $totalEvents,
        'residentialClubCount' => $residentialClubCount,
        'uniformClubCount' => $uniformClubCount,
        'associationClubCount' => $associationClubCount,
    ]);
}


// public function report(Request $request) // MPP HEP -> TOTAL EVENTS BY CLUB
// {
//     $filter = $request->query('filter');
//     $search = $request->query('search');

//     $query = \DB::table('club_associations')
//         ->leftJoin('events', function ($join) {
//             $join->on('club_associations.club_name', '=', 'events.club_name')
//                  ->where('events.status', 'Approved');
//         });

//     // Apply category filter (if any)
//     if ($filter && $filter !== 'All') {
//         $query->where('club_associations.categories_type', $filter);
//     }

//     // Apply search filter (if any)
//     if ($search) {
//         $query->where('club_associations.club_name', 'like', '%' . $search . '%');
//     }

//     $eventsPerClub = $query
//         ->select('club_associations.club_name', \DB::raw('COUNT(events.id) as total_events'))
//         ->groupBy('club_associations.club_name')
//         ->get();

//     return view('events.report', compact('eventsPerClub'));
// }


// public function viewReport($eventId)
// {
//     // Get the event by ID
//     $event = Event::findOrFail($eventId);

//     // Assuming the paperwork is stored in a 'paperwork' folder on disk
//     // and the file name is stored in a 'paperwork_file' column in the events table
//     $filePath = storage_path('app/public/paperwork/' . $event->paperwork_file);

//     if (file_exists($filePath)) {
//         return response()->download($filePath);
//     } else {
//         return redirect()->route('events.listReport')->with('error', 'Paperwork not found.');
//     }
// }

public function viewReport($eventId) //ORGANIZER -> REPORT ANALYSIS -> VIEW REPORT
{
    // Get the event with its student registrations and feedback
    $event = Event::with(['studentRegistrations', 'feedbacks'])->findOrFail($eventId);

    return view('events.viewReport', compact('event'));
}

public function downloadPaperwork($eventId)
{
    $event = Event::findOrFail($eventId);
    $filePath = storage_path('app/public/paperwork/' . $event->paperwork_file);

    if (file_exists($filePath)) {
        return response()->download($filePath);
    } else {
        return redirect()->back()->with('error', 'Paperwork not found.');
    }
}


public function showRegistrationForm($eventId)
    {
        $event = Event::findOrFail($eventId);
        return view('events.registerEventForm', compact('event'));  // Updated view name
    }

    // Store the registration data
    public function storeRegistration(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        // Validate the registration form input
        $request->validate([
            'student_name' => 'required|string|max:255',
            'matric_no' => 'required|string|max:20',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
        ]);

        // Store the registration data (you can adjust the logic to save into a related table like EventRegistration)
        // For now, we're just redirecting back to the event details page

        // You can add code here to store the registration data in the database

        return redirect()->route('events.register', $eventId)->with('message', 'Successfully registered for the event!');
    }

    // public function userOrganizedEvents()
    // {
    //     $user = Auth::user();

    // // Assuming user has a clubAssociation relationship
    // $events = Event::where('user_id', $user->id)
    //                 ->where('status', 'approved') // Only approved events
    //                 ->withCount('studentRegistrations') //Add registration count
    //                 ->get();

    // return view('events.userOrganizedEvents', compact('events'));
    // }

    public function userOrganizedEvents(Request $request) // ORGANIZER -> report and analysis
{
    $user = Auth::user();
    $search = $request->input('search');

    $eventsQuery = Event::where('user_id', $user->id)
                        ->where('status', 'approved')
                        ->withCount('studentRegistrations');

    if ($search) {
        $eventsQuery->where(function($query) use ($search) {
            $query->where('program_name', 'like', '%' . $search . '%')
                  ->orWhere('date', 'like', '%' . $search . '%');
        });
    }

    $events = $eventsQuery->get();

    return view('events.userOrganizedEvents', compact('events', 'search'));
}


    // public function upcomingEvents()
    // {
    //     $events = Event::where('status', 'approved')
    //         ->whereDate('date', '>=', now()) // Only upcoming dates
    //         ->orderBy('date', 'asc') // Sort by date ascending
    //         ->get();

    //     return view('events.upcomingEvents', compact('events'));
    // }

    public function upcomingEvents(Request $request)
    {
        // Get upcoming events
        $events = Event::where('status', 'approved')
            ->whereDate('date', '>=', now())
            ->orderBy('date', 'asc')
            ->get();
    
        $registeredEvents = collect(); // Empty collection by default
    
        if (auth()->check()) {
            $email = auth()->user()->email;
            $registeredEvents = \App\Models\StudentEvent::with('event')
                ->where('email', $email)
                ->get();
        }
        // Check if matric_no is stored in session (after registration)
        elseif ($request->session()->has('registered_matric_no')) {
            $registeredEvents = \App\Models\StudentEvent::with('event')
                ->where('matric_no', $request->session()->get('registered_matric_no'))
                ->get();
        }
    
        return view('events.upcomingEvents', compact('events', 'registeredEvents'));
    }
    
    
    // public function register($id)
    // {
    //     $event = Event::findOrFail($id);

    //     return view('events.registerEventForm', compact('event'));
    // }

    public function register($id)
{
    $event = Event::findOrFail($id);

    // Get student identity (from authenticated user or session)
    $user = Auth::user();
    $email = $user?->email;
    $matricNo = session('registered_matric_no');

    // Check if student has already registered for this event
    $alreadyRegistered = false;

    if ($email) {
        $alreadyRegistered = StudentEvent::where('event_id', $id)
            ->where('email', $email)
            ->exists();
    } elseif ($matricNo) {
        $alreadyRegistered = StudentEvent::where('event_id', $id)
            ->where('matric_no', $matricNo)
            ->exists();
    }

    if ($alreadyRegistered) {
        return redirect()->route('events.upcoming')->with('success', 'You have already registered for this event.');
    }

    // If not registered, show the form
    return view('events.registerEventForm', compact('event'));
}

public function notifyRegisteredStudents($eventId)
{
    $event = Event::findOrFail($eventId);

    // Get all student registrations for the event
    $studentRegistrations = StudentEvent::where('event_id', $eventId)->get();

    foreach ($studentRegistrations as $registration) {
        if ($registration->email) {
            // You can create a Mailable that takes the event and student name
            Mail::to($registration->email)->send(new EventNotification($event, $registration->student_name));
        }
    }

    return back()->with('success', 'Emails sent to all registered students.');
}
}
