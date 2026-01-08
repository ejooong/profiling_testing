@extends('layouts.admin')

@section('title', 'Detail DPC: ' . $dpc->kecamatan_name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail DPC</h1>
            <p class="mt-1 text-sm text-gray-600">{{ $dpc->kecamatan_name }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.dpc.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <a href="{{ route('admin.dpc.edit', $dpc) }}" 
               class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Basic Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- DPC Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b bg-blue-50">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">{{ $dpc->kecamatan_name }}</h2>
                        @if($dpc->is_active)
                        <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">
                            <i class="fas fa-check-circle mr-1"></i>Aktif
                        </span>
                        @else
                        <span class="px-3 py-1 text-sm font-medium bg-red-100 text-red-800 rounded-full">
                            <i class="fas fa-times-circle mr-1"></i>Non-Aktif
                        </span>
                        @endif
                    </div>
                </div>
                
                <div class="p-6">
                    <!-- Basic Info -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-500">DPD Induk:</span>
                                    <p class="font-medium">{{ $dpc->dpd->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Alamat:</span>
                                    <p class="text-gray-700">{{ $dpc->address }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Telepon:</span>
                                    <p class="text-gray-700">{{ $dpc->phone }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Email:</span>
                                    <p class="text-gray-700">{{ $dpc->email }}</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-500">Koordinat:</span>
                                    @if($dpc->latitude && $dpc->longitude)
                                    <p class="text-gray-700">{{ $dpc->latitude }}, {{ $dpc->longitude }}</p>
                                    @else
                                    <p class="text-gray-500 italic">Belum ditentukan</p>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Dibuat:</span>
                                    <p class="text-gray-700">{{ $dpc->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Diperbarui:</span>
                                    <p class="text-gray-700">{{ $dpc->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                                @if($dpc->deleted_at)
                                <div>
                                    <span class="text-sm text-gray-500">Dihapus:</span>
                                    <p class="text-red-600">{{ $dpc->deleted_at->format('d/m/Y H:i') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Leadership -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pimpinan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-600 mb-1">Ketua</div>
                                <div class="font-medium text-lg">{{ $dpc->ketua ?? '-' }}</div>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-600 mb-1">Sekretaris</div>
                                <div class="font-medium text-lg">{{ $dpc->sekretaris ?? '-' }}</div>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-600 mb-1">Bendahara</div>
                                <div class="font-medium text-lg">{{ $dpc->bendahara ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="text-center bg-white border rounded-lg p-4">
                                <div class="text-3xl font-bold text-blue-600">{{ $dpc->total_kader }}</div>
                                <div class="text-sm text-gray-600 mt-1">Total Kader</div>
                            </div>
                            <div class="text-center bg-white border rounded-lg p-4">
                                <div class="text-3xl font-bold text-green-600">{{ $dpc->total_dprt }}</div>
                                <div class="text-sm text-gray-600 mt-1">Total DPRT</div>
                            </div>
                            <div class="text-center bg-white border rounded-lg p-4">
                                <div class="text-3xl font-bold text-purple-600">{{ $dpc->dprt->count() }}</div>
                                <div class="text-sm text-gray-600 mt-1">DPRT Aktif</div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($dpc->description)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Deskripsi</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700">{{ $dpc->description }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- DPRT List -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">DPRT di Kecamatan Ini</h3>
                        <a href="{{ route('admin.dprt.create', ['dpc_id' => $dpc->id]) }}" 
                           class="text-sm text-nasdem-red hover:text-red-700">
                            <i class="fas fa-plus mr-1"></i>Tambah DPRT
                        </a>
                    </div>
                </div>
                
                @if($dpc->dprt->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($dpc->dprt->take(10) as $dprt)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-map-pin text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $dprt->desa_name }}</h4>
                                    <p class="text-sm text-gray-500">{{ Str::limit($dprt->address, 50) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-600">{{ $dprt->total_kader }} kader</span>
                                <a href="{{ route('admin.dprt.show', $dprt) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($dpc->dprt->count() > 10)
                <div class="px-6 py-4 border-t text-center">
                    <a href="{{ route('admin.dprt.index', ['dpc_id' => $dpc->id]) }}" 
                       class="text-sm text-nasdem-red hover:text-red-700">
                        Lihat semua {{ $dpc->dprt->count() }} DPRT
                    </a>
                </div>
                @endif
                @else
                <div class="px-6 py-8 text-center">
                    <i class="fas fa-map-pin text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-600 mb-2">Belum ada data DPRT</p>
                    <a href="{{ route('admin.dprt.create', ['dpc_id' => $dpc->id]) }}" 
                       class="text-sm text-nasdem-red hover:text-red-700">
                        <i class="fas fa-plus mr-1"></i>Tambah DPRT pertama
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column - Actions & Structure -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.dpc.structure', $dpc) }}" 
                       class="flex items-center justify-between p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition duration-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-sitemap text-purple-600"></i>
                            </div>
                            <span class="font-medium text-gray-900">Struktur Organisasi</span>
                        </div>
                        <i class="fas fa-chevron-right text-purple-600"></i>
                    </a>
                    
                    <a href="{{ route('admin.kader.index', ['dpc_id' => $dpc->id]) }}" 
                       class="flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition duration-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                            <span class="font-medium text-gray-900">Lihat Kader</span>
                        </div>
                        <i class="fas fa-chevron-right text-blue-600"></i>
                    </a>
                    
                    <a href="{{ route('admin.berita.index', ['dpc_id' => $dpc->id]) }}" 
                       class="flex items-center justify-between p-3 bg-red-50 hover:bg-red-100 rounded-lg transition duration-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-newspaper text-red-600"></i>
                            </div>
                            <span class="font-medium text-gray-900">Berita DPC</span>
                        </div>
                        <i class="fas fa-chevron-right text-red-600"></i>
                    </a>
                </div>
            </div>

            <!-- Status Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Status & Aksi</h3>
                
                @if($dpc->deleted_at)
                <div class="mb-4 p-3 bg-red-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-trash text-red-500 mr-2"></i>
                        <span class="text-red-700">DPC ini telah dihapus</span>
                    </div>
                    <form action="{{ route('admin.dpc.restore', $dpc) }}" method="POST" class="mt-3">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            <i class="fas fa-undo mr-2"></i>Pulihkan DPC
                        </button>
                    </form>
                </div>
                @else
                <div class="space-y-3">
                    <!-- Toggle Status -->
                    <form action="{{ route('admin.dpc.toggle-status', $dpc) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="w-full px-4 py-2 {{ $dpc->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-md">
                            <i class="fas {{ $dpc->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }} mr-2"></i>
                            {{ $dpc->is_active ? 'Non-aktifkan DPC' : 'Aktifkan DPC' }}
                        </button>
                    </form>

                    <!-- Delete -->
                    <form action="{{ route('admin.dpc.destroy', $dpc) }}" method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus DPC ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            <i class="fas fa-trash mr-2"></i>Hapus DPC
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <!-- Map Preview -->
            @if($dpc->latitude && $dpc->longitude)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Lokasi Peta</h3>
                <div class="h-48 bg-gray-200 rounded-lg overflow-hidden relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-map-marker-alt text-nasdem-red text-3xl mb-2"></i>
                            <p class="text-sm text-gray-600">{{ $dpc->kecamatan_name }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3 text-sm text-gray-600">
                    Latitude: {{ $dpc->latitude }}, Longitude: {{ $dpc->longitude }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection