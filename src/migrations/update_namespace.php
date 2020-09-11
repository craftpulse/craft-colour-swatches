<?php

namespace percipioglobal\colourswatches\migrations;

use Craft;
use craft\db\Migration;

/**
 * Install migration.
 */
class update_namespace extends Migration
{
    // Public Methods
    // =========================================================================

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
        echo "update_namespace cannot be reverted.\n";
        return true;
    }
}