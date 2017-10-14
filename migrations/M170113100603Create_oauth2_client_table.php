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
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB  AUTO_INCREMENT=100000';
        }

        $this->createTable('{{%oauth2_client}}', [
            'client_id' => $this->primaryKey(),
            'client_secret' => $this->string(64),
            'user_id' => $this->integer()->unsigned(),
            'redirect_uri' => $this->text()->notNull()->comment('回调URL'),
            'grant_type' => $this->text(),
            'scope' => $this->text(),
            'name' => $this->string()->comment('客户端名称'),
            'domain' => $this->string()->comment('域名'),
            'provider' => $this->string()->comment('提供方'),
            'icp' => $this->string()->comment('ICP备案'),
            'registration_ip' => $this->string(),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], $tableOptions);

        $this->createIndex('{{%oauth2_client_unique}}', '{{%oauth2_client}}', ['client_id', 'client_secret'], true);
        $this->addforeignkey('fk_oauth2_client_user_id', '{{%oauth2_client}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
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
