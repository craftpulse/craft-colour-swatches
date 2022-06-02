<?php
/**
 * color-swatches plugin for Craft CMS 3.x.
 *
 * Let clients choose from a predefined set of colours.
 *
 * @link      https://percipio.london
 *
 * @copyright Copyright (c) 2020 Percipio.London
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

    // Custom  palettes, fixed options [label, default (boolean), class (string), colour (array(colour, customOptions)) ]
    'palettes' => [
        'Tailwind' => [  // custom label
            [
                'label' => 'Red',
                'default' => false,
                'class' => null, // provide extra classes to go along with this palette
                'color' => [
                    [
                        'color' => '#ef4444',               // the colour shown in the fieldtype (required)
                        'background' => 'bg-red-500',
                        'backgroundHover' => 'hover:bg-red-700',
                        'text' => 'text-white',
                        'textHover' => 'hover:text-zinc-200',
                    ],
                ],
            ],
            [
                'label' => 'Amber',
                'default' => false,
                'class' => null, // provide extra classes to go along with this palette
                'color' => [
                    [
                        'color' => '#f59e0b',               // the colour shown in the fieldtype (required)
                        'background' => 'bg-amber-500',
                        'backgroundHover' => 'hover:bg-amber-700',
                        'text' => 'text-white',
                        'textHover' => 'hover:text-zinc-200',
                    ],
                ],
            ],
            [
                'label' => 'Green',
                'default' => false,
                'class' => null, // provide extra classes to go along with this palette
                'color' => [
                    [
                        'color' => '#22c55e',               // the colour shown in the fieldtype (required)
                        'background' => 'bg-green-500',
                        'backgroundHover' => 'hover:bg-green-700',
                        'text' => 'text-white',
                        'textHover' => 'hover:text-zinc-200',
                    ],
                ],
            ],
            [
                'label' => 'Blue',
                'default' => false,
                'class' => null, // provide extra classes to go along with this palette
                'color' => [
                    [
                        'color' => '#3b82f6',               // the colour shown in the fieldtype (required)
                        'background' => 'bg-blue-500',
                        'backgroundHover' => 'hover:bg-blue-700',
                        'text' => 'text-white',
                        'textHover' => 'hover:text-zinc-200',
                    ],
                ],
            ],
            [
                'label' => 'Purple',
                'default' => false,
                'class' => null, // provide extra classes to go along with this palette
                'color' => [
                    [
                        'color' => '#a855f7',               // the colour shown in the fieldtype (required)
                        'background' => 'bg-purple-500',
                        'backgroundHover' => 'hover:bg-purple-700',
                        'text' => 'text-white',
                        'textHover' => 'hover:text-zinc-200',
                    ],
                ],
            ],
            [
                'label' => 'Yellow/Emerald',
                'default' => false,
                'class' => null, // provide extra classes to go along with this palette
                'color' => [
                    [
                        'color' => '#eab308',               // the colour shown in the fieldtype (required)
                        'background' => 'bg-yellow-500',
                        'backgroundHover' => 'hover:bg-yellow-700',
                        'text' => 'text-white',
                        'textHover' => 'hover:text-zinc-200',
                    ],
                    [
                        'color' => '#059669',               // the colour shown in the fieldtype (required)
                        'background' => 'bg-emerald-600',
                        'backgroundHover' => 'hover:bg-emerald-800',
                        'text' => 'text-white',
                        'textHover' => 'hover:text-zinc-200',
                    ],
                ],
            ],
            [
                'label' => 'Red/Amber',
                'default' => false,
                'class' => null, // provide extra classes to go along with this palette
                'color' => [
                    [
                        'color' => '#a855f7',               // the colour shown in the fieldtype (required)
                        'background' => 'bg-red-500',
                        'backgroundHover' => 'hover:bg-red-700',
                        'text' => 'text-white',
                        'textHover' => 'hover:text-zinc-200',
                    ],
                    [
                        'color' => '#f59e0b',               // the colour shown in the fieldtype (required)
                        'background' => 'bg-amber-500',
                        'backgroundHover' => 'hover:bg-amber-700',
                        'text' => 'text-white',
                        'textHover' => 'hover:text-zinc-200',
                    ],
                ],
            ],
            [
                'label' => 'Sky/Rose',
                'default' => false,
                'class' => null, // provide extra classes to go along with this palette
                'color' => [
                    [
                        'color' => '#0ea5e9',               // the colour shown in the fieldtype (required)
                        'background' => 'bg-sky-500',
                        'backgroundHover' => 'hover:bg-sky-700',
                        'text' => 'text-white',
                        'textHover' => 'hover:text-zinc-200',
                    ],
                    [
                        'color' => '#e11d48',               // the colour shown in the fieldtype (required)
                        'background' => 'bg-rose-600',
                        'backgroundHover' => 'hover:bg-rose-800',
                        'text' => 'text-white',
                        'textHover' => 'hover:text-zinc-200',
                    ],
                ],
            ],
        ],
    ],

];
