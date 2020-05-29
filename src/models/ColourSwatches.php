<?php

namespace percipioglobal\colourswatches\models;

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
            if (is_array($value)) {
                $this->label = $value['label'];
                $this->color = $value['color'];
            } else {
                $value = json_decode($value);
                $this->label = $value->label;
                $this->color = $value->color;
            }
        }
    }

    public function __toString()
    {
        return $this->label;
    }

    public function colours()
    {
        if (strstr($this->color, ';') !== false) {
            return explode(';', $this->color);
        }

        return explode(',', $this->color);
    }

    public function labels()
    {
        return explode(',', $this->label);
    }
}
