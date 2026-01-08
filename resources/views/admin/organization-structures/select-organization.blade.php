{{-- File: resources/views/admin/organization-structures/select-organization.blade.php --}}
@extends('layouts.admin')

@section('title', 'Pilih Organisasi untuk Struktur')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-8 max-w-6xl mx-auto">
        <div class="text-center mb-8">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-accent to-accent-light flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-sitemap text-white text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Pilih Organisasi</h1>
            <p class="text-slate-600 mt-2">Pilih organisasi yang ingin Anda tambahkan struktur</p>
        </div>

        <!-- DPD Section -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mr-4">
                    <i class="fas fa-building text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">DPD (Dewan Pimpinan Daerah)</h2>
                    <p class="text-slate-600">Pilih DPD untuk menambahkan struktur kepengurusan</p>
                </div>
            </div>

            @if($dpds->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($dpds as $dpd)
                <a href="{{ route('admin.organization-structures.create', ['organization_type' => 'dpd', 'organization_id' => $dpd->id]) }}"
                    class="group p-6 bg-white border-2 border-blue-100 rounded-xl hover:border-blue-400 hover:shadow-lg transition-all-300 hover:scale-[1.02]">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg mb-2">{{ $dpd->name }}</h3>
                            <div class="text-sm text-slate-600 space-y-1">
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-blue-500 mr-2 text-xs"></i>
                                    <span>{{ $dpd->address }}</span>
                                </div>
                                @if($dpd->phone)
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-blue-500 mr-2 text-xs"></i>
                                    <span>{{ $dpd->phone }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $dpd->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $dpd->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                            <div class="mt-2 text-blue-600">
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <div class="text-sm text-slate-500">
                            <span class="font-medium text-slate-700">{{ $dpd->total_dpc ?? 0 }}</span> DPC,
                            <span class="font-medium text-slate-700">{{ $dpd->total_kader ?? 0 }}</span> Kader
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-8 text-center">
                <i class="fas fa-building text-blue-300 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-slate-800 mb-2">Belum ada DPD</h3>
                <p class="text-slate-600 mb-4">Silakan tambahkan DPD terlebih dahulu</p>
                <a href="{{ route('admin.dpd.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>Tambah DPD
                </a>
            </div>
            @endif
        </div>

        <!-- DPC Section -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mr-4">
                    <i class="fas fa-map-marker-alt text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">DPC (Dewan Pimpinan Cabang)</h2>
                    <p class="text-slate-600">Pilih DPC untuk menambahkan struktur kepengurusan</p>
                </div>
            </div>

            @if($dpcs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($dpcs as $dpc)
                <a href="{{ route('admin.organization-structures.create', ['organization_type' => 'dpc', 'organization_id' => $dpc->id]) }}"
                    class="group p-6 bg-white border-2 border-green-100 rounded-xl hover:border-green-400 hover:shadow-lg transition-all-300 hover:scale-[1.02]">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg mb-2">{{ $dpc->kecamatan_name }}</h3>
                            <div class="text-sm text-slate-600 space-y-1">
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-green-500 mr-2 text-xs"></i>
                                    <span>{{ $dpc->address }}</span>
                                </div>
                                @if($dpc->phone)
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-green-500 mr-2 text-xs"></i>
                                    <span>{{ $dpc->phone }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $dpc->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $dpc->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                            <div class="mt-2 text-green-600">
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <div class="text-sm text-slate-500">
                            <span class="font-medium text-slate-700">{{ $dpc->total_dprt ?? 0 }}</span> DPRT,
                            <span class="font-medium text-slate-700">{{ $dpc->total_kader ?? 0 }}</span> Kader
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="bg-green-50 border border-green-200 rounded-xl p-8 text-center">
                <i class="fas fa-map-marker-alt text-green-300 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-slate-800 mb-2">Belum ada DPC</h3>
                <p class="text-slate-600 mb-4">Silakan tambahkan DPC terlebih dahulu</p>
                <a href="{{ route('admin.dpc.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-plus mr-2"></i>Tambah DPC
                </a>
            </div>
            @endif
        </div>

        <!-- DPRT Section -->
        <div class="mb-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mr-4">
                    <i class="fas fa-map-pin text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">DPRT (Dewan Pimpinan Ranting)</h2>
                    <p class="text-slate-600">Pilih DPRT untuk menambahkan struktur kepengurusan</p>
                </div>
            </div>

            @if($dprts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($dprts as $dprt)
                <a href="{{ route('admin.organization-structures.create', ['organization_type' => 'dprt', 'organization_id' => $dprt->id]) }}"
                    class="group p-6 bg-white border-2 border-purple-100 rounded-xl hover:border-purple-400 hover:shadow-lg transition-all-300 hover:scale-[1.02]">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg mb-2">{{ $dprt->desa_name }}</h3>
                            <div class="text-sm text-slate-600 space-y-1">
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-purple-500 mr-2 text-xs"></i>
                                    <span>{{ $dprt->address }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-layer-group text-purple-500 mr-2 text-xs"></i>
                                    <span>Kec. {{ $dprt->kecamatan_name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $dprt->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $dprt->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                            <div class="mt-2 text-purple-600">
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <div class="text-sm text-slate-500">
                            <span class="font-medium text-slate-700">{{ $dprt->total_kader ?? 0 }}</span> Kader
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="bg-purple-50 border border-purple-200 rounded-xl p-8 text-center">
                <i class="fas fa-map-pin text-purple-300 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-slate-800 mb-2">Belum ada DPRT</h3>
                <p class="text-slate-600 mb-4">Silakan tambahkan DPRT terlebih dahulu</p>
                <a href="{{ route('admin.dprt.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    <i class="fas fa-plus mr-2"></i>Tambah DPRT
                </a>
            </div>
            @endif
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('admin.organization-structures.index') }}"
                class="inline-flex items-center px-5 py-2.5 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition-all-300">
                <i class="fas fa-list mr-2"></i>Lihat Semua Struktur
            </a>
        </div>
    </div>
</div>
@endsection