<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingSessionRequest;
use App\Http\Requests\UpdateTrainingSessionRequest;
use App\Models\TrainingSession;

class TrainingSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.trainingSession.index')
            ->with('trainingSessions', TrainingSession::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.trainingSession.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainingSessionRequest $request)
    {
        if (TrainingSession::create($request->input())) {
            return redirect(action([self::class, 'index']));
        }

        return redirect(action([self::class, 'create']));
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingSession $trainingSession)
    {
        return view('pages.trainingSession.show')
            ->with('trainingSession', $trainingSession);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingSession $trainingSession)
    {
        return view('pages.trainingSession.edit')
            ->with('trainingSession', $trainingSession);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingSessionRequest $request, TrainingSession $trainingSession)
    {
        if ($trainingSession->update($request->input())) {
            return redirect(action([self::class, 'index']));
        }

        return redirect(action([self::class, 'update'], ['trainingSession' => $trainingSession]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingSession $trainingSession)
    {
        if ($trainingSession->delete()) {
            return redirect(action([self::class, 'index']));
        }
        throw new \ErrorException('Unable to delete that trainingSession');
    }
}
