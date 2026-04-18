<?php
/**
 * color-swatches plugin for Craft CMS 5.x.
 *
 * Let clients choose from a predefined set of colours.
 *
 * @link      https://craftpulse.com
 *
 * @copyright Copyright (c) 2024 CraftPulse.
 */

namespace percipiolondon\colourswatches;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use Illuminate\Support\Collection;
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

    /**
     * @var bool
     */
    public bool $hasCpSettings = true;

    // Public Methods
    // =========================================================================

    /**
     * init
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        $this->_registerCollectionMacros();

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

    // Protected Methods
    // =========================================================================

    /**
     * @return Settings
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate(
            'colour-swatches/_settings',
            ['settings' => $this->getSettings()]
        );
    }

    // Private Methods
    // =========================================================================

    /**
     * Register Collection macros used by the ColourSwatches model.
     *
     * @return void
     */
    private function _registerCollectionMacros(): void
    {
        if (!Collection::hasMacro('recursive')) {
            Collection::macro('recursive', function () {
                return $this->map(function ($value) {
                    if (is_array($value) || is_object($value)) {
                        return collect($value)->recursive();
                    }

                    return $value;
                });
            });
        }
    }
}
