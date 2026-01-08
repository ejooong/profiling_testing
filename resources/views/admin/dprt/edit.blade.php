@extends('layouts.admin')

@section('title', 'Edit DPRT: ' . $dprt->desa_name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit DPRT</h1>
            <p class="mt-1 text-sm text-gray-600">Edit data: {{ $dprt->desa_name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.dprt.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="{{ route('admin.dprt.update', $dprt) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                    
                    <div class="space-y-6">
                        <!-- DPC Selection -->
                        <div>
                            <label for="dpc_id" class="block text-sm font-medium text-gray-700 mb-2">DPC Induk *</label>
                            <select name="dpc_id" 
                                    id="dpc_id" 
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                <option value="">Pilih DPC</option>
                                @foreach($dpcs as $dpc)
                                <option value="{{ $dpc->id }}" {{ old('dpc_id', $dprt->dpc_id) == $dpc->id ? 'selected' : '' }}>
                                    {{ $dpc->kecamatan_name }} - {{ $dpc->dpd->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('dpc_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Desa Name -->
                        <div>
                            <label for="desa_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Desa/Kelurahan *</label>
                            <input type="text" 
                                   name="desa_name" 
                                   id="desa_name" 
                                   value="{{ old('desa_name', $dprt->desa_name) }}"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('desa_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                            <textarea name="address" 
                                      id="address" 
                                      rows="3" 
                                      required
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('address', $dprt->address) }}</textarea>
                            @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                                <input type="text" 
                                       name="phone" 
                                       id="phone" 
                                       value="{{ old('phone', $dprt->phone) }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email', $dprt->email) }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leadership -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pimpinan DPRT</h3>
                    
                    <div>
                        <!-- Ketua -->
                        <div>
                            <label for="ketua" class="block text-sm font-medium text-gray-700 mb-2">Ketua</label>
                            <input type="text" 
                                   name="ketua" 
                                   id="ketua" 
                                   value="{{ old('ketua', $dprt->ketua) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('ketua')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Statistics & Location -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Statistics -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik</h3>
                        
                        <div>
                            <label for="total_kader" class="block text-sm font-medium text-gray-700 mb-2">Total Kader</label>
                            <input type="number" 
                                   name="total_kader" 
                                   id="total_kader" 
                                   value="{{ old('total_kader', $dprt->total_kader) }}"
                                   min="0"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('total_kader')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Location -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Koordinat Lokasi</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                                <input type="text" 
                                       name="latitude" 
                                       id="latitude" 
                                       value="{{ old('latitude', $dprt->latitude) }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('latitude')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                                <input type="text" 
                                       name="longitude" 
                                       id="longitude" 
                                       value="{{ old('longitude', $dprt->longitude) }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('longitude')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('description', $dprt->description) }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active" 
                               value="1"
                               {{ old('is_active', $dprt->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-nasdem-red focus:ring-red-200 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 text-sm text-gray-700">Aktif</label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-between">
                <div>
                    <button type="button" 
                            onclick="if(confirm('Apakah Anda yakin ingin menghapus DPRT ini?')) document.getElementById('delete-form').submit();"
                            class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>Hapus DPRT
                    </button>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.dprt.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-nasdem-red text-white rounded-md text-sm font-medium hover:bg-red-700">
                        Update DPRT
                    </button>
                </div>
            </div>
        </form>
        
        <!-- Delete Form -->
        <form id="delete-form" action="{{ route('admin.dprt.destroy', $dprt) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection