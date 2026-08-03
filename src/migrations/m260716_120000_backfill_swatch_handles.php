<?php

namespace percipiolondon\colourswatches\migrations;

use Craft;
use craft\db\Migration;
use craft\helpers\Queue;
use craft\queue\jobs\ResaveElements;
use percipiolondon\colourswatches\fields\ColourSwatches as ColourSwatchesField;

/**
 * Backfills stable handles on stored swatch values.
 *
 * Values saved before 5.2.0 only contain label, colour, and class. Resaving an
 * element runs the value through serializeValue(), which matches it against the
 * field's option definitions and writes the stable handle (plus search
 * keywords). This migration queues a batched resave job for every element type
 * whose field layout contains a Colour Swatches field.
 *
 * @author CraftPulse
 * @since 5.2.0
 */
class m260716_120000_backfill_swatch_handles extends Migration
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $elementTypes = [];

        foreach (Craft::$app->getFields()->getAllLayouts() as $layout) {
            foreach ($layout->getCustomFields() as $field) {
                if ($field instanceof ColourSwatchesField) {
                    $elementTypes[$layout->type] = true;
                    break;
                }
            }
        }

        foreach (array_keys($elementTypes) as $elementType) {
            echo "    > queueing resave job for {$elementType} elements ...\n";

            Queue::push(new ResaveElements([
                'elementType' => $elementType,
                'criteria' => ['status' => null],
                'updateSearchIndex' => true,
            ]));
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m260716_120000_backfill_swatch_handles cannot be reverted.\n";
        return false;
    }
}
