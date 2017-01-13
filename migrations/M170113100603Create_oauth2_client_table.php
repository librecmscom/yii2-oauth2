<?php

namespace yuncms\oauth2\migrations;

use yii\db\Migration;

class M170113100603Create_oauth2_client_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%oauth2_client}}', [
            'client_id' => $this->string(80)->notNull(),
            'client_secret' => $this->string(80)->notNull(),
            'redirect_uri' => $this->text()->notNull(),
            'grant_type' => $this->text(),
            'scope' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ],$tableOptions);
        $this->addPrimaryKey('pk','{{%oauth2_client}}','client_id');
    }

    public function down()
    {
        $this->dropTable('{{%oauth2_client}}');
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
