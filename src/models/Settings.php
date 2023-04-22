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
            [['colors', 'palettes'], function ($attribute, $params) {
                if (!is_array($this->colors)) {
                    $this->addError('colors', Craft::t('colour-swatches', 'colors is not array!'));
                }

                if (!is_array($this->palettes)) {
                    $this->addError('palettes', Craft::t('colour-swatches', 'palettes is not array!'));
                }
            }],
            [['palettes'], 'filter', 'filter' => function ($palettes) {
                foreach ($palettes as &$palette) {
                    foreach ($palette as &$color) {
                        if (is_string($color['color'])) {
                            $color['color'] = json_decode($color['color'], true);
                        }
                    }
                }
                
                return $palettes;
            }]
        ];
    }
}
