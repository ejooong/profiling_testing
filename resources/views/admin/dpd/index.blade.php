@extends('layouts.admin')

@section('title', 'Manajemen DPD')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dewan Pimpinan Daerah (DPD)</h1>
            <p class="mt-1 text-sm text-gray-600">Manajemen data DPD Kabupaten Bojonegoro</p>
        </div>
        <div>
            <a href="{{ route('admin.dpd.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-plus mr-2"></i>Tambah DPD
            </a>
        </div>
    </div>

    <!-- DPD Card -->
    @if($dpd)
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b bg-nasdem-navy text-white">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold">{{ $dpd->name }}</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.dpd.edit', $dpd) }}" 
                       class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 rounded text-sm">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.dpd.structure', $dpd) }}" 
                       class="px-3 py-1 bg-blue-500 hover:bg-blue-600 rounded text-sm">
                        <i class="fas fa-sitemap mr-1"></i>Struktur
                    </a>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Basic Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-500">Alamat:</span>
                            <p class="text-gray-900">{{ $dpd->address }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Telepon:</span>
                            <p class="text-gray-900">{{ $dpd->phone }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Email:</span>
                            <p class="text-gray-900">{{ $dpd->email }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Status:</span>
                            @if($dpd->is_active)
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Aktif</span>
                            @else
                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Non-Aktif</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pimpinan</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-500">Ketua:</span>
                            <p class="text-gray-900">{{ $dpd->ketua }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Sekretaris:</span>
                            <p class="text-gray-900">{{ $dpd->sekretaris }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Bendahara:</span>
                            <p class="text-gray-900">{{ $dpd->bendahara }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ number_format($dpd->total_kader) }}</div>
                        <div class="text-sm text-gray-600">Total Kader</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $dpd->total_dpc }}</div>
                        <div class="text-sm text-gray-600">Total DPC</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">
                            {{ \App\Models\DPRT\Dprt::count() }}
                        </div>
                        <div class="text-sm text-gray-600">Total DPRT</div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($dpd->description)
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Deskripsi</h3>
                <p class="text-gray-700">{{ $dpd->description }}</p>
            </div>
            @endif
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-lg shadow p-12 text-center">
        <i class="fas fa-building text-gray-300 text-6xl mb-4"></i>
        <h3 class="text-xl font-medium text-gray-900 mb-2">Belum ada data DPD</h3>
        <p class="text-gray-600 mb-6">Silakan tambahkan data DPD terlebih dahulu.</p>
        <a href="{{ route('admin.dpd.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
            <i class="fas fa-plus mr-2"></i>Tambah DPD
        </a>
    </div>
    @endif

    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.dpc.index') }}" 
           class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300 border border-transparent hover:border-nasdem-red">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">DPC Kecamatan</h3>
                    <p class="text-sm text-gray-600">{{ \App\Models\DPC\Dpc::count() }} DPC</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.dprt.index') }}" 
           class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300 border border-transparent hover:border-nasdem-red">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                    <i class="fas fa-map-pin text-green-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">DPRT Desa</h3>
                    <p class="text-sm text-gray-600">{{ \App\Models\DPRT\Dprt::count() }} DPRT</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.kader.index') }}" 
           class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300 border border-transparent hover:border-nasdem-red">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mr-4">
                    <i class="fas fa-users text-red-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">Kader</h3>
                    <p class="text-sm text-gray-600">{{ \App\Models\Kader\Kader::count() }} Kader</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection