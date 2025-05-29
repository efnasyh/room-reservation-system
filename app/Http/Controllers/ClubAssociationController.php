<?php

namespace App\Http\Controllers;

use App\Models\ClubAssociation;
use Illuminate\Http\Request;

class ClubAssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request) // organizer -> list club association
{
    $query = ClubAssociation::query();

    // Apply filter (if any)
    if ($request->has('filter') && $request->filter != 'All') {
        $query->where('categories_type', $request->filter);
    }

    // Apply search (if any)
    if ($request->has('search') && $request->search != '') {
        $query->where('club_name', 'like', '%' . $request->search . '%');
    }

    $clubs = $query->get();

    return view('club_associations.index', compact('clubs'));
}

    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ClubAssociation $clubAssociation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClubAssociation $clubAssociation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClubAssociation $clubAssociation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClubAssociation $clubAssociation)
    {
        //
    }
    
}
