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

namespace percipioglobal\colourswatches;

use percipioglobal\colourswatches\elements\ColourSwatches as ColourSwatchesElement;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use craft\services\Plugins;
use percipioglobal\colourswatches\fields\ColourSwatches as ColourSwatchesField;
use percipioglobal\colourswatches\models\Settings;
// console commands
use craft\events\DefineConsoleActionsEvent;
use craft\console\Controller;
use craft\console\controllers\ResaveController;


use yii\base\Event;



/**
 * Class Colorswatches.
 *
 * @author    Percipio Global Ltd.
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

        $this->_registerResaveCommand();
    }

    protected function createSettingsModel()
    {
        return new Settings();
    }

    private function _registerResaveCommand()
    {

        Event::on(ResaveController::class,
            Controller::EVENT_DEFINE_ACTIONS, function(DefineConsoleActionsEvent $event) {
            $event->actions['colour-swatches'] = [
                'action' => function(): int {
                    $controller = Craft::$app->controller;
                    $query = ColourSwatchesElement::find();
                    return $controller->saveElements($query);
                },
                'options' => [],
                'helpSummary' => 'Re-saves colour swatches.',
            ];
        });
    }

}
