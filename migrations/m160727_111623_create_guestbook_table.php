<?php

use yii\db\Migration;

/**
 * Handles the creation for table `guestbook`.
 */
class m160727_111623_create_guestbook_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('guestbook', [
            'id' => $this->primaryKey(),
            'ip' => $this->string(),
            'browser' => $this->string(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'homepage' => $this->string(),
            'message' => $this->text()->notNull(),
            'msgputtime' => $this->dateTime(),
            'image' => $this->string(),
            'file' => $this->string()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('guestbook');
    }
}
