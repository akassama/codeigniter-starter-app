<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AppModules extends Migration
{
    public function up()
    {
        // Load custom helper
        helper('data_helper');

        $this->forge->addField([
            'app_module_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'unique' => true,
            ],
            'module_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'module_description' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'module_roles' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'module_link' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'updated_at datetime default current_timestamp on update current_timestamp',
            'created_at datetime default current_timestamp',
        ]);
        $this->forge->addKey('app_module_id', true);
        $this->forge->createTable('app_modules');

        //insert default records
        //----------------------
        $data = [
            [
                'app_module_id' => getGUID(),
                'module_name'    => 'Dashboard',
                'module_description'    => 'View admin dashboard',
                'module_roles'    => 'Admin,Manager,User',
                'module_link'    => 'account/dashboard',
            ],
            [
                'app_module_id' => getGUID(),
                'module_name'  => 'Contacts',
                'module_description'  => 'Manage contacts',
                'module_roles'    => 'Admin,Manager,User',
                'module_link'    => 'account/contacts',
            ],
            [
                'app_module_id' => getGUID(),
                'module_name'  => 'Account Details',
                'module_description'  => 'Update account details',
                'module_roles'    => 'Admin,Manager,User',
                'module_link'    => 'account/settings/update-details',
            ],
            [
                'app_module_id' => getGUID(),
                'module_name'  => 'Change Password',
                'module_description'  => 'Change account password',
                'module_roles'    => 'Admin,Manager,User',
                'module_link'    => 'account/settings/change-password',
            ],
            [
                'app_module_id' => getGUID(),
                'module_name'  => 'Admin',
                'module_description'  => 'Administration',
                'module_roles'    => 'Admin',
                'module_link'    => 'account/admin',
            ],
            [
                'app_module_id' => getGUID(),
                'module_name'  => 'Users',
                'module_description'  => 'Manage application users',
                'module_roles'    => 'Admin',
                'module_link'    => 'account/admin/users',
            ],
            [
                'app_module_id' => getGUID(),
                'module_name'  => 'Activity Logs',
                'module_description'  => 'View activity logs',
                'module_roles'    => 'Admin',
                'module_link'    => 'account/admin/activity-logs',
            ],
        ];

        // Using Query Builder
        $this->db->table('app_modules')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('app_modules');
    }
}
