<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        // Load custom helper
        helper('data_helper');

        $this->forge->addField([
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'unique' => true,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'status' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => 'User',
            ],
            'upload_directory' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => generateUserDirectory('user'),
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('user_id', true);
        $this->forge->createTable('users');

        //Insert default record
        $data = [
            'user_id' => getGUID(),
            'first_name'    => 'Admin',
            'last_name'    => 'User',
            'username'    => 'admin',
            'email'    => 'admin@example.com',
            'password' => password_hash('Admin@1', PASSWORD_DEFAULT),
            'status'    => 1,
            'role'    => 'Admin',
            'upload_directory' => generateUserDirectory('admin')
        ];

        // Using Query Builder
        $this->db->table('users')->insert($data);
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
    
}
