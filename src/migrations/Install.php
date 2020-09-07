<?php

namespace percipioglobal\colourswatches\migrations;

use Craft;
use craft\db\Migration;

/**
 * Install migration.
 */
class Install extends Migration
{
    // Public Methods
    // =========================================================================

    public function safeUp()
    {
        $this->updateTables();

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "Install cannot be reverted.\n";
        return true;
    }

    // Protected Methods
    // =========================================================================

    protected function updateTables()
    {
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
    }
}