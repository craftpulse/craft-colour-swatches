<?php

namespace percipiolondon\colourswatches\models;

use craft\base\Model;

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
     * @inheritdoc
     */
    protected function defineRules(): array
    {
        return [
            [['colors', 'palettes'], 'required'],
            [['colors', 'palettes'], 'array'],
        ];
    }
}
