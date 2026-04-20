<?php

use craft\helpers\StringHelper;

/**
 * Tests that handle generation is consistent between PHP and Twig.
 *
 * The PHP field class uses StringHelper::toCamelCase() in _generateHandle().
 * The Twig templates must use |camel (not |kebab) to match.
 * These tests verify the PHP side produces expected handles.
 */

// =========================================================================
// Handle generation consistency
// =========================================================================

it('generates camelCase handle from simple label', function () {
    expect(StringHelper::toCamelCase('Red'))->toBe('red');
});

it('generates camelCase handle from multi-word label', function () {
    expect(StringHelper::toCamelCase('Light Blue'))->toBe('lightBlue');
});

it('generates camelCase handle from label with slash', function () {
    expect(StringHelper::toCamelCase('Yellow/Emerald'))->toBe('yellowEmerald');
});

it('generates camelCase handle from label with special characters', function () {
    expect(StringHelper::toCamelCase('Red & Blue'))->toBe('redBlue');
});

it('generates consistent handle for config-file example labels', function () {
    // These match the example config.php handles
    expect(StringHelper::toCamelCase('Red'))->toBe('red')
        ->and(StringHelper::toCamelCase('Amber'))->toBe('amber')
        ->and(StringHelper::toCamelCase('Green'))->toBe('green')
        ->and(StringHelper::toCamelCase('Blue'))->toBe('blue')
        ->and(StringHelper::toCamelCase('Purple'))->toBe('purple')
        ->and(StringHelper::toCamelCase('Yellow/Emerald'))->toBe('yellowEmerald')
        ->and(StringHelper::toCamelCase('Red/Amber'))->toBe('redAmber')
        ->and(StringHelper::toCamelCase('Sky/Rose'))->toBe('skyRose');
});
