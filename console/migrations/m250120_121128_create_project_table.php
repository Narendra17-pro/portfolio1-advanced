<?php

use yii\db\Migration;

/**
 * Class m250120_121128_create_project_team
 */
class m250120_121128_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project}}',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->notNull(),
            'tech_stack'=>$this->text()->notNull(),
            'description'=>$this->text()->notNull(),
            'start_date'=>$this->integer()->notNull(),
            'end_date'=>$this->integer()->notNull(),
        ]);

        }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250120_121128_create_project_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250120_121128_create_project_table cannot be reverted.\n";

        return false;
    }
    */
}
