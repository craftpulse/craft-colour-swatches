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

it('preserves special characters in handle (slash, ampersand)', function () {
    // toCamelCase only splits on whitespace/hyphens/underscores, NOT on
    // slashes or ampersands. Labels with special characters should use
    // explicit handle keys in config to get clean handles.
    expect(StringHelper::toCamelCase('Yellow/Emerald'))->toBe('yellow/Emerald')
        ->and(StringHelper::toCamelCase('Red & Blue'))->toBe('red&Blue');
});

it('generates consistent handle for simple config-file labels', function () {
    expect(StringHelper::toCamelCase('Red'))->toBe('red')
        ->and(StringHelper::toCamelCase('Amber'))->toBe('amber')
        ->and(StringHelper::toCamelCase('Green'))->toBe('green')
        ->and(StringHelper::toCamelCase('Blue'))->toBe('blue')
        ->and(StringHelper::toCamelCase('Purple'))->toBe('purple');
});

it('requires explicit handles for labels with special characters', function () {
    // The config.php example uses explicit handles for these:
    // 'Yellow/Emerald' => 'yellowEmerald', 'Red/Amber' => 'redAmber'
    // Auto-generation would produce 'yellow/Emerald', 'red/Amber' instead
    expect(StringHelper::toCamelCase('Yellow/Emerald'))->not->toBe('yellowEmerald')
        ->and(StringHelper::toCamelCase('Red/Amber'))->not->toBe('redAmber');
});
