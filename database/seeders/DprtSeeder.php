<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DPC\Dpc;
use App\Models\DPRT\Dprt;

class DprtSeeder extends Seeder
{
    public function run(): void
    {
        $dpcs = Dpc::all();
        
        // Nama desa per kecamatan (contoh)
        $desaNames = [
            'Ngasem' => ['Ngasem', 'Sambong', 'Dander', 'Sumberagung', 'Gayam'],
            'Bojonegoro' => ['Kadipaten', 'Karangpacar', 'Sumbang', 'Kepatihan', 'Mulyoagung'],
            'Kedungadem' => ['Kedungadem', 'Babad', 'Balongcabe', 'Dayukidul', 'Pojok'],
            'Kapas' => ['Kapas', 'Sukowati', 'Kedaton', 'Bendo', 'Bangilan'],
            'Dander' => ['Dander', 'Sumberrejo', 'Ngumpakdalem', 'Ngrancang', 'Sumberagung'],
        ];
        
        foreach ($dpcs as $dpc) {
            $desas = $desaNames[$dpc->kecamatan_name] ?? ['Desa Utama', 'Desa Timur', 'Desa Barat', 'Desa Selatan', 'Desa Tengah'];
            
            foreach ($desas as $index => $desaName) {
                Dprt::create([
                    'dpc_id' => $dpc->id,
                    'desa_name' => $desaName,
                    'slug' => \Illuminate\Support\Str::slug($desaName . '-' . $dpc->kecamatan_name),
                    'address' => 'Jl. Raya ' . $desaName . ' No. ' . ($index + 1),
                    'phone' => '(0353) 200' . sprintf('%02d', $dpc->id) . ($index + 1),
                    'email' => 'dprt.' . \Illuminate\Support\Str::slug($desaName) . '@nasdem-bojonegoro.id',
                    'ketua' => 'H. ' . $desaName . ' Wijaya',
                    'total_kader' => rand(10, 50),
                    'description' => 'DPRT NasDem Desa ' . $desaName . ', Kecamatan ' . $dpc->kecamatan_name,
                    'is_active' => true,
                ]);
            }
            
            // Update total DPRT di DPC
            $dpc->update(['total_dprt' => count($desas)]);
        }
    }
}