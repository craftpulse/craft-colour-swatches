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

namespace percipiolondon\colourswatches\assetbundles\colourswatchesfield;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Percipio Global Ltd.
 *
 * @since     1.0.0
 */
class ColourSwatchesFieldAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        $this->sourcePath = '@percipiolondon/colourswatches/assetbundles/colourswatchesfield/dist';

        $this->depends = [
            CpAsset::class,
        ];

        $this->css = [
            'css/ColourSwatches.css',
        ];

        $this->js = [
            'js/ColourSwatches.js',
        ];

        parent::init();
    }
}
