<?php

namespace percipiolondon\colourswatches\migrations;

use craft\db\Migration;

/**
 * Ensures any remaining `percipioglobal` field type class references are updated
 * to `percipiolondon\colourswatches` for Craft 5 installs.
 *
 * @author CraftPulse
 * @since 5.0.0
 */
class m240402_112820_namespace extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $this->update(
            '{{%fields}}',
            [
                'type' => 'percipiolondon\colourswatches\fields\ColourSwatches',
            ],
            'type = :percipioglobal',
            [
                ':percipioglobal' => 'percipioglobal\colourswatches\fields\ColourSwatches',
            ]
        );

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m240402_112820_namespace cannot be reverted.\n";
        return false;
    }
}
