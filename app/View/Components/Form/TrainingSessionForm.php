<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\TrainingSession;
use Illuminate\Database\Eloquent\Collection;

class TrainingSessionForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly Collection $people,
        private readonly Collection $trainingItems,
        private readonly ?TrainingSession $trainingSession = null,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.training-session-form')
            ->with('trainingSession', $this->trainingSession ?? new TrainingSession())
            ->with('people', $this->people)
            ->with('trainingItems', $this->trainingItems)
        ;

    }
}
