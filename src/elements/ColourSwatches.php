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

use Craft;
use craft\base\Element;
use craft\db\Query;
use craft\db\Table;
use craft\elements\Entry;
use craft\elements\actions\Delete;
use craft\elements\actions\Restore;
use craft\elements\db\ElementQueryInterface;

use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\validators\Validator;
use Throwable;


/**
 * Class Colourswatches.
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
