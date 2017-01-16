<?php

namespace yuncms\oauth2\migrations;

use yii\db\Migration;

class M170113100909Create_oauth2_access_token_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%oauth2_access_token}}', [
            'access_token' => $this->string(40)->notNull(),
            'client_id' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'expires' => $this->integer()->notNull(),
            'scope' => $this->text(),
        ], $tableOptions);
        $this->addPrimaryKey('pk', '{{%oauth2_access_token}}', 'access_token');
        $this->createIndex('ix_access_token_expires', '{{%oauth2_access_token}}', 'expires');
        $this->addforeignkey('fk_access_token_oauth2_client_client_id', '{{%oauth2_access_token}}', 'client_id', '{{%oauth2_client}}', 'client_id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%oauth2_access_token}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
