<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.season.index')
            ->with('seasons', Season::all())
        ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.season.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Season::create($request->only(['name', 'description', 'colour']))) {
            return redirect(action([self::class, 'index']));
        }

        return redirect(action([self::class, 'create']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Season $season)
    {
        return view('pages.season.show')
            ->with('season', $season)
        ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Season $season)
    {
        return view('pages.season.edit')
            ->with('season', $season)
        ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Season $season)
    {
        if ($season->update($request->only(['name', 'description', 'colour']))) {
            return redirect(action([self::class, 'index']));
        }

        return redirect(action([self::class, 'update'], ['season' => $season]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Season $season)
    {
        if ($season->delete()) {
            return redirect(action([self::class, 'index']));
        }

        throw new \ErrorException('Unable to delete that season');
    }
}
