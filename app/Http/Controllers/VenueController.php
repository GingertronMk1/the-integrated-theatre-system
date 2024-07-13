<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.venue.index')
            ->with('venues', Venue::all())
        ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.venue.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Venue::create($request->only((new Venue())->getFillable()));

        return redirect(action([self::class, 'index']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Venue $venue)
    {
        return view('pages.venue.show')
            ->with('venue', $venue)
        ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venue $venue)
    {
        return view('pages.venue.edit')
            ->with('venue', $venue)
        ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venue $venue)
    {
        $venue->update($request->only($venue->getFillable()));

        return redirect(action([self::class, 'index']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venue $venue)
    {
        $venue->delete();

        return redirect(action([self::class, 'index']));
    }
}
