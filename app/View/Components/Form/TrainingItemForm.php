<?php

namespace App\View\Components\Form;

use App\Models\TrainingItem;
use App\RendersGenericForm;
use App\View\Components\FormInput;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class TrainingItemForm extends Component
{
    use RendersGenericForm;

    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly Collection $trainingCategories,
        private readonly ?TrainingItem $trainingItem = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Closure|string|View
    {
        return $this->renderGenericForm(
            model: $this->trainingItem,
            inputs: [
                new FormInput(
                    name: 'name',
                    currentValue: $this->trainingItem?->name,
                ),
                new FormInput(
                    name: 'description',
                    type: 'textarea',
                    currentValue: $this->trainingItem?->description,
                ),
                new FormInput(
                    name: 'dangerous',
                    type: 'checkbox',
                    currentValue: $this->trainingItem?->dangerous,
                ),
                new FormInput(
                    name: 'training_category_id',
                    type: 'select',
                    currentValue: $this->trainingItem?->trainingCategory?->id,
                    options: $this->trainingCategories,
                    optionValue: fn ($cat) => $cat->id,
                    optionLabel: fn ($cat) => $cat->name,
                ),
            ],
            action: $this->trainingItem?->id ? route('trainingItem.update', ['trainingItem' => $this->trainingItem]) : route('trainingItem.store'),
        );
    }
}
