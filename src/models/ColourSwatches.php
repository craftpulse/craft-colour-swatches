<?php

namespace percipiolondon\colourswatches\models;

use Craft;
use craft\base\Model;
use craft\helpers\Json;
use Illuminate\Support\Collection;

/**
 * Class ColourSwatches
 *
 * @package percipiolondon\colourswatches\models
 */
class ColourSwatches extends Model
{
    /**
     * @var string|null Silent stable identifier
     * @since 5.2.0
     */
    public ?string $handle = null;

    /**
     * @var string
     */
    public string $label = '';

    /**
     * @var array|string|null
     */
    public array|string|null $color = null;

    /**
     * @var bool|null
     */
    public bool|null $default = false;

    /**
     * @var string
     */
    public string|null $class = '';


    /**
     * ColourSwatches constructor.
     *
     * @param string|null $value
     */
    public function __construct(?string $value = null)
    {
        parent::__construct();

        if ($this->validateJson($value)) {
            $colorData = Json::decode($value);

            if (!empty($colorData['label'])) {
                $this->handle = $colorData['handle'] ?? null;
                $this->label = $colorData['label'];
                $this->color = $colorData['color'];
                $this->default = filter_var($colorData['default'] ?? false, FILTER_VALIDATE_BOOLEAN);
                $this->class = $colorData['class'] ?? '';
            }
        }

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

    /**
     * @param string|null $value
     * @return bool
     */
    public function validateJson(?string $value): bool
    {
        if (Json::isJsonObject($value)) {
            $json = Json::decode($value);
            return $json && $value != $json;
        }

        return false;
    }

    /**
     * @return Collection|null
     */
    public function collection(): ?Collection
    {
        if ($this) {
            return collect($this['color'])->recursive();
        }

        return null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function colors(): mixed
    {
        return $this->color;
    }

    /**
     * @return mixed
     */
    public function labels(): mixed
    {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function default(): mixed
    {
        return $this->default;
    }

    /**
     * @return mixed
     */
    public function class(): mixed
    {
        return $this->class;
    }
}
