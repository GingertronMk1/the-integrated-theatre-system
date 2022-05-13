<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrerequisiteRequest;
use App\Http\Requests\UpdatePrerequisiteRequest;
use App\Models\Training\Prerequisite;

class PrerequisiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia("Prerequisite/index", [
            'Prerequisite' => Prerequisite::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePrerequisiteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePrerequisiteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Training\Prerequisite  $prerequisite
     * @return \Illuminate\Http\Response
     */
    public function show(Prerequisite $prerequisite)
    {
        return inertia("Prerequisite/show", [
            'Prerequisite' => $prerequisite,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Training\Prerequisite  $prerequisite
     * @return \Illuminate\Http\Response
     */
    public function edit(Prerequisite $prerequisite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePrerequisiteRequest  $request
     * @param  \App\Models\Training\Prerequisite  $prerequisite
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePrerequisiteRequest $request, Prerequisite $prerequisite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Training\Prerequisite  $prerequisite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prerequisite $prerequisite)
    {
        //
    }
}
