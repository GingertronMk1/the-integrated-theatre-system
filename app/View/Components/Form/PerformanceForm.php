<?php

namespace App\View\Components\Form;

use App\Models\Performance;
use App\Models\Show;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PerformanceForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly Show $show,
        private readonly ?Performance $performance = null
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.performance-form')
            ->with('show', $this->show)
            ->with('performance', $this->performance ?? new Performance());
    }
}
