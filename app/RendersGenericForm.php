<?php

namespace App;

use App\View\Components\GenericForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

trait RendersGenericForm
{
    protected function renderGenericForm(
        array $inputs,
        string $action,
        ?Model $model,
        ?bool $update = null,
    ): \Closure|string|View {
        $form = new GenericForm(
            inputs: $inputs,
            action: $action,
            model: $model,
            update: $update,
            calledClass: static::class,
        );

        return $form->render();
    }
}
