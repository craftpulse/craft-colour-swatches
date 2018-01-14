<?php
/**
 * colour-swatches plugin for Craft CMS 3.x
 *
 * Let clients choose from a predefined set of colours.
 *
 * @link      https://rias.be
 * @copyright Copyright (c) 2018 Rias
 */

namespace rias\colourswatches\fields;

use craft\validators\ArrayValidator;
use rias\colourswatches\assetbundles\colourswatchesfield\ColourSwatchesFieldAsset;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    Rias
 * @package   Colour Swatches
 * @since     1.0.0
 */
class ColourSwatches extends Field
{
    // Public Properties
    // =========================================================================

    /**
     * Available options
     *
     * @var string
     */
    public $options = [['color' => '']];

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('colour-swatches', 'Colour Swatches');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        return new \rias\colourswatches\models\ColourSwatches($value);
    }

    /**
     * @inheritdoc
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        return parent::serializeValue($value, $element);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        $config = [
            'instructions' => Craft::t('colour-swatches', 'Define the available colors.'),
            'id'           => 'options',
            'name'         => 'options',
            'addRowLabel'  => Craft::t('colour-swatches', 'Add a color'),
            'cols'         => [
                'label' => [
                    'heading' => Craft::t('colour-swatches', 'Label'),
                    'type' => 'singleline'
                ],
                'color' => [
                    'heading' => Craft::t('colour-swatches', 'Hex Colours (comma seperated)'),
                    'type' => 'singleline'
                ],
                'default' => [
                    'heading'      => Craft::t('colour-swatches', 'Default?'),
                    'type'         => 'checkbox',
                    'class'        => 'thin'
                ],
            ],
            'rows' => $this->options
        ];

        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'colour-swatches/settings',
            [
                'field' => $this,
                'config' => $config,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        // Register our asset bundle
        Craft::$app->getView()->registerAssetBundle(ColourSwatchesFieldAsset::class);

        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'colour-swatches/input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
            ]
        );
    }
}
