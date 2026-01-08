<?php

namespace Database\Seeders;

use App\Models\GIS\KabupatenGeo;
use App\Models\GIS\KecamatanGeo;
use App\Models\GIS\DesaGeo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeojsonSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DesaGeo::truncate();
        KecamatanGeo::truncate();
        KabupatenGeo::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // 1. Import Kabupaten
        $this->importKabupaten();
        
        // 2. Import Kecamatan
        $this->importKecamatan();
        
        // 3. Import Desa
        $this->importDesa();
        
        $this->command->info('✅ Data GeoJSON berhasil diimport!');
    }
    
    private function importKabupaten()
    {
        $filePath = public_path('geojson/kabupaten/kabupaten.geojson');
        
        if (!file_exists($filePath)) {
            $this->command->error('❌ File kabupaten.geojson tidak ditemukan!');
            return;
        }
        
        $geojson = json_decode(file_get_contents($filePath), true);
        
        foreach ($geojson['features'] as $feature) {
            $properties = $feature['properties'];
            $geometry = $feature['geometry'];
            
            // Hitung center point
            $center = $this->calculateCenter($geometry);
            
            KabupatenGeo::create([
                'kabupaten_name' => $properties['nm_dati2'],
                'kode_bps' => $properties['kd_propinsi'] . $properties['kd_dati2'],
                'geojson_data' => json_encode($geometry),
                'center_lat' => $center['lat'],
                'center_lng' => $center['lng'],
                'total_kecamatan' => 0, // Akan diupdate setelah import kecamatan
                'total_desa' => 0, // Akan diupdate setelah import desa
            ]);
        }
        
        $this->command->info('✅ Kabupaten diimport: ' . count($geojson['features']));
    }
    
    private function importKecamatan()
    {
        $filePath = public_path('geojson/kecamatan/kecamatan.geojson');
        
        if (!file_exists($filePath)) {
            $this->command->error('❌ File kecamatan.geojson tidak ditemukan!');
            return;
        }
        
        $geojson = json_decode(file_get_contents($filePath), true);
        
        // Cari kabupaten Bojonegoro
        $kabupaten = KabupatenGeo::where('kabupaten_name', 'like', '%Bojonegoro%')->first();
        
        if (!$kabupaten) {
            $this->command->error('❌ Kabupaten Bojonegoro tidak ditemukan di database!');
            return;
        }
        
        foreach ($geojson['features'] as $feature) {
            $properties = $feature['properties'];
            $geometry = $feature['geometry'];
            
            // Hitung center point
            $center = $this->calculateCenter($geometry);
            
            KecamatanGeo::create([
                'kabupaten_id' => $kabupaten->id,
                'kecamatan_name' => $properties['nm_kecamatan'],
                'kode_bps' => $properties['kd_propinsi'] . $properties['kd_dati2'] . $properties['kd_kecamatan'],
                'geojson_data' => json_encode($geometry),
                'center_lat' => $center['lat'],
                'center_lng' => $center['lng'],
                'total_desa' => 0, // Akan diupdate setelah import desa
            ]);
        }
        
        // Update total kecamatan di kabupaten
        $kabupaten->update(['total_kecamatan' => count($geojson['features'])]);
        
        $this->command->info('✅ Kecamatan diimport: ' . count($geojson['features']));
    }
    
    private function importDesa()
    {
        $filePath = public_path('geojson/desa/desa.geojson');
        
        if (!file_exists($filePath)) {
            $this->command->error('❌ File desa.geojson tidak ditemukan!');
            return;
        }
        
        $geojson = json_decode(file_get_contents($filePath), true);
        $kecamatanCache = [];
        
        foreach ($geojson['features'] as $feature) {
            $properties = $feature['properties'];
            $geometry = $feature['geometry'];
            
            // Cari kecamatan berdasarkan kode BPS
            $kodeKecamatan = $properties['kd_propinsi'] . $properties['kd_dati2'] . $properties['kd_kecamatan'];
            
            if (!isset($kecamatanCache[$kodeKecamatan])) {
                $kecamatanCache[$kodeKecamatan] = KecamatanGeo::where('kode_bps', $kodeKecamatan)->first();
            }
            
            $kecamatan = $kecamatanCache[$kodeKecamatan];
            
            if (!$kecamatan) {
                $this->command->warn('⚠️ Kecamatan tidak ditemukan: ' . $kodeKecamatan);
                continue;
            }
            
            // Hitung center point
            $center = $this->calculateCenter($geometry);
            
            DesaGeo::create([
                'kecamatan_id' => $kecamatan->id,
                'desa_name' => $properties['nm_kelurahan'],
                'kode_bps' => $properties['kd_propinsi'] . $properties['kd_dati2'] . $properties['kd_kecamatan'] . $properties['kd_kelurahan'],
                'geojson_data' => json_encode($geometry),
                'center_lat' => $center['lat'],
                'center_lng' => $center['lng'],
            ]);
        }
        
        // Update total desa di setiap kecamatan
        foreach ($kecamatanCache as $kecamatan) {
            if ($kecamatan) {
                $totalDesa = DesaGeo::where('kecamatan_id', $kecamatan->id)->count();
                $kecamatan->update(['total_desa' => $totalDesa]);
            }
        }
        
        // Update total desa di kabupaten
        $kabupaten = KabupatenGeo::first();
        if ($kabupaten) {
            $totalDesa = DesaGeo::whereHas('kecamatan', function ($query) use ($kabupaten) {
                $query->where('kabupaten_id', $kabupaten->id);
            })->count();
            $kabupaten->update(['total_desa' => $totalDesa]);
        }
        
        $this->command->info('✅ Desa diimport: ' . count($geojson['features']));
    }
    
    /**
     * Hitung titik tengah dari polygon
     */
    private function calculateCenter(array $geometry): array
    {
        if ($geometry['type'] === 'MultiPolygon') {
            // Ambil polygon pertama dari MultiPolygon
            $coordinates = $geometry['coordinates'][0][0];
        } else {
            $coordinates = $geometry['coordinates'][0];
        }
        
        $sumLat = 0;
        $sumLng = 0;
        $count = 0;
        
        // Iterasi setiap titik (skip titik terakhir karena sama dengan titik pertama)
        for ($i = 0; $i < count($coordinates) - 1; $i++) {
            $sumLng += $coordinates[$i][0];
            $sumLat += $coordinates[$i][1];
            $count++;
        }
        
        return [
            'lat' => $count > 0 ? $sumLat / $count : -7.150975,
            'lng' => $count > 0 ? $sumLng / $count : 111.881860
        ];
    }
}