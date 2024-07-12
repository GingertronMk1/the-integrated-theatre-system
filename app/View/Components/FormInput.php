<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Symfony\Component\Uid\UuidV7;

class FormInput extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        private readonly string $name,
        private readonly string $type = 'text',
        private readonly null|iterable|string $currentValue = null,
        private readonly string $label = '',
        private readonly iterable $options = [],
        private readonly array $inputAttributes = [],
        private readonly ?\Closure $optionValue = null,
        private readonly ?\Closure $optionLabel = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Closure|string|View
    {
        $label = $this->label;
        if (empty($this->label)) {
            $label = implode(
                ' ',
                array_map(
                    fn (string $str) => ucfirst($str),
                    preg_split('/[^A-Za-z0-9]/', $this->name),
                ),
            );
        }

        $optionValue = $this->optionValue;
        if (is_null($optionValue)) {
            $optionValue = fn ($var) => $var;
        }

        $optionLabel = $this->optionLabel;
        if (is_null($optionLabel)) {
            $optionLabel = fn ($var) => $var;
        }

        $currentValue = $this->currentValue;

        if ('select' === $this->type) {
            if (is_iterable($currentValue)) {
                $currentValue = iterator_to_array($currentValue);
            } else {
                $currentValue = [$currentValue];
            }
        }

        return view('components.form-input')
            ->with('name', $this->name)
            ->with('id', (string) UuidV7::generate().$this->name)
            ->with('currentValue', $currentValue)
            ->with('type', $this->type)
            ->with('label', $label)
            ->with('options', $this->options)
            ->with('inputAttributes', $this->inputAttributes)
            ->with('optionValue', $optionValue)
            ->with('optionLabel', $optionLabel)
        ;
    }
}
