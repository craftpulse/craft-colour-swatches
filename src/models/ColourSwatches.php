<?php

namespace rias\colourswatches\models;

class ColourSwatches
{
    public $value;

    public function __construct($value)
    {
        $this->value = json_decode($value);
    }

    public function __toString()
    {
        return (string) isset($this->value->label) ? $this->value->label : '';
    }

    public function __call($name, $arguments)
    {
        if ($name === 'colours') {
            return explode(',', $this->value->color);
        }

        return $this->value->$name;
    }
}
