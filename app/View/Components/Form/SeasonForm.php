<?php

namespace App\View\Components\Form;

use App\Models\Season;
use App\RendersGenericForm;
use App\View\Components\FormInput;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SeasonForm extends Component
{
    use RendersGenericForm;

    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly ?Season $season = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Closure|string|View
    {
        return $this->renderGenericForm(
            inputs: [new FormInput(
                name: 'name',
                currentValue: $this->season->name,
            ),
                new FormInput(
                    name: 'colour',
                    type: 'color',
                    currentValue: $this->season->colour,
                ),
                new FormInput(
                    name: 'description',
                    type: 'textarea',
                    currentValue: $this->season->description,
                )],
            action: $this->season?->id ? route('season.update', ['season' => $this->season]) : route('season.store'),
            model: $this->season,
        );
    }
}
