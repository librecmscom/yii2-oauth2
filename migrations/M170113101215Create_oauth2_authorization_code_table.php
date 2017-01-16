<?php

namespace yuncms\oauth2\migrations;

use yii\db\Migration;

class M170113101215Create_oauth2_authorization_code_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%oauth2_authorization_code}}', [
            'authorization_code' => $this->string(40)->notNull(),
            'client_id' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'redirect_uri' => $this->text()->notNull(),
            'expires' => $this->integer()->notNull(),
            'scope' => $this->text(),
        ],$tableOptions);

        $this->addPrimaryKey('pk', '{{%oauth2_authorization_code}}', 'authorization_code');

        $this->createIndex('ix_authorization_code_expires', '{{%oauth2_authorization_code}}', 'expires');

        $this->addforeignkey('fk_authorization_code_oauth2_client_client_id', '{{%oauth2_authorization_code}}', 'client_id', '{{%oauth2_client}}', 'client_id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%oauth2_authorization_code}}');
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
