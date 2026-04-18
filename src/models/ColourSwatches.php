<?php

namespace percipiolondon\colourswatches\models;

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
     * @return Collection
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
