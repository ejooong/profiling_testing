<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat permissions
        $permissions = [
            // DPD permissions
            'view-dpd', 'create-dpd', 'edit-dpd', 'delete-dpd',
            'view-dpd-structure', 'create-dpd-structure', 'edit-dpd-structure', 'delete-dpd-structure',
            
            // DPC permissions
            'view-dpc', 'create-dpc', 'edit-dpc', 'delete-dpc',
            'view-dpc-structure', 'create-dpc-structure', 'edit-dpc-structure', 'delete-dpc-structure',
            
            // DPRT permissions
            'view-dprt', 'create-dprt', 'edit-dprt', 'delete-dprt',
            'view-dprt-structure', 'create-dprt-structure', 'edit-dprt-structure', 'delete-dprt-structure',
            
            // Kader permissions
            'view-kader', 'create-kader', 'edit-kader', 'delete-kader', 'verify-kader',
            
            // Berita permissions
            'view-berita', 'create-berita', 'edit-berita', 'delete-berita', 'publish-berita',
            'view-category', 'create-category', 'edit-category', 'delete-category',
            
            // GIS permissions
            'view-gis', 'edit-gis',
            
            // User management
            'view-users', 'create-users', 'edit-users', 'delete-users',
            
            // Dashboard access
            'view-dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Buat roles
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $dpdAdmin = Role::create(['name' => 'dpd-admin']);
        $dpdAdmin->givePermissionTo([
            'view-dashboard',
            'view-dpd', 'edit-dpd',
            'view-dpd-structure', 'create-dpd-structure', 'edit-dpd-structure', 'delete-dpd-structure',
            'view-dpc', 'create-dpc', 'edit-dpc', 'delete-dpc',
            'view-dpc-structure', 'edit-dpc-structure',
            'view-dprt', 'create-dprt', 'edit-dprt', 'delete-dprt',
            'view-kader', 'create-kader', 'edit-kader', 'verify-kader',
            'view-berita', 'create-berita', 'edit-berita', 'publish-berita',
            'view-category',
            'view-gis',
        ]);

        $dpcAdmin = Role::create(['name' => 'dpc-admin']);
        $dpcAdmin->givePermissionTo([
            'view-dashboard',
            'view-dpc', 'edit-dpc',
            'view-dpc-structure', 'edit-dpc-structure',
            'view-dprt', 'create-dprt', 'edit-dprt',
            'view-kader', 'create-kader', 'edit-kader',
            'view-berita', 'create-berita', 'edit-berita',
        ]);

        $newsWriter = Role::create(['name' => 'news-writer']);
        $newsWriter->givePermissionTo([
            'view-dashboard',
            'view-berita', 'create-berita', 'edit-berita',
        ]);

        $kader = Role::create(['name' => 'kader']);
        $kader->givePermissionTo([
            'view-dashboard',
        ]);
    }
}