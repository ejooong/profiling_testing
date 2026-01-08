<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita\Berita;
use App\Models\User;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $categories = \App\Models\Berita\BeritaCategory::all();
        $dpcs = \App\Models\DPC\Dpc::all();
        
        $beritaTitles = [
            'Pelantikan Pengurus DPC Kecamatan Ngasem',
            'Rapat Koordinasi Kader Se-Kabupaten Bojonegoro',
            'Bakti Sosial di Desa Margomulyo',
            'Pelatihan Kader Muda Tingkat Kabupaten',
            'Kunjungan Kerja ke Desa Tertinggal',
            'Musyawarah Rencana Kerja Tahunan 2024',
            'Penandatanganan MoU dengan Universitas Bojonegoro',
            'Turnamen Sepak Bola Antar DPC Se-Kabupaten',
            'Webinar Nasional "Masa Depan Politik Indonesia"',
            'Peringatan Hari Santri di Kantor DPC',
            'Sosialisasi Program Pemerintah di Kecamatan Kapas',
            'Bimbingan Teknis Pengelolaan Dana Desa',
            'Peringatan Hari Lahir Pancasila',
            'Kunjungan Kerja Anggota DPRD Provinsi',
            'Workshop Digital Marketing untuk UMKM',
            'Penghijauan Lingkungan di Kecamatan Dander',
            'Santunan Anak Yatim dan Dhuafa',
            'Dialog Publik "Membangun Bojonegoro Maju"',
            'Pelatihan Kepemimpinan untuk Kader Perempuan',
            'Festival Budaya Bojonegoro 2024',
        ];
        
        foreach ($beritaTitles as $index => $title) {
            $status = $index < 15 ? 'published' : ($index < 18 ? 'draft' : 'published');
            
            Berita::create([
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
                'dpc_id' => $dpcs->random()->id,
                'title' => $title,
                'slug' => \Illuminate\Support\Str::slug($title) . '-' . ($index + 1),
                'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.',
                'content' => $this->generateContent($title),
                'views' => rand(100, 5000),
                'status' => $status,
                'published_at' => $status == 'published' ? now()->subDays(rand(1, 60)) : null,
                'is_featured' => $index < 5,
                'is_headline' => $index < 3,
                'meta_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'meta_keywords' => ['nasdem', 'bojonegoro', 'politik', 'kader', 'pembangunan'],
            ]);
        }
    }
    
    private function generateContent($title): string
    {
        return '<h2>Tentang Kegiatan</h2>
                <p>Kegiatan ' . $title . ' berlangsung dengan sukses dan dihadiri oleh ratusan peserta dari berbagai kalangan. Acara ini merupakan bagian dari komitmen Partai NasDem Bojonegoro dalam membangun daerah yang lebih baik.</p>
                
                <h3>Pelaksanaan Kegiatan</h3>
                <p>Kegiatan dilaksanakan di lokasi yang strategis dengan protokol kesehatan yang ketat. Para peserta sangat antusias mengikuti seluruh rangkaian acara dari awal hingga akhir.</p>
                
                <h3>Peserta Kegiatan</h3>
                <ul>
                    <li>Kader Partai NasDem</li>
                    <li>Masyarakat Umum</li>
                    <li>Perangkat Desa</li>
                    <li>Tokoh Masyarakat</li>
                    <li>Perwakilan Instansi Pemerintah</li>
                </ul>
                
                <h3>Hasil yang Dicapai</h3>
                <p>Kegiatan ini menghasilkan beberapa kesepakatan penting untuk pengembangan daerah ke depan. Semua peserta berkomitmen untuk melanjutkan kerjasama yang telah dibangun.</p>
                
                <blockquote>
                    "Kegiatan ini merupakan bukti nyata komitmen Partai NasDem dalam membangun Bojonegoro yang lebih baik untuk semua lapisan masyarakat."
                </blockquote>
                
                <p>Kami berharap kegiatan serupa dapat terus dilaksanakan secara berkala untuk semakin memperkuat sinergi antara partai politik dan masyarakat.</p>';
    }
}