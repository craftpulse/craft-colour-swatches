<?php

namespace percipiolondon\colourswatches\models;

use craft\base\Model;
use craft\helpers\Json;

class ColourSwatches extends Model
{
    /**
     * @var string
     */
    public string $label = '';

    /**
     * @var array|string|null
     */
    public array|string|null $color = null;

    /**
     * @inheritdoc
     */
    public function __construct($value)
    {
        if ($this->validateJson($value)) {
            $colorData = Json::decode($value);
            if (!empty($colorData['label'])) {
                $this->label = $colorData['label'];
                $this->color = $colorData['color'];
            }
        }
    }

    // making sure we have json data, returns boolean(true) if this is the case
    public function validateJson($value): bool
    {
        $json = Json::decode($value);
        return $json && $value != $json;
    }

    public function __toString(): string
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
}
