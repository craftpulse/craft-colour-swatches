<?php

namespace percipiolondon\colourswatches\migrations;

use craft\db\Migration;

/**
 * m220523_152700_namespace_migration_fix migration.
 */
class m220523_152700_namespace_migration_fix extends Migration
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
                ':percipioglobal' => 'percipioglobal\\colourswatches\\fields\\ColourSwatches',
            ]
        );

        return true;
    }


    /**
     * @return false
     */
    public function safeDown(): bool
    {
        echo "m220523_152700_namespace_migration_fix cannot be reverted.\n";
        return false;
    }
}
