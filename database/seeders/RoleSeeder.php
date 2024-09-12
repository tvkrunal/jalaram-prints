<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks to avoid constraints violation during truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Truncate the tables in the correct order
        $this->truncateTable('model_has_roles');
        $this->truncateTable('role_has_permissions');
        $this->truncateTable('roles');
        $this->truncateTable('permissions');

        $data = [
            [
                'name' => 'Admin',
                'guard_name' => 'web',
            ], [
                'name' => 'Designer',
                'guard_name' => 'web',
            ], [
                'name' => 'Printing',
                'guard_name' => 'web',
            ], [
                'name' => 'Processor',
                'guard_name' => 'web',
            ],[
                'name' => 'Accountant',
                'guard_name' => 'web',
            ],
        ];

        foreach ($data as $item) {
            Role::updateOrCreate([
                'name' => $item['name']
                ], $item);
        }
    }

    /**
     * Truncate the table.
     *
     * @param string $tableName
     * @return void
     */
    private function truncateTable($tableName)
    {
        DB::table($tableName)->truncate();
    }
}
