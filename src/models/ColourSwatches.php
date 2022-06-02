<?php

namespace percipioglobal\colourswatches\models;

use craft\base\Model;

class ColourSwatches extends Model
{
    /**
     * @var string
     */

    public $label = '';
    public $color = '';
    public $class = '';

    public function __construct($value)
    {
        if($this->validateJson($value)){

            // typecast our object to an array
            $colorData = (array)json_decode($value);
            $value = null;
            $color = array_filter($colorData);
                // if our array has usable data
                if (!empty($colorData['label']))
                {
                    $this->label = $colorData['label'];
                    $this->color = $colorData['color'];
                    $this->class = $colorData['class'] ?? '';
                }
                // else ensure we return a null value (only really needed for old data stores)
                else {
                    $value = null;
                }
         // else ensure we return a null value
        } else {
            $value = null;
        }
    }

    // making sure we have json data, returns boolean(true) if this is the case
    public function validateJson($value)
    {
        $json = json_decode($value);
        return $json && $value != $json;
    }

    public function __toString()
    {
        return $this->label;
    }

    public function colors()
    {
        return $this->color;
    }

    public function labels()
    {
        return $this->label;
    }

    public function class(): mixed
    {
        return $this->class;
    }

}
