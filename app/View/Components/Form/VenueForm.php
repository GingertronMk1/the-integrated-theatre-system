<?php

namespace App\View\Components\Form;

use App\Models\Venue;
use App\RendersGenericForm;
use App\View\Components\FormInput;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VenueForm extends Component
{
    use RendersGenericForm;

    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly ?Venue $venue = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Closure|string|View
    {
        return $this->renderGenericForm(
            inputs: [
                new FormInput(
                    name: 'name',
                    currentValue: $this->venue?->name,
                ),
                new FormInput(
                    name: 'location',
                    currentValue: $this->venue?->location,
                    type: 'textarea',
                ),
                new FormInput(
                    name: 'location_additional',
                    currentValue: $this->venue?->location,
                    type: 'textarea',
                ),
                new FormInput(
                    name: 'capacity',
                    type: 'number',
                    currentValue: $this->venue?->capacity,
                    inputAttributes: [
                        'min' => 0,
                        'step' => 1,
                    ],
                ),
            ],
            action: $this->venue?->id
                ? route('venue.update', ['venue' => $this->venue])
                : route('venue.store'),
            model: $this->venue,
        );
    }
}
