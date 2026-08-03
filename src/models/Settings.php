<?php
/**
 * colour-swatches plugin for Craft CMS 5.x.
 *
 * Let clients choose from a predefined set of colours.
 *
 * @link      https://craft-pulse.com
 *
 * @copyright Copyright (c) 2024 CraftPulse.
 */

namespace percipiolondon\colourswatches\models;

use Craft;
use craft\base\Model;

/**
 * Plugin settings model.
 *
 * @author CraftPulse
 * @since 1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var array The default colour definitions available to fields
     */
    public array $colors = [];

    /**
     * @var array Named colour palettes available to fields
     */
    public array $palettes = [];

    /**
     * @var array|null The default swatch definition
     */
    public ?array $default = null;

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function defineRules(): array
    {
        return [
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
                    if (!is_string($palette)) {
                        foreach ($palette as &$color) {
                            if (is_string($color['color'])) {
                                $color['color'] = json_decode($color['color'], true);
                            }
                        }
                    } else {
                        $palette = [];
                    }
                }
                return $palettes;
            }],
        ];
    }
}
