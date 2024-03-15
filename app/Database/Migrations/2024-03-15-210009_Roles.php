<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Roles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'role_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'unique' => true,
            ],
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'role_description' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'updated_at datetime default current_timestamp on update current_timestamp',
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addKey('role_id', true);
        $this->forge->createTable('roles');

        //insert default records
        //----------------------
        $data = [
            [
                'role_id' => bin2hex(random_bytes(16)),
                'role'    => 'Admin',
                'role_description'    => 'Admin role'
            ],
            [
                'role_id' => bin2hex(random_bytes(16)),
                'role'  => 'Manager',
                'role_description'  => 'Manager Role',
            ],
            [
                'role_id' => bin2hex(random_bytes(16)),
                'role'  => 'User',
                'role_description'  => 'User Role',
            ],
        ];

        // Using Query Builder
        $this->db->table('roles')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('roles');
    }
}
