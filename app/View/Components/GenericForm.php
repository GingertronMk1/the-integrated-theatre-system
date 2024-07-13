<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class GenericForm extends Component
{
    /**
     * Create a new component instance.
     *
     * @var array<array<FormInput>|FormInput>
     */
    public function __construct(
        private readonly ?Model $model,
        private readonly array $inputs,
        private readonly string $action,
        private readonly ?bool $update = null,
        private readonly string $calledClass = '',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Closure|string|View
    {
        return view('components.generic-form')
            ->with('model', $this->model)
            ->with('inputs', $this->inputs)
            ->with('action', $this->action)
            ->with('update', $this->update ?? (bool) $this->model->id)
            ->with('calledClass', $this->calledClass)
        ;
    }
}
