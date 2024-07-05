<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShowRequest;
use App\Http\Requests\UpdateShowRequest;
use App\Models\Show;

class ShowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.show.index')
            ->with('shows', Show::all())
        ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.show.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShowRequest $request)
    {
        if (Show::create($request->input())) {
            return redirect(action([self::class, 'index']));
        }

        return redirect(action([self::class, 'create']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Show $show)
    {
        return view('pages.show.show')
            ->with('show', $show)
        ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Show $show)
    {
        return view('pages.show.edit')
            ->with('show', $show)
        ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShowRequest $request, Show $show)
    {
        if ($show->update($request->input())) {
            return redirect(action([self::class, 'index']));
        }

        return redirect(action([self::class, 'update'], ['show' => $show]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Show $show)
    {
        if ($show->delete()) {
            return redirect(action([self::class, 'index']));
        }
        throw new \ErrorException('Unable to delete that show');
    }
}
