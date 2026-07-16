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
 * @property Settings $settings
 *
 * @method Settings getSettings()
 *
 * @author CraftPulse
 * @since 1.0.0
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
    public string $schemaVersion = '1.5.0';

    /**
     * @var bool
     */
    public bool $hasCpSettings = true;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        $this->_registerCollectionMacros();

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            static function(RegisterComponentTypesEvent $event) {
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
     * @inheritdoc
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
                /** @var Collection $this */
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
