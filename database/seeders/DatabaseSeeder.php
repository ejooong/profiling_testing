<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            DpdSeeder::class,
            BeritaCategorySeeder::class,
            UserSeeder::class,
            DpcSeeder::class,
            DprtSeeder::class,     // Sudah dibuat
            KaderSeeder::class,     // Sudah dibuat
            BeritaSeeder::class,    // Sudah dibuat
            GeojsonSeeder::class,
            GalleryPermissionSeeder::class,
        ]);
    }
}
