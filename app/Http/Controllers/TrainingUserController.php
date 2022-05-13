<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingUserRequest;
use App\Http\Requests\UpdateTrainingUserRequest;
use App\Models\Training\TrainingUser;

class TrainingUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia("TrainingUser/index", [
            'TrainingUser' => TrainingUser::all(),
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
     * @param  \App\Http\Requests\StoreTrainingUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Training\TrainingUser  $trainingUser
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingUser $trainingUser)
    {
        return inertia("TrainingUser/show", [
            'TrainingUser' => $trainingUser,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Training\TrainingUser  $trainingUser
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingUser $trainingUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingUserRequest  $request
     * @param  \App\Models\Training\TrainingUser  $trainingUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingUserRequest $request, TrainingUser $trainingUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Training\TrainingUser  $trainingUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingUser $trainingUser)
    {
        //
    }
}
