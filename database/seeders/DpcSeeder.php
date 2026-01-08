<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DPC\Dpc;

class DpcSeeder extends Seeder
{
    public function run(): void
    {
        $kecamatans = [
            'Ngasem', 'Bojonegoro', 'Kedungadem', 'Kapas', 'Dander',
            'Kepohbaru', 'Baureno', 'Kanor', 'Sumberejo', 'Balen',
            'Purwosari', 'Kalitidu', 'Malo', 'Padangan', 'Kasiman',
            'Temayang', 'Margomulyo', 'Sukosewu', 'Kedewan', 'Gondang',
            'Sekar', 'Gayam', 'Tambakrejo', 'Ngambon', 'Ngraho',
            'Bubulan', 'Trucuk'
        ];

        foreach ($kecamatans as $index => $kecamatan) {
            Dpc::create([
                'dpd_id' => 1,
                'kecamatan_name' => $kecamatan,
                'slug' => \Illuminate\Support\Str::slug($kecamatan),
                'address' => 'Jl. Raya ' . $kecamatan . ' No. ' . ($index + 1),
                'phone' => '(0353) 100' . sprintf('%02d', $index + 1),
                'email' => 'dpc.' . \Illuminate\Support\Str::slug($kecamatan) . '@nasdem-bojonegoro.id',
                'ketua' => 'H. ' . $kecamatan . ' Santoso',
                'total_kader' => rand(50, 200),
                'total_dprt' => rand(5, 15),
                'description' => 'DPC NasDem Kecamatan ' . $kecamatan,
                'is_active' => true,
            ]);
        }
    }
}