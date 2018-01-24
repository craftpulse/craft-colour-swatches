<?php

namespace rias\colourswatches\models;

class ColourSwatches
{
    /**
     * @var string
     */
    public $label = '';

    /**
     * @var string
     */
    public $color = '';

    public function __construct($value)
    {
        if (!empty($value)) {
            $value = json_decode($value);

            $this->label = $value->label;
            $this->color = $value->color;
        }
    }

    public function __toString()
    {
        return $this->label;
    }

    public function colours()
    {
        return explode(',', $this->color);
    }
}
