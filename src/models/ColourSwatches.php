<?php
/**
 * colour-swatches plugin for Craft CMS 5.x.
 *
 * Let clients choose from a predefined set of colours.
 *
 * @link      https://craftpulse.com
 *
 * @copyright Copyright (c) 2024 CraftPulse.
 */

namespace percipiolondon\colourswatches\models;

use craft\base\Model;
use craft\helpers\Json;
use Illuminate\Support\Collection;

/**
 * Colour swatch field value model.
 *
 * @author CraftPulse
 * @since 1.0.0
 */
class ColourSwatches extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string|null Silent stable identifier
     * @since 5.3.0
     */
    public ?string $handle = null;

    /**
     * @var string The human-readable swatch label
     */
    public string $label = '';

    /**
     * @var array|string|null The colour value(s), either a single CSS colour string or an array of colour definitions
     */
    public array|string|null $color = null;

    /**
     * @var bool|null Whether this swatch is the field default
     */
    public ?bool $default = false;

    /**
     * @var string|null Extra CSS class(es) associated with this swatch
     */
    public ?string $class = '';

    // Public Methods
    // =========================================================================

    /**
     * ColourSwatches constructor.
     *
     * @param string|null $value
     */
    public function __construct(?string $value = null)
    {
        parent::__construct();

        if ($value !== null && Json::isJsonObject($value)) {
            $colorData = Json::decode($value);

            if (!empty($colorData['label'])) {
                $this->handle = $colorData['handle'] ?? null;
                $this->label = $colorData['label'];
                $this->color = $colorData['color'];
                $this->default = filter_var($colorData['default'] ?? false, FILTER_VALIDATE_BOOLEAN);
                $this->class = $colorData['class'] ?? '';
            }
        }
    }

    /**
     * Returns the colour value(s) as a recursive Collection.
     *
     * @return Collection
     *
     * @author CraftPulse
     * @since 5.1.0
     */
    public function collection(): Collection
    {
        return collect($this->color ?? [])->recursive();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->label;
    }

    /**
     * Returns the colour value(s).
     *
     * @return array|string|null
     * @deprecated in 5.3.0. Access the `$color` property directly instead. Will be removed in 6.0.0.
     */
    public function colors(): mixed
    {
        return $this->color;
    }

    /**
     * Returns the swatch label.
     *
     * @return string
     * @deprecated in 5.3.0. Access the `$label` property directly instead. Will be removed in 6.0.0.
     */
    public function labels(): mixed
    {
        return $this->label;
    }

    /**
     * Returns whether this swatch is the field default.
     *
     * @return bool|null
     * @deprecated in 5.3.0. Access the `$default` property directly instead. Will be removed in 6.0.0.
     */
    public function default(): mixed
    {
        return $this->default;
    }

    /**
     * Returns the CSS class(es) associated with this swatch.
     *
     * @return string|null
     * @deprecated in 5.3.0. Access the `$class` property directly instead. Will be removed in 6.0.0.
     */
    public function class(): mixed
    {
        return $this->class;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function defineRules(): array
    {
        return array_merge(parent::defineRules(), [
            [['label', 'handle', 'class'], 'string'],
            [['default'], 'boolean'],
            [['color'], 'safe'],
        ]);
    }
}
