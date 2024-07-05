<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingItemRequest;
use App\Http\Requests\UpdateTrainingItemRequest;
use App\Models\TrainingItem;

class TrainingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.trainingItem.index', [
            'trainingItems' => TrainingItem::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.trainingItem.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainingItemRequest $request)
    {
        if (TrainingItem::create($request->input())) {
            return redirect(action([self::class, 'index']));
        }

        return redirect(action([self::class, 'create']));
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingItem $trainingItem)
    {
        return view('pages.trainingItem.show', [
            'trainingItem' => $trainingItem
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingItem $trainingItem)
    {
        return view('pages.trainingItem.edit', [
            'trainingItem' => $trainingItem
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingItemRequest $request, TrainingItem $trainingItem)
    {
        if ($trainingItem->update($request->input())) {
            return redirect(action([self::class, 'index']));
        }

        return redirect(action([self::class, 'update'], ['trainingItem' => $trainingItem]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingItem $trainingItem)
    {
        if ($trainingItem->delete()) {
            return redirect(action([self::class, 'index']));
        }
        throw new \ErrorException('Unable to delete that trainingItem');
    }
}
