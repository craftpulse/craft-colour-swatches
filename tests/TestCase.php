<?php

namespace percipiolondon\colourswatches\tests;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * Base test case for unit tests.
 *
 * Registers Collection macros that are normally registered in plugin init().
 */
class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Register the recursive Collection macro (normally done in plugin init)
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
}
