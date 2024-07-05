<?php

namespace App\View\Components\Form;

use App\Models\Person;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class PersonForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly Collection $users,
        private readonly ?Person $person = null,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.person-form')
            ->with('person', $this->person ?? new Person())
            ->with('users', $this->users)
        ;
    }
}
