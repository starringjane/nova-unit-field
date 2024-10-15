<?php

namespace StarringJane\NovaUnitField;

use Laravel\Nova\Fields\Number;
use NumberFormatter;

class UnitField extends Number
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'unit-field';


    /**
     * The prefix of the field.
     *
     * @var string
     */
    public $prefix;

    /**
     * The suffix of the field.
     *
     * @var string
     */
    public $suffix;

    /**
     * Create a new field.
     *
     * @param string $name
     * @param string|\Closure|callable|object|null $attribute
     * @param  (callable(mixed, mixed, ?string):(mixed))|null  $resolveCallback
     * @return void
     */
    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->displayUsing(function ($value) {
            return !$this->isValidNullValue($value) ? $this->formatUnit($value) : null;
        });
    }

    public function formatUnit($value, $unit = null)
    {
        if(empty($value)) {
            return null;
        }

        $string = '';

        if ($this->prefix) {
            $string .= $this->prefix;
            $string .= ' ';
        }

        $string .= NumberFormatter::create(config('app.locale'), NumberFormatter::DECIMAL)->format($value);

        if ($this->suffix) {
            $string .= ' ';
            $string .= $this->suffix;
        }

        return $string;
    }

    public function prefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function suffix($suffix)
    {
        $this->suffix = $suffix;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'prefix' => $this->prefix,
            'suffix' => $this->suffix,
        ]);
    }
}
