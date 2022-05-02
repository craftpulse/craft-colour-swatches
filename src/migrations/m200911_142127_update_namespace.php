<?php

namespace percipiolondon\colourswatches\migrations;

use craft\db\Migration;

/**
 * m200911_142127_update_namespace migration.
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
