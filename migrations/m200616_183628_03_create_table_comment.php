<?php

use yii\db\Migration;

class m200616_183628_03_create_table_comment extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%comment}}',
            [
                'id' => $this->primaryKey(),
                'title' => $this->string()->notNull(),
                'body' => $this->text(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
                'post_id' => $this->integer(),
            ],
            $tableOptions
        );

        $this->addForeignKey(
            'comment_post_id_fk',
            '{{%comment}}',
            ['post_id'],
            '{{%post}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%comment}}');
    }
}
