<?php
/**
 * color-swatches plugin for Craft CMS 3.x
 *
 * Let clients choose from a predefined set of colours.
 *
 * @link      https://rias.be
 * @copyright Copyright (c) 2018 Rias
 */

namespace rias\colourswatches;

use rias\colourswatches\models\Settings;
use rias\colourswatches\fields\ColourSwatches as ColourSwatchesField;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;

use yii\base\Event;

/**
 * Class Colorswatches
 *
 * @author    Rias
 * @package   Colour Swatches
 * @since     1.0.0
 *
 */
class ColourSwatches extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var ColourSwatches
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = ColourSwatchesField::class;
            }
        );
    }
}
