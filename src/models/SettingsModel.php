<?php
/**
 * Color Swatches plugin for Craft CMS 3.x
 *
 * This is a plugin to create color palettes
 *
 * @link      https://percipio.london
 * @copyright Copyright (c) 2021 percipioglobal
 */

namespace percipioglobal\colourswatches\models;

use craft\base\Model;

/**
 * Color Swatches Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    percipioglobal
 * @package   Color Swatches
 * @since     1.0.0
 */
class SettingsModel extends Model
{
    // Public Properties
    // =========================================================================
    public $colors = [];
    public $palettes = [];
    public $default = 0;

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['colors', 'array'],
            ['palettes', 'array'],
            ['default', 'int'],
        ];
    }
}
