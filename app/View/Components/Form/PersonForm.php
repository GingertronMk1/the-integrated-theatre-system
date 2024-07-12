<?php

namespace App\View\Components\Form;

use App\Models\Person;
use App\RendersGenericForm;
use App\View\Components\FormInput;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class PersonForm extends Component
{
    use RendersGenericForm;

    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly Collection $users,
        private readonly ?Person $person = null,
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
                    currentValue: $this->person->name,
                ),
                new FormInput(
                    name: 'start_year',
                    type: 'datetime-local',
                    currentValue: $this->person->start_year,
                ),
                new FormInput(
                    name: 'end_year',
                    type: 'datetime-local',
                    currentValue: $this->person->end_year,
                ),
                new FormInput(
                    name: 'user_id',
                    type: 'select',
                    currentValue: $this->person->user?->id,
                    options: $this->users,
                    optionValue: fn ($user) => $user->id,
                    optionLabel: fn ($user) => $user->email,
                ),
            ],
            action: $this->person->id ? route('person.update', ['person' => $this->person]) : route('person.store'),
            model: $this->person,
        );
    }
}
