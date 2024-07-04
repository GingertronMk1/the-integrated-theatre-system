<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingCategoryRequest;
use App\Http\Requests\UpdateTrainingCategoryRequest;
use App\Models\TrainingCategory;

class TrainingCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.trainingCategory.index', [
            'trainingCategories' => TrainingCategory::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.trainingCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainingCategoryRequest $request)
    {
        if (TrainingCategory::create($request->input())) {
            return redirect(action([self::class, 'index']));
        }

        return redirect(action([self::class, 'create']));
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingCategory $trainingCategory)
    {
        return view('pages.trainingCategory.show', [
            'trainingCategory' => $trainingCategory
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingCategory $trainingCategory)
    {
        return view('pages.trainingCategory.edit', [
            'trainingCategory' => $trainingCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingCategoryRequest $request, TrainingCategory $trainingCategory)
    {
        if ($trainingCategory->update($request->input())) {
            return redirect(action([self::class, 'index']));
        }

        return redirect(action([self::class, 'update'], ['trainingCategory' => $trainingCategory]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingCategory $trainingCategory)
    {
        if ($trainingCategory->delete()) {
            return redirect(action([self::class, 'index']));
        }
        throw new \ErrorException('Unable to delete that trainingCategory');
    }
}
