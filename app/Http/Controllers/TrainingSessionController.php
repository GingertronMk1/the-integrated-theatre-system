<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingSessionRequest;
use App\Http\Requests\UpdateTrainingSessionRequest;
use App\Models\Person;
use App\Models\TrainingItem;
use App\Models\TrainingSession;

class TrainingSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.trainingSession.index')
            ->with('trainingSessions', TrainingSession::all())
        ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.trainingSession.create')
            ->with('people', Person::all())
            ->with('trainingItems', TrainingItem::all())
        ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainingSessionRequest $request)
    {
        $trainingSession = TrainingSession::create($request->only((new TrainingSession())->getFillable()));

        $trainees = $request->input('trainees', []);
        $trainingItems = $request->input('training_items', []);

        $trainingSession->trainees()->sync($trainees);
        $trainingSession->trainingItems()->sync($trainingItems);

        return redirect(action([self::class, 'edit'], ['trainingSession' => $trainingSession]));
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingSession $trainingSession)
    {
        return view('pages.trainingSession.show')
            ->with('trainingSession', $trainingSession)
        ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingSession $trainingSession)
    {
        return view('pages.trainingSession.edit')
            ->with('trainingSession', $trainingSession)
            ->with('people', Person::all())
            ->with('trainingItems', TrainingItem::all())
        ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingSessionRequest $request, TrainingSession $trainingSession)
    {
        $trainingSession->update($request->only($trainingSession->getFillable()));
        $trainees = $request->input('trainees', []);
        $trainingItems = $request->input('training_items', []);

        $trainingSession->trainees()->sync($trainees);
        $trainingSession->trainingItems()->sync($trainingItems);

        return redirect(action([self::class, 'index']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingSession $trainingSession)
    {
        $trainingSession->delete();

        return redirect(action([self::class, 'index']));
    }
}
