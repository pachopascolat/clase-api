<?php

use yii\db\Migration;

class m200616_183627_01_create_table_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%user}}',
            [
                'id' => $this->primaryKey(),
                'username' => $this->string(80),
                'password' => $this->string(),
                'authKey' => $this->string(),
                'accessToken' => $this->string(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
