<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Permissions;
class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         $users = [
            [
                'id' => 1,
                'name' => 'Administrator',
                'email' => 'super@admin.com',
                'password' => Hash::make('hokkie@2023'),
                'is_active' => 1
            ],
            [
                'id' => 2,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('hokkie@2023'),
                'is_active' => 1
            ], [
                'id' => 3,
                'name' => 'User',
                'email' => 'super@user.com',
                'password' => Hash::make('hokkie@2023'),
                'is_active' => 1
            ],[
                'id' => 4,
                'name' => 'Manager',
                'email' => 'manager@manager.com',
                'password' => Hash::make('hokkie@2023'),
                'is_active' => 1
            ],[
                'id' => 5,
                'name' => 'Operator',
                'email' => 'operator@operator.com',
                'password' => Hash::make('hokkie@2023'),
                'is_active' => 1
            ],[
                'id' => 6,
                'name' => 'Operator2',
                'email' => 'operator2@operator.com',
                'password' => Hash::make('hokkie@2023'),
                'is_active' => 1
            ],

        ];

        foreach ($users as $user_data) {
            $user = User::create($user_data);

        }
        $managerpermissions = Permissions::ManagerPermissions();
        $operatorpermissions = Permissions::OperatorPermissions();
        $adminpermissions = Permissions::AdminPermissions();
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Administrator']);
        $user = Role::create(['name' => 'user']);
        $manager = Role::create(['name' => 'Manager']);
        $operator = Role::create(['name' => 'Operator']);
        User::findOrFail(1)->assignRole($superAdmin);
        User::findOrFail(2)->assignRole($admin);
        User::findOrFail(3)->assignRole($user);
        User::findOrFail(4)->assignRole($manager);
        User::findOrFail(5)->assignRole($operator);
        User::findOrFail(6)->assignRole($operator);
        $manager->givePermissionTo($managerpermissions);
        $operator->givePermissionTo($operatorpermissions);
        $admin->givePermissionTo($adminpermissions);
        $user->givePermissionTo($operatorpermissions);



    }
}
