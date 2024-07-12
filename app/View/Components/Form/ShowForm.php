<?php

namespace App\View\Components\Form;

use App\Models\Season;
use App\Models\Show;
use App\Models\Venue;
use App\RendersGenericForm;
use App\View\Components\FormInput;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class ShowForm extends Component
{
    use RendersGenericForm;

    /**
     * Create a new component instance.
     *
     * @param array<Season> $seasons
     */
    public function __construct(
        private readonly Collection $seasons,
        private readonly Collection $venues,
        private readonly ?Show $show = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Closure|string|View
    {
        $show = $this->show;

        if (!$show->id) {
            $show = new Show();
            $show->year = Carbon::now()->year;
        }

        return $this->renderGenericForm(
            inputs: [
                new FormInput(
                    name: 'title',
                    currentValue: $show->title,
                ),
                new FormInput(
                    name: 'description',
                    currentValue: $show->description,
                    type: 'textarea',
                ),
                new FormInput(
                    name: 'year',
                    currentValue: $show->year,
                    type: 'number',
                ),
                new FormInput(
                    name: 'season',
                    currentValue: $show->season?->id,
                    type: 'select',
                    options: $this->seasons,
                    optionValue: fn (Season $season) => $season->id,
                    optionLabel: fn (Season $season) => $season->name,
                ),
                new FormInput(
                    name: 'venue',
                    currentValue: $show->venue?->id,
                    type: 'select',
                    options: $this->venues,
                    optionValue: fn (Venue $venue) => $venue->id,
                    optionLabel: fn (Venue $venue) => $venue->name,
                ),
            ],
            action: $this->show->id ? route('show.update', ['show' => $this->show]) : route('show.store'),
            model: $this->show,
        );
    }
}
