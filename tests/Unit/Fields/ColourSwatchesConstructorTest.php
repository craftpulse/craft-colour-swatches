<?php

use percipiolondon\colourswatches\fields\ColourSwatches;

// =========================================================================
// graphqlMode -> fullGraphqlData conversion
// =========================================================================

it('converts graphqlMode "full" to fullGraphqlData true', function () {
    $field = new ColourSwatches(['graphqlMode' => 'full']);

    expect($field->fullGraphqlData)->toBeTrue();
});

it('converts graphqlMode "label" to fullGraphqlData false', function () {
    $field = new ColourSwatches(['graphqlMode' => 'label']);

    expect($field->fullGraphqlData)->toBeFalse();
});

it('defaults fullGraphqlData to true when not set', function () {
    $field = new ColourSwatches();

    expect($field->fullGraphqlData)->toBeTrue();
});

it('respects explicit fullGraphqlData config', function () {
    $field = new ColourSwatches(['fullGraphqlData' => false]);

    expect($field->fullGraphqlData)->toBeFalse();
});

// =========================================================================
// serializeValue with ColourSwatchesModel
// =========================================================================

it('serializes a ColourSwatchesModel to array', function () {
    $model = new \percipiolondon\colourswatches\models\ColourSwatches(
        \craft\helpers\Json::encode([
            'handle' => 'red',
            'label' => 'Red',
            'color' => '#ef4444',
            'class' => 'bg-red-500',
            'default' => true,
        ])
    );

    $field = new ColourSwatches();
    $result = $field->serializeValue($model);

    expect($result)->toBeArray()
        ->and($result['handle'])->toBe('red')
        ->and($result['label'])->toBe('Red')
        ->and($result['color'])->toBe('#ef4444')
        ->and($result['class'])->toBe('bg-red-500')
        ->and($result['default'])->toBeTrue();
});

// =========================================================================
// serializeValue does NOT mutate field state (H-1 fix)
// =========================================================================

it('does not mutate $options during serialization', function () {
    $options = [
        ['label' => 'Red', 'color' => '#f00', 'class' => '', 'default' => false, 'handle' => 'red'],
        ['label' => 'Blue', 'color' => '#00f', 'class' => '', 'default' => true, 'handle' => 'blue'],
    ];

    $field = new ColourSwatches();
    $field->options = $options;

    $value = ['label' => 'Red', 'handle' => 'red'];
    $field->serializeValue($value);

    // options should remain unchanged after serialization
    expect($field->options)->toBe($options);
});

it('does not mutate $default during serialization', function () {
    $field = new ColourSwatches();
    $field->options = [
        ['label' => 'Red', 'color' => '#f00', 'class' => '', 'default' => true, 'handle' => 'red'],
    ];
    $field->default = null;

    // Serialize with an unmatched value to trigger default resolution
    $field->serializeValue(['label' => 'NonExistent', 'handle' => 'nonExistent']);

    // $default should remain null — not mutated to 'Red'
    expect($field->default)->toBeNull();
});

// =========================================================================
// serializeValue handle matching
// =========================================================================

it('matches by handle first (preferred)', function () {
    $field = new ColourSwatches();
    $field->options = [
        ['label' => 'Old Label', 'color' => '#f00', 'class' => 'text-red', 'default' => false, 'handle' => 'red'],
    ];

    $value = ['label' => 'Different Label', 'handle' => 'red'];
    $result = $field->serializeValue($value);

    // Should match by handle even though labels differ (label rename scenario)
    expect($result['handle'])->toBe('red')
        ->and($result['label'])->toBe('Old Label')
        ->and($result['color'])->toBe('#f00');
});

it('falls back to label matching when no handle', function () {
    $field = new ColourSwatches();
    $field->options = [
        ['label' => 'Red', 'color' => '#f00', 'class' => '', 'default' => false],
    ];

    $value = ['label' => 'Red'];
    $result = $field->serializeValue($value);

    expect($result['label'])->toBe('Red')
        ->and($result['color'])->toBe('#f00');
});

it('generates handle when neither config nor value has one', function () {
    $field = new ColourSwatches();
    $field->options = [
        ['label' => 'Light Blue', 'color' => '#93c5fd', 'class' => '', 'default' => false],
    ];

    $value = ['label' => 'Light Blue'];
    $result = $field->serializeValue($value);

    // StringHelper::toCamelCase('Light Blue') = 'lightBlue'
    expect($result['handle'])->toBe('lightBlue');
});

it('prefers config handle over generated handle', function () {
    $field = new ColourSwatches();
    $field->options = [
        ['label' => 'Red', 'color' => '#f00', 'class' => '', 'default' => false, 'handle' => 'brandRed'],
    ];

    $value = ['label' => 'Red', 'handle' => 'brandRed'];
    $result = $field->serializeValue($value);

    expect($result['handle'])->toBe('brandRed');
});

// =========================================================================
// serializeValue default resolution
// =========================================================================

it('uses default option when no match found', function () {
    $field = new ColourSwatches();
    $field->options = [
        ['label' => 'Red', 'color' => '#f00', 'class' => '', 'default' => true, 'handle' => 'red'],
        ['label' => 'Blue', 'color' => '#00f', 'class' => '', 'default' => false, 'handle' => 'blue'],
    ];

    $result = $field->serializeValue(['label' => 'NonExistent', 'handle' => 'nonExistent']);

    expect($result['label'])->toBe('Red')
        ->and($result['handle'])->toBe('red');
});

it('returns null when no match and no default', function () {
    $field = new ColourSwatches();
    $field->options = [
        ['label' => 'Red', 'color' => '#f00', 'class' => '', 'default' => false, 'handle' => 'red'],
    ];

    $result = $field->serializeValue(['label' => 'NonExistent', 'handle' => 'nonExistent']);

    expect($result)->toBeNull();
});

// =========================================================================
// normalizeValue
// =========================================================================

it('returns existing ColourSwatchesModel as-is', function () {
    $model = new \percipiolondon\colourswatches\models\ColourSwatches(
        \craft\helpers\Json::encode(['label' => 'Red', 'color' => '#f00'])
    );

    $field = new ColourSwatches();
    $result = $field->normalizeValue($model);

    expect($result)->toBe($model);
});

it('normalizes JSON string to ColourSwatchesModel', function () {
    $json = \craft\helpers\Json::encode(['label' => 'Red', 'color' => '#f00', 'handle' => 'red']);

    $field = new ColourSwatches();
    $result = $field->normalizeValue($json);

    expect($result)->toBeInstanceOf(\percipiolondon\colourswatches\models\ColourSwatches::class)
        ->and($result->label)->toBe('Red')
        ->and($result->handle)->toBe('red');
});

it('normalizes array to ColourSwatchesModel (Vizy compat)', function () {
    $array = ['label' => 'Red', 'color' => '#f00', 'handle' => 'red'];

    $field = new ColourSwatches();
    $result = $field->normalizeValue($array);

    expect($result)->toBeInstanceOf(\percipiolondon\colourswatches\models\ColourSwatches::class)
        ->and($result->label)->toBe('Red');
});

it('returns null for empty value with no default', function () {
    $field = new ColourSwatches();
    $field->options = [
        ['label' => 'Red', 'color' => '#f00', 'class' => '', 'default' => false],
    ];

    expect($field->normalizeValue(null))->toBeNull()
        ->and($field->normalizeValue(''))->toBeNull();
});

it('returns default model for empty value when default exists', function () {
    $field = new ColourSwatches();
    $field->options = [
        ['label' => 'Red', 'color' => '#f00', 'class' => '', 'default' => false],
        ['label' => 'Blue', 'color' => '#00f', 'class' => '', 'default' => true],
    ];

    $result = $field->normalizeValue(null);

    expect($result)->toBeInstanceOf(\percipiolondon\colourswatches\models\ColourSwatches::class)
        ->and($result->label)->toBe('Blue');
});

// =========================================================================
// Default detection uses !empty() not == 1 (M-2 fix)
// =========================================================================

it('detects default from boolean true', function () {
    $field = new ColourSwatches();
    $field->options = [
        ['label' => 'Red', 'color' => '#f00', 'class' => '', 'default' => true],
    ];

    $result = $field->normalizeValue(null);

    expect($result)->not->toBeNull()
        ->and($result->label)->toBe('Red');
});

it('detects default from string "1" (editable table checkbox)', function () {
    $field = new ColourSwatches();
    $field->options = [
        ['label' => 'Red', 'color' => '#f00', 'class' => '', 'default' => '1'],
    ];

    $result = $field->normalizeValue(null);

    expect($result)->not->toBeNull()
        ->and($result->label)->toBe('Red');
});

it('does not treat empty string as default', function () {
    $field = new ColourSwatches();
    $field->options = [
        ['label' => 'Red', 'color' => '#f00', 'class' => '', 'default' => ''],
    ];

    $result = $field->normalizeValue(null);

    expect($result)->toBeNull();
});

it('does not treat zero as default', function () {
    $field = new ColourSwatches();
    $field->options = [
        ['label' => 'Red', 'color' => '#f00', 'class' => '', 'default' => 0],
    ];

    $result = $field->normalizeValue(null);

    expect($result)->toBeNull();
});
