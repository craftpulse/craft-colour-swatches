<?php
/**
 * color-swatches plugin for Craft CMS 4.x.
 *
 * Let clients choose from a predefined set of colours.
 *
 * @link      https://percipio.london
 *
 * @copyright Copyright (c) 2020 Percipio Global Ltd.
 */

namespace percipiolondon\colourswatches\assetbundles\colourswatchesfield;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 *
 * @author    percipiolondon
 * @package   Colour Swatches
 * @since     1.0.0
 */
class ColourSwatchesAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * Initializes the bundle.
     */
    public function init(): void
    {
        $this->sourcePath = '@percipiolondon/colourswatches/assetbundles/colourswatchesfield/dist';

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        parent::init();
    }
}
