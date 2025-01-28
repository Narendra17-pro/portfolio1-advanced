<?php

use yii\db\Migration;

/**
 * Class m250123_085001_add_image_path_to_project
 */
class m250123_085001_add_image_path_to_project extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%project}}', 'image_path', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%project}}', 'image_path');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250123_085001_add_image_path_to_project cannot be reverted.\n";

        return false;
    }
    */
}
