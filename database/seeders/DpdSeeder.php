<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DPD\Dpd;

class DpdSeeder extends Seeder
{
    public function run(): void
    {
        Dpd::create([
            'name' => 'DPD NasDem Kabupaten Bojonegoro',
            'slug' => 'dpd-nasdem-kabupaten-bojonegoro',
            'address' => 'Jl. Raya Bojonegoro No. 123, Bojonegoro, Jawa Timur',
            'phone' => '(0353) 123456',
            'email' => 'dpd@nasdem-bojonegoro.id',
            'ketua' => 'H. Ahmad Budi Santoso',
            'sekretaris' => 'Drs. Muhammad Arifin',
            'bendahara' => 'Siti Aminah, SE.',
            'total_kader' => 4821,
            'total_dpc' => 28,
            'description' => 'Dewan Pimpinan Daerah Partai NasDem Kabupaten Bojonegoro',
            'is_active' => true,
        ]);
    }
}