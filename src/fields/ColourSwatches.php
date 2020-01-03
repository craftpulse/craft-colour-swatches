<?php
/**
 * colour-swatches plugin for Craft CMS 3.x.
 *
 * Let clients choose from a predefined set of colours.
 *
 * @link      https://rias.be
 *
 * @copyright Copyright (c) 2018 Rias
 */

namespace rias\colourswatches\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use rias\colourswatches\assetbundles\colourswatchesfield\ColourSwatchesFieldAsset;
use rias\colourswatches\ColourSwatches as Plugin;
use rias\colourswatches\models\ColourSwatches as ColourSwatchesModel;
use yii\db\Schema;

/**
 * @author    Rias
 *
 * @since     1.0.0
 */
class ColourSwatches extends Field
{
    // Public Properties
    // =========================================================================

    /**
     * Available options.
     *
     * @var array
     */
    public $options = [];

    /** @var bool */
    public $useConfigFile = false;

    /** @var string */
    public $palette = null;

    // Static Methods
    // =========================================================================

    /**
     * {@inheritdoc}
     */
    public static function displayName(): string
    {
        return Craft::t('colour-swatches', 'Colour Swatches');
    }

    // Public Methods
    // =========================================================================

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            ['options', 'each', 'rule' => ['required']],
        ]);

        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    /**
     * {@inheritdoc}
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        if ($value instanceof ColourSwatchesModel) {
            return $value;
        }

        return new ColourSwatchesModel($value);
    }

    /**
     * {@inheritdoc}
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        if ($value instanceof ColourSwatchesModel) {
            return $value;
        }

        return new ColourSwatchesModel($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getSettingsHtml()
    {
        Craft::$app->getView()->registerAssetBundle(ColourSwatchesFieldAsset::class);

        if ($this->options && count($this->options)) {
            $rows = $this->options;
        } elseif ($this->palette) {
            $rows = Plugin::$plugin->settings->palettes[$this->palette];
        } else {
            $rows = Plugin::$plugin->settings->colours;
        }

        $config = [
            'instructions' => Craft::t('colour-swatches', 'Define the available colors.'),
            'id'           => 'options',
            'name'         => 'options',
            'addRowLabel'  => Craft::t('colour-swatches', 'Add a colour'),
            'cols'         => [
                'label' => [
                    'heading' => Craft::t('colour-swatches', 'Label'),
                    'type'    => 'singleline',
                ],
                'color' => [
                    'heading' => Craft::t('colour-swatches', 'Hex Colours (comma seperated)'),
                    'type'    => 'singleline',
                ],
                'default' => [
                    'heading'      => Craft::t('colour-swatches', 'Default?'),
                    'type'         => 'checkbox',
                    'class'        => 'thin',
                ],
            ],
            'rows' => $rows,
        ];

        $paletteOptions = [];
        $paletteOptions[] = [
            'label' => null,
            'value' => null,
        ];
        foreach (array_keys((array) Plugin::$plugin->settings->palettes) as $palette) {
            $paletteOptions[] = [
                'label' => $palette,
                'value' => $palette,
            ];
        }

        $currentPalette = $this->palette;

        $paletteOptions = [];
        $paletteOptions[] = [
            'label' => 'Colour config',
            'value' => null,
        ];
        foreach (array_keys((array) Plugin::$plugin->settings->palettes) as $palette) {
            $paletteOptions[] = [
                'label' => $palette,
                'value' => $palette,
            ];
        }

        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'colour-swatches/settings',
            [
                'field'             => $this,
                'config'            => $config,
                'configOptions'     => Plugin::$plugin->settings->colours,
                'paletteOptions'    => $paletteOptions,
                'palettes'          => Plugin::$plugin->settings->palettes,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        // Register our asset bundle
        Craft::$app->getView()->registerAssetBundle(ColourSwatchesFieldAsset::class);

        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        Craft::$app->getView()->registerJs("new ColourSelectInput('{$namespacedId}');");

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'colour-swatches/input',
            [
                'name'         => $this->handle,
                'fieldValue'   => $value,
                'field'        => $this,
                'id'           => $id,
                'namespacedId' => $namespacedId,
                'configOptions'=> Plugin::$plugin->settings->colours,
                'palettes'     => Plugin::$plugin->settings->palettes,
            ]
        );
    }
}
