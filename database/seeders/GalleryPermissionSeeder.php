<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GalleryPermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'view-gallery',
            'create-gallery',
            'edit-gallery',
            'delete-gallery',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign to admin role
        $adminRole = Role::where('name', 'super-admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }
    }
}
