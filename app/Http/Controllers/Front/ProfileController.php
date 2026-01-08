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
                'content' => 'Mewujudkan Bojonegoro yang Maju, Adil, dan Sejahtera melalui pembangunan berkelanjutan yang berpihak pada rakyat.'
            ],
            'misi' => [
                'title' => 'Misi',
                'items' => [
                    'Membangun tata kelola pemerintahan yang bersih, transparan, dan akuntabel.',
                    'Meningkatkan kualitas pendidikan dan kesehatan masyarakat.',
                    'Mengembangkan ekonomi kerakyatan dan membuka lapangan kerja.',
                    'Melestarikan budaya dan kearifan lokal Bojonegoro.',
                    'Menguatkan partisipasi masyarakat dalam pembangunan.',
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