@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div x-data="dashboard()" class="space-y-6">
    <!-- Welcome Header -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-800 via-slate-900 to-slate-800 p-6 sm:p-8">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-10"></div>
        <div class="relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">Selamat datang, {{ auth()->user()->name }}! 👋</h1>
                    <p class="mt-2 text-slate-300">Dashboard Admin Partai NasDem Kabupaten Bojonegoro</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-accent/20 text-accent-light border border-accent/30">
                            <i class="fas fa-user-shield mr-1.5"></i>{{ auth()->user()->roles->first()->name }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-700/50 text-slate-300 border border-slate-600/50">
                            <i class="fas fa-calendar-alt mr-1.5"></i>{{ now()->translatedFormat('l, d F Y') }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-700/50 text-slate-300 border border-slate-600/50">
                            <i class="fas fa-clock mr-1.5"></i>{{ now()->format('H:i') }}
                        </span>
                    </div>
                </div>
                <div class="mt-4 lg:mt-0">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}" target="_blank" 
                           class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm text-white rounded-lg border border-white/20 hover:bg-white/20 transition-all-300">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            Kunjungi Website
                        </a>
                        <button @click="showQuickStats = !showQuickStats" 
                                class="inline-flex items-center px-4 py-2 bg-accent text-white rounded-lg hover:bg-accent-light transition-all-300 shadow-lg">
                            <i class="fas fa-chart-line mr-2"></i>
                            Quick Stats
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Panel -->
    <div x-show="showQuickStats" x-transition 
         class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-slate-800">Statistik Cepat</h3>
            <button @click="showQuickStats = false" class="text-slate-400 hover:text-slate-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-slate-50 rounded-lg">
                <div class="text-2xl font-bold text-slate-800 mb-1">{{ $stats['total_kader'] }}</div>
                <div class="text-sm text-slate-600">Total Kader</div>
            </div>
            <div class="text-center p-4 bg-slate-50 rounded-lg">
                <div class="text-2xl font-bold text-slate-800 mb-1">{{ $stats['total_berita'] }}</div>
                <div class="text-sm text-slate-600">Total Berita</div>
            </div>
            <div class="text-center p-4 bg-slate-50 rounded-lg">
                <div class="text-2xl font-bold text-slate-800 mb-1">{{ $stats['total_dpc'] }}</div>
                <div class="text-sm text-slate-600">DPC Kecamatan</div>
            </div>
            <div class="text-center p-4 bg-slate-50 rounded-lg">
                <div class="text-2xl font-bold text-slate-800 mb-1">{{ $stats['total_users'] }}</div>
                <div class="text-sm text-slate-600">Pengguna</div>
            </div>
        </div>
    </div>

    <!-- Main Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Kader Card -->
        <div class="card-hover bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-slate-500 uppercase tracking-wide">Total Kader</h3>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ number_format($stats['total_kader']) }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center">
                        <i class="fas fa-users text-2xl text-blue-600"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-600">Aktif</span>
                        <span class="text-sm font-medium text-emerald-600">{{ $stats['active_kader'] }}</span>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-2">
                        <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ ($stats['active_kader'] / max($stats['total_kader'], 1)) * 100 }}%"></div>
                    </div>
                    <div class="flex items-center text-xs text-slate-500">
                        <i class="fas fa-history mr-1.5"></i>
                        <span>Update: {{ now()->format('H:i') }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-6 py-3 border-t border-slate-100">
                <a href="{{ route('admin.kader.index') }}" class="text-sm font-medium text-accent hover:text-accent-light flex items-center justify-between group">
                    <span>Lihat detail kader</span>
                    <i class="fas fa-arrow-right text-xs transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Berita Card -->
        <div class="card-hover bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-slate-500 uppercase tracking-wide">Total Berita</h3>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ number_format($stats['total_berita']) }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-50 flex items-center justify-center">
                        <i class="fas fa-newspaper text-2xl text-emerald-600"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="text-center p-2 bg-slate-50 rounded-lg">
                            <div class="text-lg font-bold text-slate-900">{{ $stats['published_berita'] }}</div>
                            <div class="text-xs text-slate-500">Published</div>
                        </div>
                        <div class="text-center p-2 bg-slate-50 rounded-lg">
                            <div class="text-lg font-bold text-slate-900">{{ $stats['total_berita'] - $stats['published_berita'] }}</div>
                            <div class="text-xs text-slate-500">Draft</div>
                        </div>
                    </div>
                    <div class="flex items-center text-xs text-slate-500">
                        <i class="fas fa-eye mr-1.5"></i>
                        <span>{{ $stats['total_views'] ?? 0 }} total views</span>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-6 py-3 border-t border-slate-100">
                <a href="{{ route('admin.berita.index') }}" class="text-sm font-medium text-accent hover:text-accent-light flex items-center justify-between group">
                    <span>Kelola berita</span>
                    <i class="fas fa-arrow-right text-xs transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- DPC Card -->
        <div class="card-hover bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-slate-500 uppercase tracking-wide">DPC Kecamatan</h3>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['total_dpc'] }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-violet-100 to-violet-50 flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-2xl text-violet-600"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-600">Terisi</span>
                        <span class="text-sm font-medium text-violet-600">{{ $stats['total_dpc'] }}/28</span>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-2">
                        <div class="bg-violet-500 h-2 rounded-full" style="width: {{ ($stats['total_dpc'] / 28) * 100 }}%"></div>
                    </div>
                    <div class="text-xs text-slate-500">
                        <i class="fas fa-info-circle mr-1.5"></i>
                        <span>Mencakup seluruh kecamatan</span>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-6 py-3 border-t border-slate-100">
                <a href="{{ route('admin.dpc.index') }}" class="text-sm font-medium text-accent hover:text-accent-light flex items-center justify-between group">
                    <span>Lihat DPC</span>
                    <i class="fas fa-arrow-right text-xs transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- System Card -->
        <div class="card-hover bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-slate-500 uppercase tracking-wide">Sistem</h3>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['total_users'] }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-100 to-amber-50 flex items-center justify-center">
                        <i class="fas fa-server text-2xl text-amber-600"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-600">Pengguna</span>
                        <span class="text-sm font-medium text-amber-600">{{ $stats['total_users'] }} aktif</span>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-2">
                        <div class="bg-amber-500 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                    <div class="flex items-center text-xs text-slate-500">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></div>
                        <span>Sistem berjalan normal</span>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-6 py-3 border-t border-slate-100">
                <div class="text-sm font-medium text-slate-600 flex items-center justify-between">
                    <span>Status: <span class="text-emerald-600">Normal</span></span>
                    <i class="fas fa-check-circle text-emerald-500"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quick Actions -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800">Aksi Cepat</h3>
                    <p class="text-sm text-slate-500 mt-1">Akses cepat ke fitur yang sering digunakan</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @can('create-berita')
                        <a href="{{ route('admin.berita.create') }}" 
                           class="group flex flex-col items-center p-5 bg-gradient-to-br from-emerald-50 to-white border border-emerald-100 rounded-xl hover:border-emerald-300 hover:shadow-lg transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-plus text-white text-lg"></i>
                            </div>
                            <h4 class="font-bold text-slate-800 text-center">Tambah Berita</h4>
                            <p class="text-xs text-slate-500 text-center mt-1">Buat berita baru</p>
                        </a>
                        @endcan
                        
                        @can('create-kader')
                        <a href="{{ route('admin.kader.create') }}" 
                           class="group flex flex-col items-center p-5 bg-gradient-to-br from-blue-50 to-white border border-blue-100 rounded-xl hover:border-blue-300 hover:shadow-lg transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-user-plus text-white text-lg"></i>
                            </div>
                            <h4 class="font-bold text-slate-800 text-center">Tambah Kader</h4>
                            <p class="text-xs text-slate-500 text-center mt-1">Daftarkan kader baru</p>
                        </a>
                        @endcan
                        
                        @can('create-dpc')
                        <a href="{{ route('admin.dpc.create') }}" 
                           class="group flex flex-col items-center p-5 bg-gradient-to-br from-violet-50 to-white border border-violet-100 rounded-xl hover:border-violet-300 hover:shadow-lg transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-500 to-violet-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-map-marker-alt text-white text-lg"></i>
                            </div>
                            <h4 class="font-bold text-slate-800 text-center">Tambah DPC</h4>
                            <p class="text-xs text-slate-500 text-center mt-1">Buat DPC baru</p>
                        </a>
                        @endcan
                        
                        <a href="{{ route('admin.gis.index') }}" 
                           class="group flex flex-col items-center p-5 bg-gradient-to-br from-slate-50 to-white border border-slate-100 rounded-xl hover:border-slate-300 hover:shadow-lg transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-600 to-slate-700 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-map text-white text-lg"></i>
                            </div>
                            <h4 class="font-bold text-slate-800 text-center">GIS Mapping</h4>
                            <p class="text-xs text-slate-500 text-center mt-1">Lihat peta distribusi</p>
                        </a>
                        
                        <a href="{{ route('admin.berita.categories.index') }}" 
                           class="group flex flex-col items-center p-5 bg-gradient-to-br from-amber-50 to-white border border-amber-100 rounded-xl hover:border-amber-300 hover:shadow-lg transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-tags text-white text-lg"></i>
                            </div>
                            <h4 class="font-bold text-slate-800 text-center">Kategori</h4>
                            <p class="text-xs text-slate-500 text-center mt-1">Kelola kategori berita</p>
                        </a>
                        
                        <a href="#" 
                           class="group flex flex-col items-center p-5 bg-gradient-to-br from-rose-50 to-white border border-rose-100 rounded-xl hover:border-rose-300 hover:shadow-lg transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-rose-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-chart-bar text-white text-lg"></i>
                            </div>
                            <h4 class="font-bold text-slate-800 text-center">Laporan</h4>
                            <p class="text-xs text-slate-500 text-center mt-1">Lihat statistik lengkap</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 h-full">
                <div class="px-6 py-4 border-b border-slate-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-slate-800">Aktivitas Terbaru</h3>
                        <span class="text-xs text-slate-500">Hari ini</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($recentActivities as $activity)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-0.5">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $activity['color'] }}">
                                    <i class="{{ $activity['icon'] }} text-white text-xs"></i>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm text-slate-800">{{ $activity['message'] }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="pt-4 border-t border-slate-100 text-center">
                            <a href="#" class="text-sm font-medium text-accent hover:text-accent-light inline-flex items-center">
                                Lihat semua aktivitas
                                <i class="fas fa-arrow-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Data Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Kaders -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Kader Terbaru</h3>
                    <p class="text-sm text-slate-500">{{ $recentKaders->count() }} kader baru</p>
                </div>
                <a href="{{ route('admin.kader.index') }}" class="text-sm font-medium text-accent hover:text-accent-light">
                    Lihat semua
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kecamatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Bergabung</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentKaders as $kader)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-slate-600 to-slate-700 flex items-center justify-center text-white text-sm font-bold mr-3">
                                        {{ substr($kader->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900">{{ $kader->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $kader->nik }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-900">{{ $kader->kecamatan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($kader->is_verified)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <i class="fas fa-check-circle mr-1"></i>Verified
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $kader->join_date->format('d/m/Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent News -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Berita Terbaru</h3>
                    <p class="text-sm text-slate-500">{{ $recentNews->count() }} berita baru</p>
                </div>
                <a href="{{ route('admin.berita.index') }}" class="text-sm font-medium text-accent hover:text-accent-light">
                    Lihat semua
                </a>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($recentNews as $berita)
                <div class="px-6 py-4 hover:bg-slate-50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-slate-900 line-clamp-1">{{ $berita->title }}</h4>
                            <div class="flex items-center mt-2 space-x-4">
                                <span class="inline-flex items-center text-xs text-slate-500">
                                    <i class="fas fa-tag mr-1.5"></i>{{ $berita->category->name }}
                                </span>
                                <span class="inline-flex items-center text-xs text-slate-500">
                                    <i class="fas fa-calendar mr-1.5"></i>{{ $berita->created_at->format('d/m/Y') }}
                                </span>
                                <span class="inline-flex items-center text-xs text-slate-500">
                                    <i class="fas fa-eye mr-1.5"></i>{{ $berita->views }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-4 flex flex-col items-end space-y-1">
                            @if($berita->status == 'published')
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-800">
                                Published
                            </span>
                            @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800">
                                Draft
                            </span>
                            @endif
                            
                            @if($berita->is_featured)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                                <i class="fas fa-star mr-0.5 text-xs"></i>Featured
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Informasi Sistem</h3>
                <p class="text-sm text-slate-500 mt-1">Status dan performa sistem saat ini</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></div>
                    Semua Sistem Normal
                </span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 bg-slate-50 rounded-xl">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-slate-600 to-slate-700 flex items-center justify-center mr-3">
                        <i class="fas fa-database text-white"></i>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-600">Database</div>
                        <div class="text-lg font-bold text-slate-900">Online</div>
                    </div>
                </div>
                <div class="text-xs text-slate-500">Last sync: 2 minutes ago</div>
            </div>
            
            <div class="p-4 bg-slate-50 rounded-xl">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center mr-3">
                        <i class="fas fa-server text-white"></i>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-600">Server Uptime</div>
                        <div class="text-lg font-bold text-slate-900">99.9%</div>
                    </div>
                </div>
                <div class="text-xs text-slate-500">Up for 30 days</div>
            </div>
            
            <div class="p-4 bg-slate-50 rounded-xl">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-emerald-600 to-emerald-700 flex items-center justify-center mr-3">
                        <i class="fas fa-shield-alt text-white"></i>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-600">Security</div>
                        <div class="text-lg font-bold text-slate-900">Protected</div>
                    </div>
                </div>
                <div class="text-xs text-slate-500">SSL Active, Firewall On</div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function dashboard() {
    return {
        showQuickStats: false,
        recentActivities: [
            {
                icon: 'fas fa-user-plus',
                color: 'bg-blue-500',
                message: 'Kader baru "Budi Santoso" terdaftar',
                time: '5 menit yang lalu'
            },
            {
                icon: 'fas fa-newspaper',
                color: 'bg-emerald-500',
                message: 'Berita "Rapat Koordinasi DPC" dipublikasikan',
                time: '1 jam yang lalu'
            },
            {
                icon: 'fas fa-map-marker-alt',
                color: 'bg-violet-500',
                message: 'Lokasi DPC Baureno diperbarui',
                time: '3 jam yang lalu'
            },
            {
                icon: 'fas fa-users',
                color: 'bg-amber-500',
                message: '3 kader berhasil diverifikasi',
                time: '5 jam yang lalu'
            }
        ],
        
        init() {
            // Auto hide quick stats after 5 seconds
            setTimeout(() => {
                this.showQuickStats = false;
            }, 5000);
            
            // Simulate real-time updates
            setInterval(() => {
                // This would typically fetch from API
                console.log('Dashboard data refreshed');
            }, 30000);
        },
        
        refreshStats() {
            // Show loading state
            const loader = document.getElementById('global-loader');
            if (loader) loader.classList.remove('hidden');
            
            // Simulate API call
            setTimeout(() => {
                if (loader) loader.classList.add('hidden');
                showNotification('success', 'Dashboard data refreshed successfully');
            }, 1000);
        }
    }
}
</script>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@keyframes fade-in-right {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.animate-fade-in-right {
    animation: fade-in-right 0.3s ease-out;
}

@keyframes fade-in-down {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-down {
    animation: fade-in-down 0.3s ease-out;
}

/* Custom checkbox for modern look */
.custom-checkbox {
    appearance: none;
    width: 18px;
    height: 18px;
    border: 2px solid #cbd5e1;
    border-radius: 4px;
    cursor: pointer;
    position: relative;
    transition: all 0.2s;
}

.custom-checkbox:checked {
    background-color: #0ea5e9;
    border-color: #0ea5e9;
}

.custom-checkbox:checked::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 12px;
    font-weight: bold;
}
</style>
@endpush
@endsection