<?php

namespace percipiolondon\colourswatches\models;

use craft\base\Model;

/**
 * Class Settings
 *
 * @package percipiolondon\colourswatches\models
 */
class Settings extends Model
{
    /**
     * @var array
     */
    public array $colors = [];
    /**
     * @var array
     */
    public array $palettes = [];
    /**
     * @var array|null
     */
    public ?array $default = null;

    /**
     * @return array[]
     */
    protected function defineRules(): array
    {
        return [
            [['colors', 'palettes'], 'required'],
            [['colors', 'palettes'], 'array'],
        ];
    }
}
