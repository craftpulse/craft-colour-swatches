<?php
/**
 * colour-swatches plugin for Craft CMS 5.x.
 *
 * Let clients choose from a predefined set of colours.
 *
 * @link      https://craft-pulse.com
 *
 * @copyright Copyright (c) 2024 CraftPulse.
 */

namespace percipiolondon\colourswatches\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use craft\base\SortableFieldInterface;
use craft\gql\GqlEntityRegistry;
use craft\gql\TypeLoader;
use craft\helpers\Cp;
use craft\helpers\Html;
use craft\helpers\Json;

use craft\helpers\StringHelper;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

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
 * @author    CraftPulse
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

    /** @var bool */
    public bool $setRandom = false;

    /** @var int|string|null */
    public string|int|null $default = null;

    /**
     * Whether the GraphQL type should return full swatch data (label, color, class, handle)
     * or just the label string.
     *
     * @var bool
     * @since 5.2.0
     */
    public bool $fullGraphqlData = true;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        // Convert graphqlMode select value to boolean property
        if (isset($config['graphqlMode'])) {
            $config['fullGraphqlData'] = $config['graphqlMode'] === 'full';
            unset($config['graphqlMode']);
        }

        parent::__construct($config);
    }

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
    public static function icon(): string
    {
        return Craft::getAlias('@percipiolondon/colourswatches/icon-field.svg');
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
            $resolvedOptions = $this->_resolveOptions();

            // if default is set --> return default
            $default = array_filter($resolvedOptions, function($option) {
                return !empty($option['default']);
            });

            if (count($default) > 0) {
                return new ColourSwatchesModel(Json::encode(array_values($default)[0]));
            }

            // if no default is set --> return null
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
        // Craft normalizes before serializing, so the value is usually a model.
        // Convert it to an array and run it through the option matching below,
        // so settings-defined class/color/default enrich the stored value (the
        // CP input only posts label, color, and handle).
        $fromModel = false;

        if ($value instanceof ColourSwatchesModel) {
            $value = [
                'handle' => $value->handle,
                'label' => $value->label,
                'color' => $value->color,
                'class' => $value->class,
                'default' => $value->default,
            ];
            $fromModel = true;
        }

        $resolvedOptions = $this->_resolveOptions();
        $saveValue = null;

        foreach ($resolvedOptions as $palette) {
            $matched = false;

            // get or generate handle
            $paletteHandle = $palette['handle'] ?? $this->_generateHandle($palette['label']);

            // if handle is already saved, match by handle
            if ($value && !empty($value['handle'])) {
                if ($paletteHandle === $value['handle']) {
                    $matched = true;
                }
            } elseif ($value && ($palette['label'] === $value['label'])) {
                // fallback - match by label (backwards compatibility)
                $matched = true;
            }

            if ($matched) {
                $saveValue = [];

                // if config has explicit set handle --> use it
                // if saved value has handle --> preserve it
                // generate new handle if non-existent
                if (!empty($palette['handle'])) {
                    $saveValue['handle'] = $palette['handle'];
                } elseif (!empty($value['handle'])) {
                    $saveValue['handle'] = $value['handle'];
                } else {
                    $saveValue['handle'] = $this->_generateHandle($palette['label']);
                }

                $saveValue['label'] = $palette['label'];
                $saveValue['color'] = $palette['color'];
                $saveValue['class'] = $palette['class'];
                $saveValue['default'] = $palette['default'] ?? false;
            }
        }

        // preserve model values that no longer match any option (e.g. the
        // option was removed from the config) instead of swapping to default
        if (!$saveValue && $fromModel && !empty($value['label'])) {
            return $value;
        }

        // if nothing got set, use the default if that exists
        if (!$saveValue) {
            $defaultLabel = $this->default;

            if (is_null($defaultLabel)) {
                $default = array_filter($resolvedOptions, function($option) {
                    return !empty($option['default']);
                });

                if (count($default) > 0) {
                    $defaultLabel = array_values($default)[0]['label'];
                }
            }

            foreach ($resolvedOptions as $palette) {
                if (is_array($palette) && $palette['label'] === $defaultLabel) {
                    $saveValue = $palette;
                    $saveValue['handle'] = $palette['handle'] ?? $this->_generateHandle($palette['label']);
                }
            }
        }

        // if no default is defined and random is set, pick a random colour
        if (!$saveValue && $this->setRandom) {
            $random = array_rand($resolvedOptions, 1);
            $saveValue = $resolvedOptions[$random];
            $saveValue['handle'] = $resolvedOptions[$random]['handle'] ?? $this->_generateHandle($saveValue['label']);
        }

        return $saveValue;
    }

    // Protected Methods
    // =========================================================================

    /**
     * Returns the search keywords for this field's value, so entries can be
     * found by swatch label, handle, CSS class, or colour value.
     *
     * @param mixed $value
     * @param ElementInterface $element
     * @return string
     *
     * @author CraftPulse
     * @since 5.2.0
     */
    protected function searchKeywords(mixed $value, ElementInterface $element): string
    {
        if (!$value instanceof ColourSwatchesModel) {
            return '';
        }

        $keywords = [$value->label, $value->handle, $value->class];

        if (is_string($value->color)) {
            $keywords[] = $value->color;
        } elseif (is_array($value->color)) {
            foreach ($value->color as $color) {
                if (is_array($color)) {
                    $keywords[] = $color['color'] ?? null;
                } elseif (is_string($color)) {
                    $keywords[] = $color;
                }
            }
        }

        return implode(' ', array_filter($keywords));
    }

    // Private Methods
    // =========================================================================

    /**
     * Resolve the effective options for this field, using config file palettes
     * when configured or falling back to inline options.
     *
     * @return array
     */
    private function _resolveOptions(): array
    {
        if ($this->useConfigFile) {
            $settings = ColorSwatches::$plugin->settings;

            if ($settings->palettes[$this->palette] ?? false) {
                return $settings->palettes[$this->palette];
            }

            return $settings->colors ?: [];
        }

        return $this->options;
    }

    /**
     * Generate a stable handle from a label.
     * Handles are never exposed to users but allow for label changes.
     *
     * @param string $label
     * @return string
     */
    private function _generateHandle(string $label): string
    {
        return StringHelper::toCamelCase($label);
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
            'addRowLabel' => Craft::t('colour-swatches', 'Add a color'),
            'cols' => [
                'label' => [
                    'heading' => Craft::t('colour-swatches', 'Label'),
                    'type' => 'singleline',
                ],
                'color' => [
                    'heading' => Craft::t('colour-swatches', 'Hex Colors (comma seperated)'),
                    'type' => 'singleline',
                ],
                'default' => [
                    'heading' => Craft::t('colour-swatches', 'Default?'),
                    'type' => 'checkbox', 'class' => 'thin',
                ],
                'class' => [
                    'heading' => Craft::t('colour-swatches', 'CSS class to go with the palette'),
                    'type' => 'singleline',
                ],
            ],
            'rows' => $this->options,
            'allowAdd' => true,
            'allowReorder' => true,
            'allowDelete' => true,
        ];

        $paletteOptions = [];
        $paletteOptions[] = ['label' => 'Colour config', 'value' => null, ];
        foreach (array_keys(ColorSwatches::$plugin
            ->settings
            ->palettes) as $palette) {
            $paletteOptions[] = ['label' => $palette, 'value' => $palette, ];
        }

        // Render the settings template
        $html = Craft::$app->getView()
            ->renderTemplate('colour-swatches/settings',
                [
                    'field' => $this,
                    'config' => $config,
                    'configOptions' => ColorSwatches::$plugin->settings->colors ?: [],
                    'paletteOptions' => $paletteOptions,
                    'palettes' => ColorSwatches::$plugin->settings->palettes,
                ]
            );

        if (Craft::$app->getConfig()->getGeneral()->enableGql) {
            $html .= Html::tag('hr') .
                Cp::selectFieldHtml([
                    'label' => Craft::t('colour-swatches', 'GraphQL Mode'),
                    'id' => 'graphql-mode',
                    'name' => 'graphqlMode',
                    'instructions' => Craft::t('colour-swatches', 'Controls whether GraphQL returns just the label string or the full swatch data object.'),
                    'options' => [
                        ['label' => Craft::t('colour-swatches', 'Full data'), 'value' => 'full'],
                        ['label' => Craft::t('colour-swatches', 'Label only'), 'value' => 'label'],
                    ],
                    'value' => $this->fullGraphqlData ? 'full' : 'label',
                ]);
        }

        return $html;
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
        $id = Html::id($this->handle);
        $namespacedId = Craft::$app->getView()
            ->namespaceInputId($id);

        Craft::$app->getView()
            ->registerJs("new ColourSelectInput(" . Json::encode($namespacedId) . ");");

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
     * @inheritdoc
     */
    public function getContentGqlType(): Type|array
    {
        if (!$this->fullGraphqlData) {
            return parent::getContentGqlType();
        }

        $typeName = 'ColourSwatches_SwatchData';

        $swatchType = GqlEntityRegistry::getEntity($typeName) ?: GqlEntityRegistry::createEntity($typeName, new ObjectType([
            'name' => $typeName,
            'fields' => [
                'label' => [
                    'name' => 'label',
                    'type' => Type::string(),
                    'description' => 'The colour label',
                ],
                'handle' => [
                    'name' => 'handle',
                    'type' => Type::string(),
                    'description' => 'The stable colour handle',
                ],
                'class' => [
                    'name' => 'class',
                    'type' => Type::string(),
                    'description' => 'The CSS class',
                ],
                'color' => [
                    'name' => 'color',
                    'type' => Type::listOf(Type::string()),
                    'description' => 'The swatch colour values',
                    'resolve' => function($source, array $arguments, $context, ResolveInfo $resolveInfo) {
                        $fieldName = $resolveInfo->fieldName;
                        $data = $source[$fieldName];

                        if (is_iterable($data)) {
                            $colors = [];
                            foreach ($data as $color) {
                                // Config-file colours are objects with a 'color' key
                                $colors[] = is_array($color) ? ($color['color'] ?? '') : (string)$color;
                            }
                            return $colors;
                        }

                        // Single colour string — may be comma-separated
                        return is_string($data) ? explode(',', $data) : [$data];
                    },
                ],
            ],
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
    public function getPreviewHtml(mixed $value, ElementInterface $element): string
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
                    $style = str_contains($color, ',') ? "background: linear-gradient(to bottom right, $color);" : "background-color:$color";
                }
            }
        }
        return '<div class="color small static"><div class="color-preview" style="' . Html::encode($style) . '"></div></div>';
    }
}
