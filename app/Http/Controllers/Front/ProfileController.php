<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\DPD\Dpd;

class ProfileController extends Controller
{
    public function index()
    {
        $dpd = Dpd::first();

        $visiMisi = [
            'visi' => [
                'title' => 'Visi',
                'content' => 'Visi Partai NasDem adalah mewujudkan Indonesia yang merdeka sebagai negara bangsa, berdaulat secara ekonomi, dan bermartabat dalam budaya.
Merdeka dimaknai sebagai kebebasan rakyat dari penindasan sekaligus kebebasan untuk berpendapat dan berpartisipasi secara adil. Kedaulatan ekonomi berarti keberpihakan pada penghapusan kemiskinan dan kesenjangan, bukan hanya kemajuan segelintir pihak. Martabat budaya menegaskan pentingnya menjaga, mengelola, dan membanggakan kekayaan budaya bangsa di tengah arus globalisasi.
Visi ini menjadi landasan utama seluruh kebijakan dan kerja politik Partai NasDem, baik di pemerintahan, legislatif, maupun masyarakat.'
            ],
            'misi' => [
                'title' => 'Misi',
                'items' => [
                    'Untuk mewujudkan visi Partai NasDem, ditetapkan misi sebagai langkah nyata yang menjadi panduan gerak seluruh struktur partai.',
                    '(1) sistem politik yang demokratis dan berkeadilan,
(2) sistem ekonomi yang demokratis, dan
(3) gotong royong sebagai budaya bangsa.',
                    'Dalam misi politik demokratis dan berkeadilan, terdapat empat persoalan utama: oligarki, politik uang, KKN, dan menurunnya kepercayaan publik terhadap partai politik.',
                    'Setiap tingkatan struktur memiliki peran berbeda: DPP berfokus pada peningkatan pengenalan partai, DPW dan DPD pada peningkatan kesukaan publik, serta DPC dan DPRt pada penguatan pilihan politik masyarakat.',
                    'Melalui lembar kerja kader, setiap struktur diarahkan untuk merancang aksi yang konkret, terukur, dan saling terhubung agar misi partai dapat diwujudkan secara efektif dari pusat hingga akar rumput.',
                ]
            ],
            'sejarah' => [
                'title' => 'Sejarah',
                'content' => 'Partai NasDem Kabupaten Bojonegoro didirikan pada tahun 2012 dengan semangat membawa perubahan dan pembangunan yang merata di seluruh wilayah kabupaten. Sejak berdiri, partai ini telah berkomitmen untuk mengabdi kepada masyarakat Bojonegoro melalui berbagai program dan kegiatan.'
            ],
            'program' => [
                'title' => 'Program Kerja',
                'items' => [
                    'Pendampingan UMKM dan ekonomi kreatif.',
                    'Program beasiswa untuk anak-anak kurang mampu.',
                    'Bakti sosial kesehatan dan sembako.',
                    'Pelatihan kader dan kepemimpinan.',
                    'Advokasi kebijakan publik yang pro-rakyat.',
                ]
            ]
        ];

        return view('front.profile', compact('dpd', 'visiMisi'));
    }
}
