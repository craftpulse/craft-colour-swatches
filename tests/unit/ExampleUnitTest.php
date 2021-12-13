<?php
/**
 * Colour Swatches plugin for Craft CMS 3.x
 *
 * This is a plugin to make repeating dates
 *
 * @link      https://percipio.london
 * @copyright Copyright (c) 2021 percipioglobal
 */

namespace percipioglobal\colourswatchestests\unit;

use Codeception\Test\Unit;
use UnitTester;
use Craft;
use percipioglobal\colourswatches\ColourSwatches;

/**
 * ExampleUnitTest
 *
 *
 * @author    percipioglobal
 * @package   Colour Swatches
 * @since     0.1.0
 */
class ExampleUnitTest extends Unit
{
    // Properties
    // =========================================================================

    /**
     * @var UnitTester
     */
    protected $tester;

    // Public methods
    // =========================================================================

    // Tests
    // =========================================================================

    /**
     *
     */
    public function testPluginInstance()
    {
        $this->assertInstanceOf(
            ColourSwatches::class,
            ColourSwatches::$plugin
        );
    }

    /**
     *
     */
    public function testCraftEdition()
    {
        Craft::$app->setEdition(Craft::Pro);

        $this->assertSame(
            Craft::Pro,
            Craft::$app->getEdition()
        );
    }
}
