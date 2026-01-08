@extends('layouts.admin')

@section('title', 'Tambah DPD Baru')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah DPD Baru</h1>
            <p class="mt-1 text-sm text-gray-600">Tambah data Dewan Pimpinan Daerah (DPD)</p>
        </div>
        <div>
            <a href="{{ route('admin.dpd.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="{{ route('admin.dpd.store') }}" method="POST">
            @csrf
            
            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                    
                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama DPD *</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                   placeholder="Contoh: DPD NasDem Kabupaten Bojonegoro">
                            @error('name')
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
                </div>

                <!-- Leadership -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pimpinan DPD</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Ketua -->
                        <div>
                            <label for="ketua" class="block text-sm font-medium text-gray-700 mb-2">Ketua *</label>
                            <input type="text" 
                                   name="ketua" 
                                   id="ketua" 
                                   value="{{ old('ketua') }}"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('ketua')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sekretaris -->
                        <div>
                            <label for="sekretaris" class="block text-sm font-medium text-gray-700 mb-2">Sekretaris *</label>
                            <input type="text" 
                                   name="sekretaris" 
                                   id="sekretaris" 
                                   value="{{ old('sekretaris') }}"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('sekretaris')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bendahara -->
                        <div>
                            <label for="bendahara" class="block text-sm font-medium text-gray-700 mb-2">Bendahara *</label>
                            <input type="text" 
                                   name="bendahara" 
                                   id="bendahara" 
                                   value="{{ old('bendahara') }}"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('bendahara')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Awal</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Total Kader -->
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

                        <!-- Total DPC -->
                        <div>
                            <label for="total_dpc" class="block text-sm font-medium text-gray-700 mb-2">Total DPC Awal</label>
                            <input type="number" 
                                   name="total_dpc" 
                                   id="total_dpc" 
                                   value="{{ old('total_dpc', 0) }}"
                                   min="0"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('total_dpc')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Deskripsi singkat tentang DPD ini.</p>
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
                    <p class="mt-1 text-sm text-gray-500">Centang untuk mengaktifkan DPD ini.</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                <a href="{{ route('admin.dpd.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-nasdem-red text-white rounded-md text-sm font-medium hover:bg-red-700">
                    Simpan DPD
                </button>
            </div>
        </form>
    </div>
</div>
@endsection