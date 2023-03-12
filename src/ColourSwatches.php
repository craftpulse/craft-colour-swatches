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

namespace percipiolondon\colourswatches;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use percipiolondon\colourswatches\fields\ColourSwatches as ColourSwatchesField;
use percipiolondon\colourswatches\models\Settings;
use yii\base\Event;

/**
 * Class ColourSwatches.
 *
 * @author    Percipio Global Ltd.
 *
 * @since     1.0.0
 * @property Settings $settings
 *
 * @method Settings getSettings()
 */
class ColourSwatches extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var ColourSwatches
     */
    public static ColourSwatches $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public string $schemaVersion = '1.4.3';

    // Public Methods
    // =========================================================================

    /**
     * init
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = ColourSwatchesField::class;
            }
        );

        Craft::info(
            Craft::t(
                'colour-swatches',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    /**
     * @return Settings
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }
}
