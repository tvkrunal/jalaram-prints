<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@dev.com'],
            [
                'first_name' => 'admin',
                'last_name' => 'admin',
                'password' => Hash::make('secret')
            ]
        );

        $role = Role::where('name', 'Admin')->first();
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

        $role = Role::where('name', 'Designer')->first();
        $permissions =  [
            "Dashboard List",
        ];
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

        $user = User::updateOrCreate(
            ['email' => 'designer@dev.com'],
            [
                'first_name' => 'designer',
                'last_name' => 'designer',
                'password' => Hash::make('secret')
            ]
        );

        $role = Role::where('name', 'Printing')->first();
        $permissions = [
            "Dashboard List",
        ];
        $role->syncPermissions($permissions);
        $user = User::updateOrCreate(
            ['email' => 'printing@dev.com'],
            [
                'first_name' => 'printing',
                'last_name' => 'printing',
                'password' => Hash::make('secret')
            ]
        );
        $user->assignRole([$role->id]);

        $role = Role::where('name', 'Processor')->first();
        $permissions = [
            "Dashboard List",
        ];
        $user = User::updateOrCreate(
            ['email' => 'processor@dev.com'],
            [
                'first_name' => 'processor',
                'last_name' => 'processor',
                'password' => Hash::make('secret')
            ]
        );
        $role->syncPermissions($permissions);

        $role = Role::where('name', 'Accountant')->first();
        $user = User::updateOrCreate(
            ['email' => 'accountant@dev.com'],
            [
                'first_name' => 'accountant',
                'last_name' => 'accountant',
                'password' => Hash::make('secret')
            ]
        );
        $permissions = [
            "Dashboard List",
        ];
        $role->syncPermissions($permissions);
    }
}
