<?php
/**
 * color-swatches plugin for Craft CMS 3.x.
 *
 * Let clients choose from a predefined set of colours.
 *
 * @link      https://rias.be
 *
 * @copyright Copyright (c) 2018 Rias
 */

namespace rias\colourswatches\assetbundles\colourswatchesfield;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Rias
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
    public function init()
    {
        $this->sourcePath = '@rias/colourswatches/assetbundles/colourswatchesfield/dist';

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
