@extends('layouts.admin')

@section('title', 'Edit Struktur DPC: ' . $dpc->kecamatan_name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Struktur DPC</h1>
            <p class="mt-1 text-sm text-gray-600">{{ $dpc->kecamatan_name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.dpc.structure', $dpc) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="{{ isset($structure) && $structure->id ? route('admin.dpc.structure.update', [$dpc, $structure]) : route('admin.dpc.structure.store', $dpc) }}" method="POST">
            @csrf
            @if(isset($structure) && $structure->id)
                @method('PUT')
            @endif
            
            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Jabatan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Position Name -->
                        <div>
                            <label for="position_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Jabatan *</label>
                            <input type="text" 
                                   name="position_name" 
                                   id="position_name" 
                                   value="{{ old('position_name', $structure->position_name ?? '') }}"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                   placeholder="Contoh: Ketua, Sekretaris, Bendahara">
                            @error('position_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Person Name -->
                        <div>
                            <label for="person_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Pejabat *</label>
                            <input type="text" 
                                   name="person_name" 
                                   id="person_name" 
                                   value="{{ old('person_name', $structure->person_name ?? '') }}"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                   placeholder="Nama lengkap pejabat">
                            @error('person_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Kontak Informasi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                            <input type="text" 
                                   name="phone" 
                                   id="phone" 
                                   value="{{ old('phone', $structure->phone ?? '') }}"
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
                                   value="{{ old('email', $structure->email ?? '') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Level & Order -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Klasifikasi & Urutan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Level -->
                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700 mb-2">Level *</label>
                            <select name="level" 
                                    id="level" 
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                <option value="">Pilih Level</option>
                                <option value="pengurus" {{ old('level', $structure->level ?? '') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                                <option value="bpo" {{ old('level', $structure->level ?? '') == 'bpo' ? 'selected' : '' }}>Badan Pengawas Organisasi (BPO)</option>
                                <option value="departemen" {{ old('level', $structure->level ?? '') == 'departemen' ? 'selected' : '' }}>Departemen</option>
                            </select>
                            @error('level')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Order -->
                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan *</label>
                            <input type="number" 
                                   name="order" 
                                   id="order" 
                                   value="{{ old('order', $structure->order ?? 0) }}"
                                   min="0"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            <p class="mt-1 text-xs text-gray-500">Angka lebih kecil = posisi lebih atas</p>
                            @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Photo Upload -->
                <div>
                    <label for="person_photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Pejabat</label>
                    <div class="mt-1 flex items-center">
                        <input type="file" 
                               name="person_photo" 
                               id="person_photo" 
                               accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-nasdem-red/10 file:text-nasdem-red hover:file:bg-nasdem-red/20">
                    </div>
                    @if(isset($structure) && $structure->person_photo)
                    <div class="mt-2 text-sm text-gray-500">
                        <i class="fas fa-image mr-1"></i>
                        Foto saat ini: {{ basename($structure->person_photo) }}
                    </div>
                    @endif
                    @error('person_photo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Responsibilities -->
                <div>
                    <label for="responsibilities" class="block text-sm font-medium text-gray-700 mb-2">Tugas & Tanggung Jawab</label>
                    <textarea name="responsibilities" 
                              id="responsibilities" 
                              rows="4"
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('responsibilities', $structure->responsibilities ?? '') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Deskripsi tugas dan tanggung jawab jabatan ini</p>
                    @error('responsibilities')
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
                               {{ old('is_active', isset($structure) ? $structure->is_active : true) ? 'checked' : '' }}
                               class="h-4 w-4 text-nasdem-red focus:ring-red-200 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 text-sm text-gray-700">Aktif</label>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Centang untuk mengaktifkan jabatan ini dalam struktur.</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                <a href="{{ route('admin.dpc.structure', $dpc) }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-nasdem-red text-white rounded-md text-sm font-medium hover:bg-red-700">
                    {{ isset($structure) && $structure->id ? 'Update Struktur' : 'Simpan Struktur' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection