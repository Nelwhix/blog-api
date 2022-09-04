<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the different roles and permissions to db.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'post_show',
            'post_upload',
            'post_update',
            'post_delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }
        $admin = Role::create(['name' => 'Admin']);
        $admin->syncPermissions($permissions);

        $guest = Role::create(['name' => 'Guest']);
        $guest->givePermissionTo($permissions[0]);
    }
}
