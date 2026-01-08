@extends('layouts.admin')

@section('title', 'Detail DPRT: ' . $dprt->desa_name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail DPRT</h1>
            <p class="mt-1 text-sm text-gray-600">{{ $dprt->desa_name }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.dprt.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <a href="{{ route('admin.dprt.edit', $dprt) }}" 
               class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Basic Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- DPRT Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b bg-green-50">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">{{ $dprt->desa_name }}</h2>
                        @if($dprt->is_active)
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
                    <!-- Hierarchy -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Struktur Organisasi</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-building text-red-600"></i>
                                    </div>
                                    <span class="font-medium">{{ $dprt->dpc->dpd->name ?? 'DPD' }}</span>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                            
                            <div class="flex items-center justify-between mb-2 ml-8">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                                    </div>
                                    <span class="font-medium">{{ $dprt->dpc->kecamatan_name }}</span>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                            
                            <div class="flex items-center ml-16">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-map-pin text-green-600"></i>
                                </div>
                                <span class="font-medium">{{ $dprt->desa_name }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Info -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-500">DPC Induk:</span>
                                    <p class="font-medium">{{ $dprt->dpc->kecamatan_name ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Alamat:</span>
                                    <p class="text-gray-700">{{ $dprt->address }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Telepon:</span>
                                    <p class="text-gray-700">{{ $dprt->phone ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Email:</span>
                                    <p class="text-gray-700">{{ $dprt->email ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-500">Koordinat:</span>
                                    @if($dprt->latitude && $dprt->longitude)
                                    <p class="text-gray-700">{{ $dprt->latitude }}, {{ $dprt->longitude }}</p>
                                    @else
                                    <p class="text-gray-500 italic">Belum ditentukan</p>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Ketua:</span>
                                    <p class="text-gray-700">{{ $dprt->ketua ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Dibuat:</span>
                                    <p class="text-gray-700">{{ $dprt->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Diperbarui:</span>
                                    <p class="text-gray-700">{{ $dprt->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                                @if($dprt->deleted_at)
                                <div>
                                    <span class="text-sm text-gray-500">Dihapus:</span>
                                    <p class="text-red-600">{{ $dprt->deleted_at->format('d/m/Y H:i') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="text-center bg-white border rounded-lg p-4">
                                <div class="text-3xl font-bold text-blue-600">{{ $dprt->total_kader }}</div>
                                <div class="text-sm text-gray-600 mt-1">Total Kader</div>
                            </div>
                            <div class="text-center bg-white border rounded-lg p-4">
                                <div class="text-3xl font-bold text-green-600">{{ $dprt->kaders->count() }}</div>
                                <div class="text-sm text-gray-600 mt-1">Kader Terdaftar</div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($dprt->description)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Deskripsi</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700">{{ $dprt->description }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Kader List -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Kader di Desa Ini</h3>
                        <a href="{{ route('admin.kader.create', ['dprt_id' => $dprt->id]) }}" 
                           class="text-sm text-nasdem-red hover:text-red-700">
                            <i class="fas fa-plus mr-1"></i>Tambah Kader
                        </a>
                    </div>
                </div>
                
                @if($dprt->kaders->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($dprt->kaders->take(10) as $kader)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-purple-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $kader->full_name }}</h4>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <span class="mr-3">NIK: {{ $kader->nik }}</span>
                                        <span>{{ $kader->phone }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($kader->is_active)
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                    Aktif
                                </span>
                                @else
                                <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                    Pending
                                </span>
                                @endif
                                <a href="{{ route('admin.kader.show', $kader) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($dprt->kaders->count() > 10)
                <div class="px-6 py-4 border-t text-center">
                    <a href="{{ route('admin.kader.index', ['dprt_id' => $dprt->id]) }}" 
                       class="text-sm text-nasdem-red hover:text-red-700">
                        Lihat semua {{ $dprt->kaders->count() }} kader
                    </a>
                </div>
                @endif
                @else
                <div class="px-6 py-8 text-center">
                    <i class="fas fa-users text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-600 mb-2">Belum ada data kader</p>
                    <a href="{{ route('admin.kader.create', ['dprt_id' => $dprt->id]) }}" 
                       class="text-sm text-nasdem-red hover:text-red-700">
                        <i class="fas fa-plus mr-1"></i>Tambah kader pertama
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
                    <a href="{{ route('admin.dprt.structure.index', $dprt) }}" 
                       class="flex items-center justify-between p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition duration-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-sitemap text-purple-600"></i>
                            </div>
                            <span class="font-medium text-gray-900">Struktur Organisasi</span>
                        </div>
                        <i class="fas fa-chevron-right text-purple-600"></i>
                    </a>
                    
                    <a href="{{ route('admin.dpc.show', $dprt->dpc) }}" 
                       class="flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition duration-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <span class="font-medium text-gray-900">Ke DPC Induk</span>
                        </div>
                        <i class="fas fa-chevron-right text-blue-600"></i>
                    </a>
                    
                    <a href="{{ route('admin.dpd.show', $dprt->dpc->dpd) }}" 
                       class="flex items-center justify-between p-3 bg-red-50 hover:bg-red-100 rounded-lg transition duration-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-building text-red-600"></i>
                            </div>
                            <span class="font-medium text-gray-900">Ke DPD Induk</span>
                        </div>
                        <i class="fas fa-chevron-right text-red-600"></i>
                    </a>
                </div>
            </div>

            <!-- Status Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Status & Aksi</h3>
                
                @if($dprt->deleted_at)
                <div class="mb-4 p-3 bg-red-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-trash text-red-500 mr-2"></i>
                        <span class="text-red-700">DPRT ini telah dihapus</span>
                    </div>
                    <form action="{{ route('admin.dprt.restore', $dprt) }}" method="POST" class="mt-3">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            <i class="fas fa-undo mr-2"></i>Pulihkan DPRT
                        </button>
                    </form>
                </div>
                @else
                <div class="space-y-3">
                    <!-- Toggle Status -->
                    <form action="{{ route('admin.dprt.toggle-status', $dprt) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="w-full px-4 py-2 {{ $dprt->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-md">
                            <i class="fas {{ $dprt->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }} mr-2"></i>
                            {{ $dprt->is_active ? 'Non-aktifkan DPRT' : 'Aktifkan DPRT' }}
                        </button>
                    </form>

                    <!-- Delete -->
                    <form action="{{ route('admin.dprt.destroy', $dprt) }}" method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus DPRT ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            <i class="fas fa-trash mr-2"></i>Hapus DPRT
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <!-- Map Preview -->
            @if($dprt->latitude && $dprt->longitude)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Lokasi Peta</h3>
                <div class="h-48 bg-gray-200 rounded-lg overflow-hidden relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-map-pin text-nasdem-red text-3xl mb-2"></i>
                            <p class="text-sm text-gray-600">{{ $dprt->desa_name }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3 text-sm text-gray-600">
                    Latitude: {{ $dprt->latitude }}, Longitude: {{ $dprt->longitude }}
                </div>
            </div>
            @endif

            <!-- DPRT Statistics -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Kader</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Kader</span>
                        <span class="font-bold">{{ $dprt->total_kader }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Kader Terdaftar</span>
                        <span class="font-bold">{{ $dprt->kaders->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Kader Aktif</span>
                        <span class="font-bold text-green-600">{{ $dprt->kaders->where('is_active', true)->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Kader Pending</span>
                        <span class="font-bold text-yellow-600">{{ $dprt->kaders->where('is_active', false)->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection