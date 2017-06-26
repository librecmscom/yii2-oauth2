<?php

namespace yuncms\oauth2\migrations;

use yii\db\Migration;

class M170626035320Add_backend_menu extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%admin_menu}}', [
            'name' => 'App管理',
            'parent' => 8,
            'route' => '/oauth2/client/index',
            'icon' => 'fa fa-apple',
            'sort' => NULL,
            'data' => NULL
        ]);

        $id = (new \yii\db\Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => 'App管理', 'parent' => 8])->scalar($this->getDb());
        $this->batchInsert('{{%admin_menu}}', ['name', 'parent', 'route', 'visible', 'sort'], [
            ['App查看', $id, '/oauth2/client/view', 0, NULL],
        ]);
    }

    public function safeDown()
    {
        $id = (new \yii\db\Query())->select(['id'])->from('{{%admin_menu}}')->where(['name' => 'App管理', 'parent' => 8])->scalar($this->getDb());
        $this->delete('{{%admin_menu}}', ['parent' => $id]);
        $this->delete('{{%admin_menu}}', ['id' => $id]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M170626035320Add_backend_menu cannot be reverted.\n";

        return false;
    }
    */
}
