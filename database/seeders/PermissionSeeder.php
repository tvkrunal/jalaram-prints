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
            ],[
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
                'name' => 'Inquiry Delete',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Inquiry List',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Inquiry Create',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Inquiry Edit',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Inquiry Delete',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Customer List',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Customer Create',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Customer Edit',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Customer Delete',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Price Master List',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Price Master List Create',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Price Master List Edit',
                'guard_name' => 'web',
                'model_name' => 'roles',
            ],[
                'name' => 'Price Master List Delete',
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
