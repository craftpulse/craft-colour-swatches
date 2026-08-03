<?php

namespace percipiolondon\colourswatches\migrations;

use craft\db\Migration;

/**
 * Updates field type class references from the pre-1.x `percipioglobal` namespace
 * to `percipioglobal\colourswatches`.
 *
 * @author CraftPulse
 * @since 1.3.0
 */
class m200911_142127_update_namespace extends Migration
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
                'type' => 'percipioglobal\\colourswatches\\fields\\ColourSwatches',
            ],
            'type = :riastype',
            [
                ':riastype' => 'rias\\colourswatches\\fields\\ColourSwatches',
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
