<?php

use craft\base\ElementInterface;
use craft\helpers\Json;
use percipiolondon\colourswatches\fields\ColourSwatches;
use percipiolondon\colourswatches\models\ColourSwatches as ColourSwatchesModel;

// =========================================================================
// searchKeywords()
// =========================================================================

function invokeSearchKeywords(ColourSwatches $field, mixed $value): string
{
    $element = test()->createMock(ElementInterface::class);
    $method = new ReflectionMethod($field, 'searchKeywords');

    return $method->invoke($field, $value, $element);
}

it('returns keywords for a model with a string colour', function () {
    $model = new ColourSwatchesModel(Json::encode([
        'handle' => 'red',
        'label' => 'Red',
        'color' => '#ef4444',
        'class' => 'bg-red-500',
        'default' => false,
    ]));

    $keywords = invokeSearchKeywords(new ColourSwatches(), $model);

    expect($keywords)->toContain('Red')
        ->toContain('red')
        ->toContain('bg-red-500')
        ->toContain('#ef4444');
});

it('returns keywords for a model with an array of colours', function () {
    $model = new ColourSwatchesModel(Json::encode([
        'handle' => 'redAmber',
        'label' => 'Red/Amber',
        'color' => [
            ['color' => '#ef4444', 'background' => 'bg-red-500'],
            ['color' => '#f59e0b', 'background' => 'bg-amber-500'],
        ],
        'class' => null,
        'default' => false,
    ]));

    $keywords = invokeSearchKeywords(new ColourSwatches(), $model);

    expect($keywords)->toContain('Red/Amber')
        ->toContain('redAmber')
        ->toContain('#ef4444')
        ->toContain('#f59e0b');
});

it('returns an empty string for non-model values', function () {
    expect(invokeSearchKeywords(new ColourSwatches(), null))->toBe('')
        ->and(invokeSearchKeywords(new ColourSwatches(), 'red'))->toBe('');
});
