<?php

namespace App\View\Components\Form;

use App\Models\TrainingCategory;
use App\RendersGenericForm;
use App\View\Components\FormInput;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TrainingCategoryForm extends Component
{
    use RendersGenericForm;

    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly ?TrainingCategory $category = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Closure|string|View
    {
        return $this->renderGenericForm(
            inputs: [
                new FormInput(name: 'name', currentValue: $this->category->name),
                new FormInput(name: 'description', type: 'textarea', currentValue: $this->category->description),
                new FormInput(name: 'advanced', type: 'checkbox', currentValue: $this->category->advanced),
            ],
            action: $this->category->id
                ? route('trainingCategory.update', ['trainingCategory' => $this->category])
                : route('trainingCategory.store'),
            model: $this->category,
        );
    }
}
