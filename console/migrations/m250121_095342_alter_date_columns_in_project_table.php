<?php

use yii\db\Migration;

/**
 * Class m250121_095342_alter_date_columns_in_project_table
 */
class m250121_095342_alter_date_columns_in_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
     $this->alterColumn("project","start_date", $this->dateTime()->notNull());
     $this->alterColumn("project","end_date", $this->dateTime()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    { $this->alterColumn("project","start_date", $this->integer()->notNull());
        $this->alterColumn("project","end_date", $this->integer()->notNull());
        echo "m250121_095342_alter_date_columns_in_project_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250121_095342_alter_date_columns_in_project_table cannot be reverted.\n";

        return false;
    }
    */
}
