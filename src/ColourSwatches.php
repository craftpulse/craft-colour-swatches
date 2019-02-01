<?php
/**
 * color-swatches plugin for Craft CMS 3.x.
 *
 * Let clients choose from a predefined set of colours.
 *
 * @link      https://rias.be
 *
 * @copyright Copyright (c) 2018 Rias
 */

namespace rias\colourswatches;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use rias\colourswatches\fields\ColourSwatches as ColourSwatchesField;
use rias\colourswatches\models\Settings;
use yii\base\Event;

/**
 * Class Colorswatches.
 *
 * @author    Rias
 *
 * @since     1.0.0
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
     * {@inheritdoc}
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

    protected function createSettingsModel()
    {
        return new Settings();
    }
}
