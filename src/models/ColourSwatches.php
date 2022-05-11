<?php

namespace percipiolondon\colourswatches\models;

use craft\base\Model;
use craft\helpers\Json;

/**
 * Class ColourSwatches
 *
 * @package percipiolondon\colourswatches\models
 */
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
     * ColourSwatches constructor.
     *
     * @param string|null $value
     */
    public function __construct(?string $value)
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

    /**
     * @param string|null $value
     * @return bool
     */
    public function validateJson(?string $value): bool
    {
        $json = Json::decode($value);
        return $json && $value != $json;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function colors(): mixed
    {
        return $this->color;
    }

    /**
     * @return mixed
     */
    public function labels(): mixed
    {
        return $this->label;
    }
}
