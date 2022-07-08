<?php
/**
 * colour-swatches plugin for Craft CMS 3.x.
 *
 * Let clients choose from a predefined set of colours.
 *
 * @link      https://percipio.london
 *
 * @copyright Copyright (c) 2020 Percipio Global Ltd.
 */

namespace percipiolondon\colourswatches\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use craft\base\SortableFieldInterface;
use craft\gql\GqlEntityRegistry;
use craft\gql\TypeLoader;
use craft\helpers\Json;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

use Hoa\Protocol\Bin\Resolve;
use percipiolondon\colourswatches\assetbundles\colourswatchesfield\ColourSwatchesFieldAsset;
use percipiolondon\colourswatches\ColourSwatches as ColorSwatches;
use percipiolondon\colourswatches\models\ColourSwatches as ColourSwatchesModel;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\db\Schema;

/**
 * @author    Percipio Global Ltd.
 *
 * @since     1.0.0
 *
 * @property-read string|array $contentColumnType
 * @property-read Type|array $contentGqlType
 * @property-read null|string $settingsHtml
 */
class ColourSwatches extends Field implements PreviewableFieldInterface, SortableFieldInterface
{
    // Public Properties
    // =========================================================================

    /**
     * Available options.
     *
     * @var array
     */
    public array $options = [];

    /** @var bool */
    public bool $useConfigFile = false;

    /** @var string|null */
    public ?string $palette = null;

    /** @var int|string|null */
    public string|int|null $default = null;

    // Static Methods
    // =========================================================================


    /**
     * @return string
     */
    public static function displayName(): string
    {
        return Craft::t('colour-swatches', 'Color Swatches');
    }

    /**
     * @inheritdoc
     */
    public static function isRequirable(): bool
    {
        return true;
    }

    // Public Methods
    // =========================================================================


    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules();
        return array_merge($rules, [['options', 'each', 'rule' => ['required']], ]);
    }


    /**
     * @return array|string
     */
    public function getContentColumnType(): array|string
    {
        return Schema::TYPE_TEXT;
    }


    /**
     * @param mixed $value
     * @param ElementInterface|null $element
     * @return ColourSwatchesModel|null
     */
    public function normalizeValue(mixed $value, ?ElementInterface $element = null): ?ColourSwatchesModel
    {
        if ($value instanceof ColourSwatchesModel) {
            return $value;
        }

        // Check to see if this is already an array, which happens in some cases (Vizy)
        if (is_array($value)) {
            $value = Json::encode($value);
        }

        if (is_null($value) || $value === '') {
            return null;
        }

        return new ColourSwatchesModel($value);
    }


    /**
     * @param mixed $value
     * @param ElementInterface|null $element
     * @return mixed
     */
    public function serializeValue(mixed $value, ?ElementInterface $element = null): mixed
    {
        $settingsPalette = $this->options;
        $saveValue = null;

        // if useConfigFile is set, fetch the objects from that file
        if ($this->useConfigFile) {
            if (ColorSwatches::$plugin->settings->palettes[$this->palette] ?? false) {
                // if the palette with the value exists, return this as the settings palette
                $settingsPalette = ColorSwatches::$plugin->settings->palettes[$this->palette];
            } else {
                // if it doesn't exist, set it to the default colors
                $settingsPalette = ColorSwatches::$plugin->settings->colors ?: [];
            }
        }

        // loop through the colour arrays
        foreach ($settingsPalette as $palette) {

            //set the correct colour based on the label inside of the value
            if ($value && ($palette["label"] === $value['label'])) {
                $saveValue = $value;
                $saveValue['color'] = $palette['color'];
                $saveValue['class'] = $palette['class'] ?? '';
            }
        }

        // if nothing got set, use the default if that exists
        if (!$saveValue) {
            foreach ($settingsPalette as $key => $palette) {
                $paletteId = is_int($key) ? ($key + 1) : $key;

                if (is_array($palette) && $paletteId == $this->default) {
                    $saveValue = $palette;
                }
            }
        }

        return $saveValue;
    }


    /**
     * @return string|null
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function getSettingsHtml(): ?string
    {
        // Register our asset bundle
        Craft::$app->getView()
            ->registerAssetBundle(ColourSwatchesFieldAsset::class);

        $config = [
            'instructions' => Craft::t('colour-swatches', 'Define the available colors.'),
            'id' => 'options',
            'name' => 'options',
            'addRowLabel' => Craft::t('colour-swatches', 'Add a colour'),
            'cols' => [
                'label' => [
                    'heading' => Craft::t('colour-swatches', 'Label'),
                    'type' => 'singleline',
                ],
                'color' => [
                    'heading' => Craft::t('colour-swatches', 'Hex Colours (comma seperated)'),
                    'type' => 'singleline',
                ],
                'default' => [
                    'heading' => Craft::t('colour-swatches', 'Default?'),
                    'type' => 'checkbox', 'class' => 'thin',
                ],
                'class' => [
                    'heading' => Craft::t('colour-swatches', 'Css class to go with the palette'),
                    'type' => 'singleline',
                ],
            ],
            'rows' => $this->options,
            'allowAdd' => true,
            'allowReorder' => true,
            'allowDelete' => true,
        ];

        $paletteOptions = [];
        $paletteOptions[] = ['label' => 'Colors', 'value' => null, ];
        foreach (array_keys((array)ColorSwatches::$plugin
            ->settings
            ->palettes) as $palette) {
            $paletteOptions[] = ['label' => $palette, 'value' => $palette, ];
        }

        $paletteOptions = [];
        $paletteOptions[] = ['label' => 'Colour config', 'value' => null, ];
        foreach (array_keys((array)ColorSwatches::$plugin
            ->settings
            ->palettes) as $palette) {
            $paletteOptions[] = ['label' => $palette, 'value' => $palette, ];
        }

        // Render the settings template
        return Craft::$app->getView()
            ->renderTemplate('colour-swatches/settings',
                [
                    'field' => $this,
                    'config' => $config,
                    'configOptions' => ColorSwatches::$plugin->settings->colors ?: [],
                    'paletteOptions' => $paletteOptions,
                    'palettes' => ColorSwatches::$plugin->settings->palettes,
                ]
            );
    }


    /**
     * @param mixed $value
     * @param ElementInterface|null $element
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function getInputHtml(mixed $value, ?ElementInterface $element = null): string
    {
        // Register our asset bundle
        Craft::$app->getView()
            ->registerAssetBundle(ColourSwatchesFieldAsset::class);

        // Get our id and namespace
        $id = Craft::$app->getView()
            ->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()
            ->namespaceInputId($id);

        Craft::$app->getView()
            ->registerJs("new ColourSelectInput('{$namespacedId}');");

        // Render the input template
        return Craft::$app->getView()
            ->renderTemplate('colour-swatches/input',
            [
                'name' => $this->handle,
                'fieldValue' => $value,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
                'configOptions' => ColorSwatches::$plugin->settings->colors,
                'palettes' => ColorSwatches::$plugin->settings->palettes,
            ]
        );
    }

    /**
     * @return Type|array
     */
    public function getContentGqlType(): Type|array
    {
        $typeName = $this->handle;

        $swatchType = GqlEntityRegistry::getEntity($typeName) ?: GqlEntityRegistry::createEntity($typeName, new ObjectType([
            'name' => $typeName,
            'fields' => [
                'label' => [
                    'name' => 'label',
                    'type' => Type::string(),
                    'description' => 'The colour label'
                ],
                'class' => [
                    'name' => 'class',
                    'type' => Type::string(),
                    'description' => 'The parent class'
                ],
                'color' => [
                    'name' => 'color',
                    'type' => Type::listOf(Type::string()),
                    'description' => 'Our swatch colors',
                    'resolve' => function($source, array $arguments, $context, ResolveInfo $resolveInfo) {
                        $fieldName = $resolveInfo->fieldName;
                        $data = $source[$fieldName];
                        $colors = [];

                        foreach ($data as $color) {
                            $colors[] = Json::encode($color);
                        }

                        return $colors;
                    }
                ]
            ]
        ]));

        TypeLoader::registerType($typeName, static function() use ($swatchType) {
            return $swatchType;
        });

        return $swatchType;
    }


    /**
     * @param mixed $value
     * @param ElementInterface $element
     * @return string
     */
    public function getTableAttributeHtml(mixed $value, ElementInterface $element): string
    {
        $style = "background-color: transparent";
        // if we have data
        if (!empty($value)) {
            $fieldValue = get_object_vars($value);
            $gradients = array();
            // if we have a custom color config
            if (count($fieldValue) > 0) {
                // if we have more than one colour
                if (is_array($value->color)) {
                    foreach ($value->color as $color) {
                        $gradients[] = $color['color'];
                    }
                    // set a fallback if we only have one colour
                    $style = "background-color:$gradients[0]";
                    // else build the gradient
                    if (count($gradients) > 1) {
                        $gradients = implode(",", $gradients);
                        $style = "background: linear-gradient(to bottom right, $gradients);";
                    }
                    // if we're using the CP values
                } else {
                    $color = $value->color;
                    $style = "background-color:$color";
                }
            }
        }
        return '<div class="color small static"><div class="color-preview" style="' . $style . '"></div></div>';
    }
}
