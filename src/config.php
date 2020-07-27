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
 * colour-swatches config.php.
 *
 * This file exists only as a template for the color-swatches settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'colour-swatches.php'
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
            'color'   => '#F56565',
            'class'   => 'red-500',     // custom attribute
            'default' => true,
        ],
        [
            'label'   => 'orange',
            'color'   => '#ED8936',
            'class'   => 'orange-500',  // custom attribute
            'default' => false,
        ],
        [
            'label'   => 'yellow',
            'color'   => '#ECC94B',
            'class'   => 'yellow-500',  // custom attribute
            'default' => false,
        ],
        [
            'label'   => 'green',
            'color'   => '#48BB78',
            'class'   => 'green-500',   // custom attribute
            'default' => false,
        ],
        [
            'label'   => 'teal',
            'color'   => '#38B2AC',
            'class'   => 'teal-500',    // custom attribute
            'default' => false,
        ],
        [
            'label'   => 'blue',
            'color'   => '#4299E1',
            'class'   => 'blue-500',    // custom attribute
            'default' => false,
        ],
        [
            'label'   => 'indigo',
            'color'   => '#667EEA',
            'class'   => 'indigo-500',   // custom attribute
            'default' => false,
        ],
        [
            'label'   => 'purple',
            'color'   => '#9F7AEA',
            'class'   => 'purple-500',   // custom attribute
            'default' => false,
        ],
        [
            'label'   => 'pink',
            'color'   => '#ED64A6',
            'class'   => 'pink-500',    // custom attribute
            'default' => false,
        ],
    ],

    'palettes' => [
        'Primary' => [  // custom label
            [
                'label'   => 'primary', // custom label
                'default' => false,
                'color'   =>  [
                    [
                        'color'     => '#38B2AC',  // the colour shown in the fieldtype (required)
                        'class'     => 'teal-500', // custom attribute
                        'btnClass' => 'blue-500', // custom attribute,
                    ],
                ]
            ],
            [
                'label'   => 'secondary', // custom label
                'default' => false,
                'color'   =>  [
                    [
                        'color'     => '#4299E1',   // the colour shown in the fieldtype (required)
                        'class'     => 'blue-500',  // custom attribute
                        'btnClass' => 'teal-500',  // custom attribute
                    ],
                ]
            ],
            [
                'label'   => 'terciary', // custom label
                'default' => false,
                'color'   =>  [
                    [
                        'color'     => '#ED64A6',   // the colour shown in the fieldtype (required)
                        'class'     => 'pink-500',  // custom attribute
                        'btnClass' => 'blue-500',  // custom attribute
                    ],
                ]
            ],
        ],
        'Gradients' => [
            [
                'label'   => 'primary', 
                'default' => false,
                'color'   =>  [
                    [
                        'color'     => '#38B2AC',   // the colour shown in the fieldtype (required)
                    ],
                    [
                        'color'     => '#434190',  // the next colour in this loop
                    ],
                ]
            ],
            [
                'label'   => 'secondary', // custom label
                'default' => false,
                'color'   =>  [
                    [
                        'color'     => '#434190',   // the colour shown in the fieldtype (required)
                    ],
                    [
                        'color'     => '#ED64A6',  // the next colour in this loop
                    ],
                ]
            ],
        ],
    ],
];
