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

/**
 * color-swatches config.php.
 *
 * This file exists only as a template for the color-swatches settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'color-swatches.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [

    // Predefined colours
    'colours' => [
        [
            'label'   => 'red',
            'color'   => '#ff0000',
            'default' => false,
        ],
        [
            'label'   => 'green',
            'color'   => '#00ff00',
            'default' => false,
        ],
        [
            'label'   => 'blue',
            'color'   => '#0000ff',
            'default' => false,
        ],
        [
            'label'   => 'pink',
            'color'   => '#ff00ff',
            'default' => false,
        ],
    ],

    'palettes' => [
        'Red Green' => [
            [
                'label'   => 'red',
                'color'   => '#ff0000',
                'default' => false,
            ],
            [
                'label'   => 'green',
                'color'   => '#00ff00',
                'default' => false,
            ],
        ],
        'Buttons' => [
            [
                'label'   => 'blue-white',
                'color'   => '#0000ff,#ffffff',
                'default' => false,
            ],
            [
                'label'   => 'red-white',
                'color'   => '#ff0000, #ffffff',
                'default' => false,
            ],
        ],
    ],
];
