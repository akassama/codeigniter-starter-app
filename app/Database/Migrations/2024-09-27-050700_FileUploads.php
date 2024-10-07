<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FileUploads extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'file_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'unique' => true,
            ],
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'file_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'file_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'file_size' => [
                'type' => 'FLOAT',
            ],
            'upload_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'updated_at datetime default current_timestamp on update current_timestamp',
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addKey('file_id', true);
        $this->forge->createTable('file_uploads');
    }

    public function down()
    {
        $this->forge->dropTable('file_uploads');
    }
}
