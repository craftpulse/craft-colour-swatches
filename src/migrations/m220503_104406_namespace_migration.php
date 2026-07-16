<?php

namespace percipiolondon\colourswatches\migrations;

use craft\db\Migration;

/**
 * Updates field type class references from the `percipioglobal` namespace
 * to `percipiolondon\colourswatches`.
 *
 * @deprecated Has a parameter binding bug (missing colon prefix on params key).
 *             Fixed by m220523_152700_namespace_migration_fix. Must not be modified
 *             as it has already been applied to existing installations.
 *
 * @author CraftPulse
 * @since 3.0.0
 */
class m220503_104406_namespace_migration extends Migration
{
    /**
     * @return bool
     */
    public function safeUp(): bool
    {
        echo "update_namespace updating .\n";

        $this->update(
            '{{%fields}}',
            [
                'type' => 'percipiolondon\\colourswatches\\fields\\ColourSwatches',
            ],
            'type = :percipioglobal',
            [
                'percipioglobal' => 'percipioglobal\\colourswatches\\fields\\ColourSwatches',
            ]
        );

        return true;
    }


    /**
     * @return false
     */
    public function safeDown(): bool
    {
        echo "m220503_104406_namespace_migration cannot be reverted.\n";
        return false;
    }
}
