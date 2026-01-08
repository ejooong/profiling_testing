@extends('layouts.admin')

@section('title', 'Struktur DPD: ' . $dpd->name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-600 to-slate-700 flex items-center justify-center shadow-lg">
                    <i class="fas fa-sitemap text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Struktur Organisasi DPD</h1>
                    <div class="flex items-center text-sm text-slate-500 mt-1">
                        <i class="fas fa-building mr-2 text-xs"></i>
                        <span>{{ $dpd->name }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.dpd.index') }}" 
               class="inline-flex items-center px-4 py-2.5 bg-white text-slate-700 rounded-lg border border-slate-200 hover:bg-slate-50 hover:border-slate-300 transition-all-300 shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <a href="{{ route('admin.dpd.structure.edit', $dpd) }}" 
               class="inline-flex items-center px-4 py-2.5 bg-gradient-to-br from-accent to-accent-light text-white rounded-lg hover:shadow-lg transition-all-300 shadow-md">
                <i class="fas fa-edit mr-2"></i>Edit Struktur
            </a>
            <button onclick="window.print()" 
                    class="inline-flex items-center px-4 py-2.5 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition-all-300 shadow-sm">
                <i class="fas fa-print mr-2"></i>Cetak
            </button>
        </div>
    </div>

    <!-- Period Badge -->
    <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-slate-100 to-slate-50 border border-slate-200 rounded-xl shadow-sm">
        <i class="fas fa-calendar-alt text-slate-500 mr-3"></i>
        <div>
            <div class="text-sm font-medium text-slate-600">Periode Kepengurusan</div>
            <div class="text-lg font-bold text-slate-800">{{ $structure->periode_mulai }} - {{ $structure->periode_selesai }}</div>
        </div>
    </div>

    <!-- Main Structure Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden card-hover">
        <!-- Card Header -->
        <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-accent to-accent-light flex items-center justify-center mr-3 shadow-md">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Struktur Kepengurusan</h2>
                        <p class="text-sm text-slate-500">Pimpinan dan departemen {{ $dpd->name }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-xs font-medium text-emerald-600">Aktif</span>
                </div>
            </div>
        </div>

        <!-- Main Leadership -->
        <div class="p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                <i class="fas fa-star text-amber-500 mr-3"></i>
                Pimpinan Utama
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Ketua -->
                <div class="group text-center p-6 bg-gradient-to-b from-white to-slate-50 rounded-xl border border-slate-100 hover:border-accent/30 hover:shadow-lg transition-all-300">
                    <div class="relative mx-auto mb-4">
                        @if($structure->ketua_photo)
                        <img src="{{ asset('storage/' . $structure->ketua_photo) }}" 
                             alt="{{ $structure->ketua }}" 
                             class="w-32 h-32 object-cover rounded-full mx-auto border-4 border-white shadow-lg">
                        @else
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center mx-auto shadow-lg">
                            <i class="fas fa-crown text-white text-3xl"></i>
                        </div>
                        @endif
                        <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200 shadow-sm">
                                <i class="fas fa-crown mr-1.5"></i>Ketua
                            </span>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mt-6">{{ $structure->ketua }}</h4>
                    <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm bg-slate-100 text-slate-700">
                        <i class="fas fa-user-tie mr-2 text-sm"></i>Pimpinan Tertinggi
                    </div>
                </div>

                <!-- Sekretaris -->
                <div class="group text-center p-6 bg-gradient-to-b from-white to-slate-50 rounded-xl border border-slate-100 hover:border-accent/30 hover:shadow-lg transition-all-300">
                    <div class="relative mx-auto mb-4">
                        @if($structure->sekretaris_photo)
                        <img src="{{ asset('storage/' . $structure->sekretaris_photo) }}" 
                             alt="{{ $structure->sekretaris }}" 
                             class="w-32 h-32 object-cover rounded-full mx-auto border-4 border-white shadow-lg">
                        @else
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mx-auto shadow-lg">
                            <i class="fas fa-file-alt text-white text-3xl"></i>
                        </div>
                        @endif
                        <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200 shadow-sm">
                                <i class="fas fa-file-alt mr-1.5"></i>Sekretaris
                            </span>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mt-6">{{ $structure->sekretaris }}</h4>
                    <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm bg-slate-100 text-slate-700">
                        <i class="fas fa-tasks mr-2 text-sm"></i>Administrasi & Koordinasi
                    </div>
                </div>

                <!-- Bendahara -->
                <div class="group text-center p-6 bg-gradient-to-b from-white to-slate-50 rounded-xl border border-slate-100 hover:border-accent/30 hover:shadow-lg transition-all-300">
                    <div class="relative mx-auto mb-4">
                        @if($structure->bendahara_photo)
                        <img src="{{ asset('storage/' . $structure->bendahara_photo) }}" 
                             alt="{{ $structure->bendahara }}" 
                             class="w-32 h-32 object-cover rounded-full mx-auto border-4 border-white shadow-lg">
                        @else
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center mx-auto shadow-lg">
                            <i class="fas fa-money-bill-alt text-white text-3xl"></i>
                        </div>
                        @endif
                        <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-sm">
                                <i class="fas fa-money-bill-alt mr-1.5"></i>Bendahara
                            </span>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mt-6">{{ $structure->bendahara }}</h4>
                    <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm bg-slate-100 text-slate-700">
                        <i class="fas fa-chart-pie mr-2 text-sm"></i>Keuangan & Dana
                    </div>
                </div>
            </div>
        </div>

        <!-- Departments Section -->
        @if($structure->departemen && count($structure->departemen) > 0)
        <div class="px-6 py-6 border-t border-slate-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-800 flex items-center">
                    <i class="fas fa-network-wired text-accent mr-3"></i>
                    Departemen
                </h3>
                <span class="text-sm font-medium text-slate-600">
                    {{ count($structure->departemen) }} departemen aktif
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($structure->departemen as $key => $dept)
                <div class="group bg-gradient-to-b from-white to-slate-50 border border-slate-100 rounded-xl p-5 hover:border-accent/30 hover:shadow-lg transition-all-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-slate-600 to-slate-700 flex items-center justify-center mr-3 shadow-sm">
                                    <i class="fas fa-briefcase text-white text-sm"></i>
                                </div>
                                <h4 class="text-lg font-bold text-slate-800">{{ $dept['name'] }}</h4>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                            {{ $dept['members'] }} orang
                        </span>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center p-3 bg-slate-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-user-tie text-blue-600 text-sm"></i>
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-xs text-slate-500">Koordinator</div>
                                <div class="text-sm font-medium text-slate-800">{{ $dept['coordinator'] }}</div>
                            </div>
                        </div>
                        
                        @if($dept['description'])
                        <div class="p-3 bg-gradient-to-r from-accent/5 to-transparent border border-accent/10 rounded-lg">
                            <div class="text-xs font-medium text-slate-500 mb-1">Tugas Utama</div>
                            <p class="text-sm text-slate-700">{{ $dept['description'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Committees Section -->
        @if($structure->panitia && count($structure->panitia) > 0)
        <div class="px-6 py-6 border-t border-slate-100 bg-gradient-to-b from-slate-50/50 to-transparent">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                <i class="fas fa-clipboard-list text-amber-500 mr-3"></i>
                Panitia Khusus
            </h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($structure->panitia as $key => $com)
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm hover:shadow-lg transition-all-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center mr-3 shadow-sm">
                                <i class="fas fa-clipboard-check text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">{{ $com['name'] }}</h4>
                                <div class="flex items-center mt-1">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></div>
                                    <span class="text-xs text-slate-500">Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="p-3 bg-amber-50 rounded-lg border border-amber-100">
                            <div class="text-xs font-medium text-amber-700 mb-1 flex items-center">
                                <i class="fas fa-bullseye mr-2"></i>Tugas Pokok
                            </div>
                            <p class="text-sm text-amber-800">{{ $com['task'] }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 bg-slate-50 rounded-lg">
                                <div class="text-xs text-slate-500 mb-1">Ketua</div>
                                <div class="text-sm font-medium text-slate-800">{{ $com['chairman'] }}</div>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-lg">
                                <div class="text-xs text-slate-500 mb-1">Jumlah Anggota</div>
                                <div class="text-sm font-medium text-slate-800">{{ substr_count($com['members_list'], ',') + 1 }} orang</div>
                            </div>
                        </div>
                        
                        @if($com['members_list'])
                        <div class="p-3 bg-slate-50 rounded-lg">
                            <div class="text-xs font-medium text-slate-600 mb-2">Daftar Anggota</div>
                            <p class="text-sm text-slate-700 leading-relaxed">{{ $com['members_list'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Vision & Mission -->
        <div class="px-6 py-6 border-t border-slate-100">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Vision -->
                <div class="p-5 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-2xl border border-blue-200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center mr-4 shadow-lg">
                            <i class="fas fa-eye text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-800">Visi</h4>
                            <div class="text-xs text-blue-600 font-medium">Arah dan Tujuan</div>
                        </div>
                    </div>
                    <div class="pl-16">
                        <div class="relative">
                            <div class="absolute -left-3 top-0 bottom-0 w-0.5 bg-gradient-to-b from-blue-400 to-blue-600"></div>
                            <p class="text-slate-700 leading-relaxed italic">"{{ $structure->visi }}"</p>
                        </div>
                    </div>
                </div>

                <!-- Mission -->
                <div class="p-5 bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-2xl border border-emerald-200">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-700 flex items-center justify-center mr-4 shadow-lg">
                            <i class="fas fa-bullseye-arrow text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-800">Misi</h4>
                            <div class="text-xs text-emerald-600 font-medium">Strategi dan Langkah</div>
                        </div>
                    </div>
                    <div class="pl-16">
                        <div class="relative">
                            <div class="absolute -left-3 top-0 bottom-0 w-0.5 bg-gradient-to-b from-emerald-400 to-emerald-600"></div>
                            <p class="text-slate-700 leading-relaxed">{{ $structure->misi }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Notes -->
        @if($structure->catatan)
        <div class="px-6 py-6 border-t border-slate-100 bg-gradient-to-b from-slate-50 to-white">
            <div class="p-5 bg-slate-50 rounded-xl border border-slate-200">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-slate-600 to-slate-700 flex items-center justify-center mr-3">
                        <i class="fas fa-sticky-note text-white text-sm"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800">Catatan Tambahan</h4>
                </div>
                <div class="pl-13">
                    <div class="p-4 bg-white rounded-lg border border-slate-100">
                        <p class="text-slate-700 leading-relaxed">{{ $structure->catatan }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Summary Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-accent/10 to-accent/5 border border-accent/20 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <div class="text-2xl font-bold text-slate-800">3</div>
                    <div class="text-sm text-slate-600">Pimpinan Utama</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-accent/20 flex items-center justify-center">
                    <i class="fas fa-users text-accent text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-emerald-100 to-emerald-50 border border-emerald-200 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <div class="text-2xl font-bold text-slate-800">{{ $structure->departemen ? count($structure->departemen) : 0 }}</div>
                    <div class="text-sm text-slate-600">Departemen</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <i class="fas fa-network-wired text-emerald-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-amber-100 to-amber-50 border border-amber-200 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <div class="text-2xl font-bold text-slate-800">{{ $structure->panitia ? count($structure->panitia) : 0 }}</div>
                    <div class="text-sm text-slate-600">Panitia Khusus</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-amber-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
}

@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .card-hover, .bg-white {
        box-shadow: none !important;
        border: 1px solid #e2e8f0 !important;
    }
    
    button, a:not(.print-link) {
        display: none !important;
    }
    
    .bg-gradient-to-br {
        background: white !important;
        border: 1px solid #e2e8f0 !important;
    }
    
    .text-accent {
        color: #1e293b !important;
    }
    
    .text-slate-800 {
        color: #1e293b !important;
    }
    
    .text-slate-600 {
        color: #475569 !important;
    }
}
</style>
@endsection