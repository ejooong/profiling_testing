<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kader\Kader;
use App\Models\DPC\Dpc;
use App\Models\DPRT\Dprt;

class KaderSeeder extends Seeder
{
    public function run(): void
    {
        // KOSONGKAN TABEL SEBELUM MENAMBAH DATA BARU
        Kader::truncate();
        
        $dpcs = Dpc::all();
        
        $firstNames = ['Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fajar', 'Gita', 'Hadi', 'Indra', 'Joko'];
        $lastNames = ['Santoso', 'Wijaya', 'Kusuma', 'Pratama', 'Setiawan', 'Hadi', 'Nugroho', 'Saputra', 'Wibowo', 'Suryadi'];
        
        $professions = ['Petani', 'Guru', 'PNS', 'Wiraswasta', 'Mahasiswa', 'Buruh', 'Pedagang', 'Dokter', 'Perawat', 'Karyawan Swasta'];
        $educations = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2'];
        
        $emailCounter = 1; // Counter untuk membuat email unik
        
        foreach ($dpcs as $dpc) {
            $dprts = $dpc->dprt()->where('is_active', true)->get();
            
            for ($i = 1; $i <= $dpc->total_kader; $i++) {
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                $name = $firstName . ' ' . $lastName;
                
                $dprt = $dprts->isNotEmpty() ? $dprts->random() : $dprts->first();
                
                // BUAT EMAIL UNIK DENGAN COUNTER
                $uniqueEmail = strtolower(str_replace(' ', '.', $name)) . '.' . $emailCounter . '@example.com';
                $emailCounter++;
                
                Kader::create([
                    'dpc_id' => $dpc->id,
                    'dprt_id' => $dprt ? $dprt->id : null,
                    'nik' => '35' . str_pad($dpc->id, 2, '0', STR_PAD_LEFT) . str_pad($i, 10, '0', STR_PAD_LEFT),
                    'name' => $name,
                    'email' => $uniqueEmail, // Gunakan email unik
                    'phone' => '0812' . str_pad($dpc->id, 2, '0', STR_PAD_LEFT) . str_pad($i, 6, '0', STR_PAD_LEFT),
                    'gender' => $i % 2 == 0 ? 'L' : 'P',
                    'birth_place' => 'Bojonegoro',
                    'birth_date' => now()->subYears(rand(20, 60))->subDays(rand(1, 365)),
                    'address' => 'Jl. Contoh No. ' . $i . ', ' . ($dprt ? $dprt->desa_name : 'Bojonegoro'),
                    'rt' => strval(rand(1, 10)),
                    'rw' => strval(rand(1, 5)),
                    'kelurahan' => $dprt ? $dprt->desa_name : 'Bojonegoro',
                    'kecamatan' => $dpc->kecamatan_name,
                    'profession' => $professions[array_rand($professions)],
                    'education' => $educations[array_rand($educations)],
                    'status' => $i % 5 == 0 ? 'pending' : ($i % 10 == 0 ? 'non_active' : 'active'),
                    'join_date' => now()->subDays(rand(1, 1000)),
                    'is_verified' => $i % 5 != 0,
                    'verified_at' => $i % 5 != 0 ? now()->subDays(rand(1, 500)) : null,
                    'verified_by' => $i % 5 != 0 ? 1 : null,
                    'position_in_party' => $i % 20 == 0 ? 'Pengurus' : ($i % 50 == 0 ? 'Koordinator' : 'Anggota'),
                ]);
            }
        }
    }
}