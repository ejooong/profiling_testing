<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita\Berita;
use App\Models\DPC\Dpc;
use App\Models\Kader\Kader;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'total_kader' => Kader::count(),
            'active_kader' => Kader::active()->count(),
            'total_berita' => Berita::count(),
            'published_berita' => Berita::published()->count(),
            'total_dpc' => Dpc::count(),
            'total_users' => User::count(),
            'total_views' => Berita::sum('views'),
        ];
        
        // Recent data
        $recentKaders = Kader::latest()
            ->take(5)
            ->get();
        
        $recentNews = Berita::latest()
            ->take(5)
            ->get();
        
        // Recent activities for timeline
        $recentActivities = [
            [
                'icon' => 'fas fa-user-plus',
                'color' => 'bg-blue-500',
                'message' => 'Kader baru "Budi Santoso" terdaftar',
                'time' => now()->subMinutes(5)->diffForHumans()
            ],
            [
                'icon' => 'fas fa-newspaper',
                'color' => 'bg-emerald-500',
                'message' => 'Berita "Rapat Koordinasi DPC" dipublikasikan',
                'time' => now()->subMinutes(30)->diffForHumans()
            ],
            [
                'icon' => 'fas fa-map-marker-alt',
                'color' => 'bg-violet-500',
                'message' => 'Lokasi DPC Baureno diperbarui',
                'time' => now()->subHours(3)->diffForHumans()
            ],
            [
                'icon' => 'fas fa-users',
                'color' => 'bg-amber-500',
                'message' => '3 kader berhasil diverifikasi',
                'time' => now()->subHours(5)->diffForHumans()
            ],
            [
                'icon' => 'fas fa-tags',
                'color' => 'bg-rose-500',
                'message' => 'Kategori berita "Politik" ditambahkan',
                'time' => now()->subDays(1)->diffForHumans()
            ],
            [
                'icon' => 'fas fa-chart-line',
                'color' => 'bg-indigo-500',
                'message' => 'Statistik pertumbuhan kader meningkat 15%',
                'time' => now()->subDays(2)->diffForHumans()
            ]
        ];
        
        return view('admin.dashboard', compact('stats', 'recentKaders', 'recentNews', 'recentActivities'));
    }
}