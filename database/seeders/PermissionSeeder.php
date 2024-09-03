<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Admin List',
                'guard_name' => 'web',
                'model_name' => 'admin',
            ],
            [
                'name' => 'Dashboard List',
                'guard_name' => 'web',
                'model_name' => 'dashboard',
            ],[
                'name' => 'User List',
                'guard_name' => 'web',
                'model_name' => 'user',
            ],[
                'name' => 'User Create',
                'guard_name' => 'web',
                'model_name' => 'user',
            ],[
                'name' => 'User Edit',
                'guard_name' => 'web',
                'model_name' => 'user',
            ],[
                'name' => 'User Delete',
                'guard_name' => 'web',
                'model_name' => 'user',
            ],[
                'name' => 'Roles List',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Roles Create',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Roles Edit',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Roles Delete',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],
        ];

        foreach ($data as $item) {
            Permission::updateOrCreate([
                'name' => $item['name'],
            ], $item);
        }
    }
}
