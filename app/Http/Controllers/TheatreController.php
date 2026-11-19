<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\Person;
use App\Models\Show;
use App\Models\TrainingItem;
use Illuminate\View\View;

class TheatreController extends Controller
{
    public function home(): View
    {
        return view('welcome', [
            'showCount' => Show::query()->count(),
            'performanceCount' => Performance::query()->count(),
            'peopleCount' => Person::query()->count(),
        ]);
    }

    public function dashboard(): View
    {
        return view('dashboard', [
            'showCount' => Show::query()->count(),
            'performanceCount' => Performance::query()->count(),
            'peopleCount' => Person::query()->count(),
            'trainingCount' => TrainingItem::query()->count(),
            'shows' => Show::query()->with(['season', 'playwright'])->latest()->limit(5)->get(),
        ]);
    }

    public function shows(): View
    {
        return view('theatre.shows', [
            'shows' => Show::query()->with(['performances', 'season', 'playwright'])->orderBy('name')->paginate(15),
        ]);
    }

    public function show(Show $show): View
    {
        $show->load(['season', 'playwright', 'cast.person', 'crew.person', 'crew.role', 'performances.venue']);

        return view('theatre.show', ['show' => $show]);
    }

    public function performances(): View
    {
        return view('theatre.performances', [
            'performances' => Performance::query()->with(['show', 'venue'])->orderBy('show_start')->paginate(15),
        ]);
    }

    public function people(): View
    {
        return view('theatre.people', [
            'people' => Person::query()->orderBy('name')->paginate(15),
        ]);
    }

    public function training(): View
    {
        return view('theatre.training', [
            'items' => TrainingItem::query()->with('trainingCategory')->orderBy('name')->paginate(15),
        ]);
    }
}
