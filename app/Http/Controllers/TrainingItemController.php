<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingItemRequest;
use App\Http\Requests\UpdateTrainingItemRequest;
use App\Models\TrainingCategory;
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
        return view('pages.trainingItem.create')
            ->with('trainingCategories', TrainingCategory::all())
        ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainingItemRequest $request)
    {
        TrainingItem::create($request->only((new TrainingItem())->getFillable()));

        return redirect(action([self::class, 'index']));
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingItem $trainingItem)
    {
        return view('pages.trainingItem.show')
            ->with('trainingItem', $trainingItem)
        ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingItem $trainingItem)
    {
        return view('pages.trainingItem.edit')
            ->with('trainingItem', $trainingItem)
            ->with('trainingCategories', TrainingCategory::all())
        ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingItemRequest $request, TrainingItem $trainingItem)
    {
        $trainingItem->update($request->only($trainingItem->getFillable()));

        return redirect(action([self::class, 'index']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingItem $trainingItem)
    {
        $trainingItem->delete();

        return redirect(action([self::class, 'index']));
    }
}
