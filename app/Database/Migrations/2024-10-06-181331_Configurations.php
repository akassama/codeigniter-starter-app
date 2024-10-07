<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Configurations extends Migration
{
    public function up()
    {
        // Load custom helper
        helper('data_helper');

        $this->forge->addField([
            'config_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'unique' => true,
            ],
            'config_for' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => true,
            ],
            'config_value' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'deletable' => [
                'type' => 'INT',
                'default' => 1,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('config_id', true);
        $this->forge->createTable('configurations');

        //Insert default record
        $data = [
            [
                'config_id' => getGUID(),
                'config_for'    => 'CompanyName',
                'config_value'    => 'CI-Starter App',
                'deletable'    => 0
            ],
            [
                'config_id' => getGUID(),
                'config_for'    => 'CompanyEmail',
                'config_value'    => 'ci-starter@mail.com',
                'deletable'    => 0
            ],
            [
                'config_id' => getGUID(),
                'config_for'    => 'CompanyAddress',
                'config_value'    => '123 Maple Street<br/> Watford, Hertfordshire<br/> WD17 1AA<br/> United Kingdom',
                'deletable'    => 0
            ],
            [
                'config_id' => getGUID(),
                'config_for'    => 'MailjetApiKey',
                'config_value'    => '2854442df1ec0ad2c468a2a33c02893e',
                'deletable'    => 0
            ],
            [
                'config_id' => getGUID(),
                'config_for'    => 'MailjetApiSecret',
                'config_value'    => 'ea02ad147ce34365ec3a7bd6f31d8dbe',
                'deletable'    => 0
            ],
        ];

        // Using Query Builder
        $this->db->table('configurations')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('configurations');
    }
}
