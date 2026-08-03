<?php

use craft\helpers\Json;
use percipiolondon\colourswatches\models\ColourSwatches;

// =========================================================================
// Construction from JSON
// =========================================================================

it('constructs from valid JSON with all fields', function () {
    $data = [
        'handle' => 'red',
        'label' => 'Red',
        'color' => '#ef4444',
        'class' => 'bg-red-500',
        'default' => true,
    ];

    $model = new ColourSwatches(Json::encode($data));

    expect($model->handle)->toBe('red')
        ->and($model->label)->toBe('Red')
        ->and($model->color)->toBe('#ef4444')
        ->and($model->class)->toBe('bg-red-500')
        ->and($model->default)->toBeTrue();
});

it('constructs from JSON with missing handle (backwards compat)', function () {
    $data = [
        'label' => 'Blue',
        'color' => '#3b82f6',
        'class' => '',
        'default' => false,
    ];

    $model = new ColourSwatches(Json::encode($data));

    expect($model->handle)->toBeNull()
        ->and($model->label)->toBe('Blue')
        ->and($model->color)->toBe('#3b82f6');
});

it('constructs from JSON with array color (config-file format)', function () {
    $data = [
        'label' => 'Red',
        'handle' => 'red',
        'color' => [
            ['color' => '#ef4444', 'background' => 'bg-red-500'],
        ],
        'class' => null,
        'default' => false,
    ];

    $model = new ColourSwatches(Json::encode($data));

    expect($model->color)->toBeArray()
        ->and($model->color[0]['color'])->toBe('#ef4444')
        ->and($model->color[0]['background'])->toBe('bg-red-500');
});

it('constructs from JSON with gradient (multiple colors)', function () {
    $data = [
        'label' => 'Sunset',
        'handle' => 'sunset',
        'color' => [
            ['color' => '#ef4444'],
            ['color' => '#f59e0b'],
        ],
        'default' => false,
    ];

    $model = new ColourSwatches(Json::encode($data));

    expect($model->color)->toBeArray()
        ->and($model->color)->toHaveCount(2);
});

it('handles null value gracefully', function () {
    $model = new ColourSwatches(null);

    expect($model->handle)->toBeNull()
        ->and($model->label)->toBe('')
        ->and($model->color)->toBeNull()
        ->and($model->default)->toBeFalse()
        ->and($model->class)->toBe('');
});

it('handles empty string value gracefully', function () {
    $model = new ColourSwatches('');

    expect($model->label)->toBe('')
        ->and($model->color)->toBeNull();
});

it('handles invalid JSON gracefully', function () {
    $model = new ColourSwatches('not json');

    expect($model->label)->toBe('')
        ->and($model->color)->toBeNull();
});

it('handles JSON without label gracefully', function () {
    $model = new ColourSwatches(Json::encode(['color' => '#fff']));

    expect($model->label)->toBe('')
        ->and($model->color)->toBeNull();
});

// =========================================================================
// Default field coercion
// =========================================================================

it('coerces default "1" string to boolean true', function () {
    $data = ['label' => 'Red', 'color' => '#f00', 'default' => '1'];
    $model = new ColourSwatches(Json::encode($data));

    expect($model->default)->toBeTrue();
});

it('coerces default integer 1 to boolean true', function () {
    $data = ['label' => 'Red', 'color' => '#f00', 'default' => 1];
    $model = new ColourSwatches(Json::encode($data));

    expect($model->default)->toBeTrue();
});

it('coerces default "0" string to boolean false', function () {
    $data = ['label' => 'Red', 'color' => '#f00', 'default' => '0'];
    $model = new ColourSwatches(Json::encode($data));

    expect($model->default)->toBeFalse();
});

it('coerces default "" empty string to boolean false', function () {
    $data = ['label' => 'Red', 'color' => '#f00', 'default' => ''];
    $model = new ColourSwatches(Json::encode($data));

    expect($model->default)->toBeFalse();
});

it('defaults missing default field to false', function () {
    $data = ['label' => 'Red', 'color' => '#f00'];
    $model = new ColourSwatches(Json::encode($data));

    expect($model->default)->toBeFalse();
});

// =========================================================================
// __toString
// =========================================================================

it('casts to string as the label', function () {
    $model = new ColourSwatches(Json::encode(['label' => 'Primary Blue', 'color' => '#00f']));

    expect((string)$model)->toBe('Primary Blue');
});

it('casts to empty string when no label', function () {
    $model = new ColourSwatches(null);

    expect((string)$model)->toBe('');
});

// =========================================================================
// Accessor methods
// =========================================================================

it('colors() returns the color property', function () {
    $model = new ColourSwatches(Json::encode(['label' => 'Red', 'color' => '#f00']));

    expect($model->colors())->toBe('#f00');
});

it('labels() returns the label property', function () {
    $model = new ColourSwatches(Json::encode(['label' => 'Red', 'color' => '#f00']));

    expect($model->labels())->toBe('Red');
});

// =========================================================================
// collection()
// =========================================================================

it('returns a Collection from array color', function () {
    $data = [
        'label' => 'Gradient',
        'color' => [
            ['color' => '#ef4444', 'background' => 'bg-red-500'],
            ['color' => '#3b82f6', 'background' => 'bg-blue-500'],
        ],
    ];
    $model = new ColourSwatches(Json::encode($data));

    $collection = $model->collection();

    expect($collection)->toBeInstanceOf(\Illuminate\Support\Collection::class)
        ->and($collection)->toHaveCount(2);
});

it('returns an empty Collection when color is null', function () {
    $model = new ColourSwatches(null);

    $collection = $model->collection();

    expect($collection)->toBeInstanceOf(\Illuminate\Support\Collection::class)
        ->and($collection)->toHaveCount(0);
});

it('returns a Collection from string color', function () {
    $model = new ColourSwatches(Json::encode(['label' => 'Red', 'color' => '#f00']));

    $collection = $model->collection();

    // String wraps into a single-item collection containing the characters
    expect($collection)->toBeInstanceOf(\Illuminate\Support\Collection::class);
});
