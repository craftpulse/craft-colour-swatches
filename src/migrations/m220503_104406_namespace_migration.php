<?php

namespace percipiolondon\colourswatches\migrations;

use craft\db\Migration;

/**
 * m220503_104406_namespace_migration migration.
 *
 * @deprecated Has a parameter binding bug (missing colon prefix on params key).
 *             Fixed by m220523_152700_namespace_migration_fix. Must not be modified
 *             as it has already been applied to existing installations.
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
        echo "m200911_142127_update_namespace cannot be reverted.\n";
        return false;
    }
}
