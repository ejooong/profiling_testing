<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@nasdem-bojonegoro.id',
            'password' => Hash::make('password123'),
            'phone' => '081234567890',
            'is_active' => true,
        ]);
        $superAdmin->assignRole('super-admin');

        // DPD Admin
        $dpdAdmin = User::create([
            'name' => 'Admin DPD',
            'email' => 'dpdadmin@nasdem-bojonegoro.id',
            'password' => Hash::make('password123'),
            'phone' => '081234567891',
            'is_active' => true,
        ]);
        $dpdAdmin->assignRole('dpd-admin');

        // DPC Admin
        $dpcAdmin = User::create([
            'name' => 'Admin DPC Ngasem',
            'email' => 'dpcadmin@nasdem-bojonegoro.id',
            'password' => Hash::make('password123'),
            'phone' => '081234567892',
            'is_active' => true,
        ]);
        $dpcAdmin->assignRole('dpc-admin');

        // News Writer
        $newsWriter = User::create([
            'name' => 'Penulis Berita',
            'email' => 'writer@nasdem-bojonegoro.id',
            'password' => Hash::make('password123'),
            'phone' => '081234567893',
            'is_active' => true,
        ]);
        $newsWriter->assignRole('news-writer');
    }
}   