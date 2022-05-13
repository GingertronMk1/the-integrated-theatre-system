<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePerformanceRequest;
use App\Http\Requests\UpdatePerformanceRequest;
use App\Models\Show\Performance;

class PerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia("Performance/index", [
            'Performance' => Performance::all(),
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
     * @param  \App\Http\Requests\StorePerformanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePerformanceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Show\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function show(Performance $performance)
    {
        return inertia("Performance/show", [
            'Performance' => $performance,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Show\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function edit(Performance $performance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePerformanceRequest  $request
     * @param  \App\Models\Show\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePerformanceRequest $request, Performance $performance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Show\Performance  $performance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Performance $performance)
    {
        //
    }
}
