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
use craft\web\twig\variables\CraftVariable;
use nystudio107\pluginvite\services\VitePluginService;
use percipiolondon\colourswatches\assetbundles\colourswatches\ColourSwatchesAsset;
use percipiolondon\colourswatches\fields\ColourSwatches as ColourSwatchesField;
use percipiolondon\colourswatches\models\Settings;
use percipiolondon\colourswatches\variables\ColourSwatchVariable;
use yii\base\Event;

/**
 * Class ColourSwatches.
 *
 * @author    Percipio Global Ltd.
 *
 * @since     1.0.0
 *
 * @property VitePluginService  $vite
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
     * ColourSwatches constructor.
     *
     * @param $id
     * @param null $parent
     * @param array $config
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        $config['components'] = [
            'colourswatches' => __CLASS__,
            'vite' => [
                'class' => VitePluginService::class,
                'assetClass' => ColourSwatchesAsset::class,
                'useDevServer' => true,
                'devServerPublic' => 'http://localhost:9000',
                'serverPublic' => 'http://localhost:3700',
                'errorEntry' => '/src/js/swatches.ts',
                'devServerInternal' => 'http://craft-colour-swatches-buildchain:9000',
                'checkDevServer' => true,
            ]
        ];

        parent::__construct($id, $parent, $config);
    }

    /**
     * init
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        // Register our fields
        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = ColourSwatchesField::class;
            }
        );

        // Register variable
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event): void {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('colourswatches', [
                    'class' => ColourSwatchVariable::class,
                    'viteService' => $this->vite,
                ]);
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
