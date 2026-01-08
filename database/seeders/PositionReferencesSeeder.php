<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PositionReference;
use Illuminate\Support\Facades\DB;

class PositionReferencesSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            // DPD Pimpinan
            ['code' => 'DPD-KETUA', 'name' => 'Ketua DPD', 'organization_level' => 'dpd', 'category' => 'pimpinan', 'is_required' => true, 'order' => 1],
            ['code' => 'DPD-SEKRETARIS', 'name' => 'Sekretaris DPD', 'organization_level' => 'dpd', 'category' => 'sekretariat', 'is_required' => true, 'order' => 2],
            ['code' => 'DPD-BENDAHARA', 'name' => 'Bendahara DPD', 'organization_level' => 'dpd', 'category' => 'bendahara', 'is_required' => true, 'order' => 3],

            // DPD Bidang (Wakil Ketua)
            ['code' => 'DPD-WAKET-PEMILU', 'name' => 'Wakil Ketua Bidang Pemenangan Pemilu', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 10],
            ['code' => 'DPD-WAKET-ORGANISASI', 'name' => 'Wakil Ketua Bidang Organisasi dan Keanggotaan', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 11],
            ['code' => 'DPD-WAKET-KADER', 'name' => 'Wakil Ketua Bidang Kaderisasi dan Pendidikan Politik', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 12],
            ['code' => 'DPD-WAKET-LEGISLATIF', 'name' => 'Wakil Ketua Bidang Hubungan Legislatif', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 13],
            ['code' => 'DPD-WAKET-EKSEKUTIF', 'name' => 'Wakil Ketua Bidang Hubungan Eksekutif', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 14],
            ['code' => 'DPD-WAKET-SAYAP', 'name' => 'Wakil Ketua Bidang Hubungan Sayap dan Badan', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 15],
            ['code' => 'DPD-WAKET-KOMUNITAS', 'name' => 'Wakil Ketua Bidang Penggalangan dan Penggerak Komunitas', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 16],
            ['code' => 'DPD-WAKET-MILENIAL', 'name' => 'Wakil Ketua Bidang Pemilih Pemula dan Milenial', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 17],
            ['code' => 'DPD-WAKET-DIGITAL', 'name' => 'Wakil Ketua Bidang Digital dan Siber', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 18],
            ['code' => 'DPD-WAKET-MEDIA', 'name' => 'Wakil Ketua Bidang Media dan Komunikasi Publik', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 19],

            // DPD Wakil Sekretaris
            ['code' => 'DPD-WAKIL-SEKRETARIS-PUBLIK', 'name' => 'Wakil Sekretaris Bidang Kebijakan Publik dan Isu Strategis', 'organization_level' => 'dpd', 'category' => 'sekretariat', 'order' => 20],
            ['code' => 'DPD-WAKIL-SEKRETARIS-IDEOLOGI', 'name' => 'Wakil Sekretaris Bidang Ideologi, Organisasi dan Kaderisasi', 'organization_level' => 'dpd', 'category' => 'sekretariat', 'order' => 21],
            ['code' => 'DPD-WAKIL-SEKRETARIS-PEMILU', 'name' => 'Wakil Sekretaris Bidang Pemenangan Pemilu', 'organization_level' => 'dpd', 'category' => 'sekretariat', 'order' => 22],
            ['code' => 'DPD-WAKIL-SEKRETARIS-UMUM', 'name' => 'Wakil Sekretaris Bidang Umum dan Administrasi', 'organization_level' => 'dpd', 'category' => 'sekretariat', 'order' => 23],

            // DPD Wakil Bendahara
            ['code' => 'DPD-WAKIL-BENDAHARA-DANA', 'name' => 'Wakil Bendahara Pengelolaan Dana dan Aset', 'organization_level' => 'dpd', 'category' => 'bendahara', 'order' => 30],
            ['code' => 'DPD-WAKIL-BENDAHARA-PENGALANGAN', 'name' => 'Wakil Bendahara Penggalangan Dana', 'organization_level' => 'dpd', 'category' => 'bendahara', 'order' => 31],

            // DPD Bidang Tambahan
            ['code' => 'DPD-BID-EKONOMI', 'name' => 'Wakil Ketua Bidang Ekonomi', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 40],
            ['code' => 'DPD-BID-UMKM', 'name' => 'Wakil Ketua Bidang Usaha Mikro Kecil dan Menengah', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 41],
            ['code' => 'DPD-BID-AGAMA', 'name' => 'Wakil Ketua Bidang Agama dan Masyarakat Adat', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 42],
            ['code' => 'DPD-BID-TENAGAKERJA', 'name' => 'Wakil Ketua Bidang Tenaga Kerja', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 43],
            ['code' => 'DPD-BID-KESEHATAN', 'name' => 'Wakil Ketua Bidang Kesehatan', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 44],
            ['code' => 'DPD-BID-PEREMPUAN', 'name' => 'Wakil Ketua Bidang Perempuan dan Anak', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 45],
            ['code' => 'DPD-BID-PENDIDIKAN', 'name' => 'Wakil Ketua Bidang Pendidikan dan Kebudayaan', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 46],
            ['code' => 'DPD-BID-HUKUM', 'name' => 'Wakil Ketua Bidang Hukum dan Hak Asasi Manusia', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 47],
            ['code' => 'DPD-BID-PARIWISATA', 'name' => 'Wakil Ketua Bidang Pariwisata dan Industri Kreatif', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 48],
            ['code' => 'DPD-BID-PERTANIAN', 'name' => 'Wakil Ketua Bidang Pertanian, Peternakan dan Kemandirian Desa', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 49],
            ['code' => 'DPD-BID-MARITIM', 'name' => 'Wakil Ketua Bidang Maritim', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 50],
            ['code' => 'DPD-BID-PEMUDA', 'name' => 'Wakil Ketua Bidang Pemuda dan Olahraga', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 51],
            ['code' => 'DPD-BID-ENERGI', 'name' => 'Wakil Ketua Bidang Energi dan Mineral', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 52],
            ['code' => 'DPD-BID-LINGKUNGAN', 'name' => 'Wakil Ketua Bidang Lingkungan Hidup', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 53],
            ['code' => 'DPD-BID-KEHUTANAN', 'name' => 'Wakil Ketua Bidang Kehutanan, Agraria dan Tata Ruang', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 54],
            ['code' => 'DPD-BID-MIGRAN', 'name' => 'Wakil Ketua Bidang Migran', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 55],
            ['code' => 'DPD-BID-INFRASTRUKTUR', 'name' => 'Wakil Ketua Bidang Pembangunan dan Infrastruktur', 'organization_level' => 'dpd', 'category' => 'bidang', 'order' => 56],

            // DPC Struktur Minimal
            ['code' => 'DPC-KETUA', 'name' => 'Ketua DPC', 'organization_level' => 'dpc', 'category' => 'pimpinan', 'is_required' => true, 'order' => 100],
            ['code' => 'DPC-SEKRETARIS', 'name' => 'Sekretaris DPC', 'organization_level' => 'dpc', 'category' => 'sekretariat', 'is_required' => true, 'order' => 101],
            ['code' => 'DPC-BENDAHARA', 'name' => 'Bendahara DPC', 'organization_level' => 'dpc', 'category' => 'bendahara', 'is_required' => true, 'order' => 102],
            ['code' => 'DPC-WAKIL-SEKRETARIS', 'name' => 'Wakil Sekretaris DPC', 'organization_level' => 'dpc', 'category' => 'sekretariat', 'order' => 103],
            ['code' => 'DPC-WAKIL-BENDAHARA', 'name' => 'Wakil Bendahara DPC', 'organization_level' => 'dpc', 'category' => 'bendahara', 'order' => 104],
            ['code' => 'DPC-WAKET-PEMILU', 'name' => 'Wakil Ketua Bidang Pemilihan Umum', 'organization_level' => 'dpc', 'category' => 'bidang', 'order' => 105],
            ['code' => 'DPC-WAKET-ORGANISASI', 'name' => 'Wakil Ketua Bidang Organisasi dan Keanggotaan', 'organization_level' => 'dpc', 'category' => 'bidang', 'order' => 106],

            // DPRT Struktur Minimal
            ['code' => 'DPRT-KETUA', 'name' => 'Ketua DPRT', 'organization_level' => 'dprt', 'category' => 'pimpinan', 'is_required' => true, 'order' => 200],
            ['code' => 'DPRT-SEKRETARIS', 'name' => 'Sekretaris DPRT', 'organization_level' => 'dprt', 'category' => 'sekretariat', 'is_required' => true, 'order' => 201],
            ['code' => 'DPRT-BENDAHARA', 'name' => 'Bendahara DPRT', 'organization_level' => 'dprt', 'category' => 'bendahara', 'is_required' => true, 'order' => 202],

            // Anggota
            ['code' => 'ANGGOTA', 'name' => 'Anggota', 'organization_level' => 'all', 'category' => 'anggota', 'order' => 1000],
        ];

        foreach ($positions as $position) {
            PositionReference::create($position);
        }

        $this->command->info('Position references seeded successfully!');
    }
}
