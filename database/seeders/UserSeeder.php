<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@vafactory.shop',
            'password' => bcrypt('Password123!'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $roleWebAdmin = Role::create(['name' => 'Web Admin', 'guard_name' => 'web']);
        $webPermissions = Permission::where('guard_name', 'web')->pluck('id', 'id')->all();
        $roleWebAdmin->syncPermissions($webPermissions);
        $userAdmin->assignRole($roleWebAdmin->name);

        $userOwner = User::create([
            'name' => 'Owner',
            'email' => 'owner@vafactory.shop',
            'password' => bcrypt('Password123!'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $roleApiOwner = Role::create(['name' => 'Api Owner', 'guard_name' => 'api']);
        // $userOwner->assignRole([$roleApiOwner->id]);

        $userStaff = User::create([
            'name' => 'Staff',
            'email' => 'staff@vafactory.shop',
            'password' => bcrypt('Password123!'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $roleApiStaff = Role::create(['name' => 'Api Staff', 'guard_name' => 'api']);
        // $userStaff->assignRole([$roleApiStaff->id]);
    }
}
