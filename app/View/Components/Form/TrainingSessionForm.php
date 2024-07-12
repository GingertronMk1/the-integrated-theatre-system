<?php

namespace App\View\Components\Form;

use App\Models\TrainingSession;
use App\RendersGenericForm;
use App\View\Components\FormInput;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class TrainingSessionForm extends Component
{
    use RendersGenericForm;

    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly Collection $people,
        private readonly Collection $trainingItems,
        private readonly ?TrainingSession $trainingSession = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Closure|string|View
    {
        return $this->renderGenericForm(
            model: $this->trainingSession,
            inputs: [
                new FormInput(
                    name: 'trainer_id',
                    type: 'select',
                    currentValue: $this->trainingSession->trainer?->id,
                    options: $this->people,
                    optionValue: fn ($person) => $person->id,
                    optionLabel: fn ($person) => $person->name,
                ),
                new FormInput(
                    name: 'happened_at',
                    type: 'datetime-local',
                    currentValue: $this->trainingSession->happened_at,
                ),
                [
                    new FormInput(
                        name: 'trainees[]',
                        type: 'select',
                        currentValue: $this->trainingSession->trainees()?->pluck('id'),
                        options: $this->people,
                        optionValue: fn ($person) => $person->id,
                        optionLabel: fn ($person) => $person->name,
                        inputAttributes: ['multiple' => true],
                    ),
                    new FormInput(
                        name: 'training_items[]',
                        type: 'select',
                        currentValue: $this->trainingSession->trainingItems()?->pluck('id'),
                        options: $this->trainingItems,
                        optionValue: fn ($item) => $item->id,
                        optionLabel: fn ($item) => $item->name,
                        inputAttributes: ['multiple' => true],
                    ),
                ],
            ],
            action: $this->trainingSession?->id ? route('trainingSession.update', ['trainingSession' => $this->trainingSession]) : route('trainingSession.store'),
        );
    }
}
