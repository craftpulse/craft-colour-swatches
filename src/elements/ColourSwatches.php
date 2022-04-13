<?php
/**
 * color-swatches plugin for Craft CMS 3.x.
 *
 * Let clients choose from a predefined set of colours.
 *
 * @link      https://percipio.london
 *
 * @copyright Copyright (c) 2020 Percipio Global Ltd.
 */

namespace percipioglobal\colourswatches\elements;

use craft\base\Element;
use craft\elements\db\ElementQueryInterface;

/**
 * Class Colorswatches.
 *
 * @author    Percipio Global Ltd.
 *
 * @since     1.0.0
 */
class ColourSwatches extends Element
{
    // Static
    // =========================================================================

    /**
     * @inheritDoc
     */
    public static function find(): ElementQueryInterface
    {
        return new ColourSwatchesQuery(static::class);
    }
}
