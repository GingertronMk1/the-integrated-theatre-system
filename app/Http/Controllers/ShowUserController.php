<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShowUserRequest;
use App\Http\Requests\UpdateShowUserRequest;
use App\Models\Show\ShowUser;

class ShowUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia("ShowUser/index", [
            'ShowUser' => ShowUser::all(),
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
     * @param  \App\Http\Requests\StoreShowUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShowUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Show\ShowUser  $showUser
     * @return \Illuminate\Http\Response
     */
    public function show(ShowUser $showUser)
    {
        return inertia("ShowUser/show", [
            'ShowUser' => $showUser,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Show\ShowUser  $showUser
     * @return \Illuminate\Http\Response
     */
    public function edit(ShowUser $showUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateShowUserRequest  $request
     * @param  \App\Models\Show\ShowUser  $showUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShowUserRequest $request, ShowUser $showUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Show\ShowUser  $showUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShowUser $showUser)
    {
        //
    }
}
