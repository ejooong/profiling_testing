<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Berita\Berita;
use App\Models\DPC\Dpc;
use App\Models\Kader\Kader;
use App\Models\DPRT\Dprt;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil berita headline
        $headlineNews = Berita::published()
            ->headline()
            ->latest('published_at')
            ->take(3)
            ->get();
        
        // Ambil berita terbaru
        $latestNews = Berita::published()
            ->latest('published_at')
            ->take(6)
            ->get();
        
        // Ambil statistik
        $stats = [
            'total_kader' => Kader::active()->verified()->count(),
            'total_dpc' => Dpc::where('is_active', true)->count(),
            'total_dprt' => Dprt::where('is_active', true)->count(),
        ];
        
        return view('front.index', compact('headlineNews', 'latestNews', 'stats'));
    }
}