<?php

use yii\db\Migration;

class m200623_204932_create_table_alumno extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%alumno}}',
            [
                'id_alumno' => $this->primaryKey(),
                'nombre' => $this->string(80),
                'apellido' => $this->string(80),
                'dni' => $this->integer(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%alumno}}');
    }
}
