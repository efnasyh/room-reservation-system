<?php

namespace App\Http\Controllers;

use App\Models\RoomReservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class RoomReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = auth()->user();

        $roomReservations = RoomReservation::with('room')->where('user_id', $user->id)->paginate(10); //room tu ambik kat model
        return view('roomreservations.index', compact('roomReservations')); // pass ke roomreservation.index kat index.blade
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        // get currently logged in user
        $user = auth()->user();

        // $roomId = $request->query('room_id');
        // $room = Room::findOrFail($roomId);


        // Retrieve the room details
        $room = Room::findOrFail(request('room_id'));

        return view('roomreservations.create', compact('user', 'room'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'participant' => 'required|integer|min:1',
            'purpose' => 'required|string|max:65535',
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id'
        ]);

        $room = Room::findOrFail($request->input('room_id'));

        if($request->input('participant') > $room->capacity){
            return redirect()->back()->withErrors([
                'participant' => 'The number of participants exceeds the room capacity of ' . $room->capacity,
            ])->withInput();
        }

        RoomReservation::create(array_merge($validatedData,[
            'room_id' => $request->input('room_id'),
            'user_id' => $request->input('user_id'),    
        ]));

        return redirect()->back()->with('message', 'Reservation successfully sent');
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomReservation $roomReservation)
    {
        //
    

    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(RoomReservation $roomReservation)
    public function edit($id)
    {
        //
        // Manually fetch the RoomReservation instance
    $roomReservation = RoomReservation::with('room')->find($id);

    $user = auth()->user();
    return view('roomreservations.edit', compact('roomReservation', 'user'));
        





        // //dd($roomReservation);
        // $user = auth()->user();
    
        // $roomReservation->load('room');
        // // dd($roomReservation);
        // // dd($roomReservation->room);
        // return view('roomreservations.edit', compact('roomReservation', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        // dd($request->all());
      
        $roomReservation = RoomReservation::findOrFail($id);
        // dd($roomReservation);
        $validatedData = $request->validate([
        'start_date' => [
            'required',
            'date',
            function ($attribute, $value, $fail) use ($roomReservation) {
                // Skip validation if the start_date is unchanged
                if ($value != $roomReservation->start_date && $value < now()->toDateString()) {
                    $fail('The start date must be today or a future date.');
                }
            },
        ],
            'end_date' => 'required|date|after_or_equal:start_date',
            'participant' => 'required|integer|min:1',
            'purpose' => 'required|string|max:65535',
            'room_id' => 'required|exists:rooms,id'
        ]);

        $room = Room::findOrFail($request->input('room_id'));

        if($request->input('participant') > $room->capacity){
            return redirect()->back()->withErrors([
                'participant' => 'The number of participants exceeds the room capacity of ' . $room->capacity,
            ])->withInput();
        }

        // dd($validatedData);

        $roomReservation->update($validatedData);

        return redirect()->back()->with('message', 'Reservation successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(RoomReservation $roomReservation)
    public function destroy($id)
    {
        //
        // dd([
        //     'id' => $roomReservation->id,
        //     'roomReservation' => $roomReservation
        // ]);

        $roomReservation = RoomReservation::findOrFail($id);
    
        $roomReservation->delete();

        return redirect()->back()->with('message', 'Reservation deleted successfully');
    }

    public function bookingListForAdmin(){

        $roomReservations = RoomReservation::paginate(10);

        return view('roomreservations.bookingListForAdmin', compact('roomReservations'));

    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);//kena ada validate

        $roomReservation = RoomReservation::findOrFail($id);
        $roomReservation->status = $request->input('status');//kait dekat blade
        $roomReservation->save();

        return redirect()->back()->with('message', 'Reservation status updated successfully');
    }
}