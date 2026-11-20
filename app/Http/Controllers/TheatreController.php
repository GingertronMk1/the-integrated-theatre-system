<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\Person;
use App\Models\Show;
use App\Models\TrainingItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class TheatreController extends Controller
{
    public function home(): View
    {
        $now = now();

        return view('welcome', [
            'shows' => Show::query()->whereHas('performances', fn (Builder $query) => $query->where('show_start', '<', $now))
                ->whereDoesntHave('performances', fn (Builder $query) => $query->where('show_start', '>=', $now))
                ->with('performances')->latest()->limit(3)->get(),
            'performances' => Performance::query()->where('show_start', '>', now())->orderBy('show_start')->limit(4)->get(),
            'showCount' => Show::query()->count(),
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
        $now = now();

        return view('theatre.shows', [
            'shows' => Show::query()->whereHas('performances', fn (Builder $query) => $query->where('show_start', '<', $now))
                ->whereDoesntHave('performances', fn (Builder $query) => $query->where('show_start', '>=', $now))
                ->orderBy('name')->paginate(15),
        ]);
    }

    public function show(Show $show): View
    {
        $show->load(['season', 'playwright', 'cast.person', 'crew.person', 'crew.role', 'performances.venue']);

        return view('theatre.show', ['show' => $show]);
    }

    public function performances(): View
    {
        $now = now();

        return view('theatre.performances', [
            'shows' => Show::query()->whereHas('performances', fn (Builder $query) => $query->where('show_start', '>', $now))
                ->with(['performances' => fn ($query) => $query->where('show_start', '>', $now)->with('venue')])
                ->orderBy('name')->paginate(15),
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
