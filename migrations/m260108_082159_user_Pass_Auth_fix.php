<?php

use yii\db\Migration;

class m260108_082159_user_Pass_Auth_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'auth_key', $this->string(64)->notNull()->defaultValue(''));

        $this->alterColumn('users', 'password', $this->string()->null());

        $this->addColumn('users', 'github_id', $this->bigInteger()->unique()->null());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260108_082159_user_Pass_Auth_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260108_082159_user_Pass_Auth_fix cannot be reverted.\n";

        return false;
    }
    */
}
