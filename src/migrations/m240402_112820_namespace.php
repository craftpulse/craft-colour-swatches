<?php

namespace percipiolondon\colourswatches\migrations;

use Craft;
use craft\db\Migration;

/**
 * m240402_112820_namespace migration.
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
