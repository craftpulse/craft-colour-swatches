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
    public $colour = '';

    public function __construct($value)
    {
        if (!empty($value)) {
            if (is_array($value)) {
                $this->label = $value['label'];
                $this->color = $value['color'] ? $value['color'] : $value['colour'];
                $this->colour = $this->color;
            } else {
                $value = json_decode($value);
                $this->label = $value->label;
                $this->color = $value->color ? $value->color : $value->colour;
                $this->colour = $this->color;
            }
        }
    }

    public function __toString()
    {
        return $this->label;
    }

    public function colours()
    {
        return $this->colorsToArray();
    }

    public function colors()
    {
       return $this->colorsToArray();
    }

    public function labels()
    {
        return explode(',', $this->label);
    }

    protected function colorsToArray()
    {
        if(is_array($this->color))
        {
            return $this->color;
        }

        if (strstr($this->color, ';') !== false) {
            return explode(';', $this->color);
        }

        return explode(',', $this->color);
    }
}
