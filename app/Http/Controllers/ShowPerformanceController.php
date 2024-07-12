<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePerformanceRequest;
use App\Http\Requests\UpdatePerformanceRequest;
use App\Models\Performance;
use App\Models\Show;
use App\Models\Venue;

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
            ->with('venues', Venue::all())
        ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePerformanceRequest $request, Show $show)
    {
        if ($show->performances()->create($request->only(
            (new Performance())->getFillable(),
        ))) {
            return redirect(action([self::class, 'index'], ['show' => $show]));
        }

        return redirect(action([self::class, 'create']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Show $show, Performance $performance) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Show $show, Performance $performance)
    {
        return view('pages.show.performance.edit')
            ->with('show', $show)
            ->with('performance', $performance)
            ->with('venues', Venue::all())
        ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePerformanceRequest $request, Show $show, Performance $performance)
    {
        if ($performance->update($request->only($performance->getFillable()))) {
            return redirect(action([self::class, 'index'], ['show' => $show]));
        }

        return redirect(action([self::class, 'edit'], ['show' => $show, 'performance' => $performance]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Show $show, Performance $performance)
    {
        if ($performance->delete()) {
            return redirect(action([self::class, 'index'], ['show' => $show]));
        }

        throw new \ErrorException('Unable to delete that performance');
    }
}
