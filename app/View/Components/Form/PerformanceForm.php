<?php

namespace App\View\Components\Form;

use App\Models\Performance;
use App\Models\Show;
use App\RendersGenericForm;
use App\View\Components\FormInput;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class PerformanceForm extends Component
{
    use RendersGenericForm;

    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly Show $show,
        private readonly Collection $venues,
        private readonly ?Performance $performance = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Closure|string|View
    {
        $performance = $this->performance;
        if (!$performance->id) {
            $performance = new Performance();
            $performance->venue = $this->show->venue;
        }

        return $this->renderGenericForm(
            inputs: [
                new FormInput(name: 'show_start', currentValue: $performance->show_start, type: 'datetime-local'),
                new FormInput(name: 'doors', currentValue: $performance->doors, type: 'datetime-local'),
                new FormInput(name: 'venue_id', type: 'select', currentValue: $performance->venue?->id, options: $this->venues, optionLabel: fn ($venue) => $venue->name, optionValue: fn ($venue) => $venue->id),
                new FormInput(name: 'capacity', currentValue: $performance->capacity, type: 'number'),
            ],
            action: $performance->id ? route('show.performance.update', ['show' => $this->show, 'performance' => $performance]) : route('show.performance.store', ['show' => $this->show]),
            model: $performance,
        );
    }
}
