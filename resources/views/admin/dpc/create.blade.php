@extends('layouts.admin')

@section('title', 'Tambah DPC Baru')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah DPC Baru</h1>
            <p class="mt-1 text-sm text-gray-600">Tambah data Dewan Pimpinan Cabang (DPC)</p>
        </div>
        <div>
            <a href="{{ route('admin.dpc.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="{{ route('admin.dpc.store') }}" method="POST">
            @csrf
            
            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                    
                    <div class="space-y-6">
                        <!-- DPD Selection -->
                        <div>
                            <label for="dpd_id" class="block text-sm font-medium text-gray-700 mb-2">DPD Induk *</label>
                            <select name="dpd_id" 
                                    id="dpd_id" 
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                <option value="">Pilih DPD</option>
                                @foreach($dpds as $dpd)
                                <option value="{{ $dpd->id }}" {{ old('dpd_id') == $dpd->id ? 'selected' : '' }}>
                                    {{ $dpd->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('dpd_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kecamatan Name -->
                        <div>
                            <label for="kecamatan_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kecamatan *</label>
                            <input type="text" 
                                   name="kecamatan_name" 
                                   id="kecamatan_name" 
                                   value="{{ old('kecamatan_name') }}"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                   placeholder="Contoh: Kecamatan Bojonegoro">
                            @error('kecamatan_name')
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
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('address') }}</textarea>
                            @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telepon *</label>
                                <input type="text" 
                                       name="phone" 
                                       id="phone" 
                                       value="{{ old('phone') }}"
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email') }}"
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Leadership -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pimpinan DPC</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Ketua -->
                        <div>
                            <label for="ketua" class="block text-sm font-medium text-gray-700 mb-2">Ketua</label>
                            <input type="text" 
                                   name="ketua" 
                                   id="ketua" 
                                   value="{{ old('ketua') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('ketua')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sekretaris -->
                        <div>
                            <label for="sekretaris" class="block text-sm font-medium text-gray-700 mb-2">Sekretaris</label>
                            <input type="text" 
                                   name="sekretaris" 
                                   id="sekretaris" 
                                   value="{{ old('sekretaris') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('sekretaris')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bendahara -->
                        <div>
                            <label for="bendahara" class="block text-sm font-medium text-gray-700 mb-2">Bendahara</label>
                            <input type="text" 
                                   name="bendahara" 
                                   id="bendahara" 
                                   value="{{ old('bendahara') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('bendahara')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Statistics & Location -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Statistics -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Awal</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="total_kader" class="block text-sm font-medium text-gray-700 mb-2">Total Kader Awal</label>
                                <input type="number" 
                                       name="total_kader" 
                                       id="total_kader" 
                                       value="{{ old('total_kader', 0) }}"
                                       min="0"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('total_kader')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="total_dprt" class="block text-sm font-medium text-gray-700 mb-2">Total DPRT Awal</label>
                                <input type="number" 
                                       name="total_dprt" 
                                       id="total_dprt" 
                                       value="{{ old('total_dprt', 0) }}"
                                       min="0"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('total_dprt')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
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
                                       value="{{ old('latitude') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                       placeholder="Contoh: -7.150975">
                                @error('latitude')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                                <input type="text" 
                                       name="longitude" 
                                       id="longitude" 
                                       value="{{ old('longitude') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                       placeholder="Contoh: 111.881860">
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
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Deskripsi singkat tentang DPC ini.</p>
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
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-nasdem-red focus:ring-red-200 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 text-sm text-gray-700">Aktif</label>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Centang untuk mengaktifkan DPC ini.</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                <a href="{{ route('admin.dpc.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-nasdem-red text-white rounded-md text-sm font-medium hover:bg-red-700">
                    Simpan DPC
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Auto-generate slug from kecamatan name
const kecamatanInput = document.getElementById('kecamatan_name');
const slugInput = document.createElement('input');
slugInput.type = 'hidden';
slugInput.name = 'slug';
slugInput.id = 'slug';
kecamatanInput.parentNode.appendChild(slugInput);

kecamatanInput.addEventListener('blur', function() {
    const slug = this.value
        .toLowerCase()
        .replace(/[^\w\s]/gi, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
    
    slugInput.value = slug;
});
</script>
@endpush
@endsection