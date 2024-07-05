<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\Show;
use Illuminate\Http\Request;

class ShowPerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Show $show)
    {
        return view('pages.show.performance.index')
            ->with('show', $show)
        ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Show $show)
    {
        return view('pages.show.performance.create')
            ->with('show', $show)
        ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Show $show)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Show $show, Performance $performance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Show $show, Performance $performance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Show $show, Performance $performance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Show $show, Performance $performance)
    {
        //
    }
}
