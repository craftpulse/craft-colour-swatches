<?php

namespace percipioglobal\colourswatches\migrations;

use Craft;
use craft\db\Migration;

/**
 * m200911_142127_update_namespace migration.
 */
class m200911_142127_update_namespace extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        echo "update_namespace updating .\n";

        $this->update(
            '{{%fields}}',
            [
                'type' => 'percipioglobal\\colourswatches\\fields\\ColourSwatches'
            ],
            'type = :riastype',
            [
                ':riastype' => 'rias\\colourswatches\\fields\\ColourSwatches'
            ]
        );

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m200911_142127_update_namespace cannot be reverted.\n";
        return false;
    }
}
