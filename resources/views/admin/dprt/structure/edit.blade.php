@extends('layouts.admin')

@section('title', 'Edit Pengurus DPRT: ' . $dprt->desa_name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Pengurus DPRT</h1>
            <p class="mt-1 text-sm text-gray-600">
                {{ $structure->position_name }} - {{ $dprt->desa_name }}
            </p>
        </div>
        <div>
            <a href="{{ route('admin.dprt.structure.index', $dprt) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="{{ route('admin.dprt.structure.update', [$dprt, $structure]) }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Card Header -->
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-medium text-gray-900">Edit Informasi Pengurus</h2>
                <p class="text-sm text-gray-600">Perbarui data pengurus DPRT {{ $dprt->desa_name }}</p>
            </div>
            
            <!-- Card Content -->
            <div class="p-6 space-y-6">
                <!-- Current Photo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Foto Saat Ini
                    </label>
                    <div class="mt-1 flex items-center space-x-4">
                        <div class="w-24 h-24 bg-gray-100 rounded-lg border border-gray-300 overflow-hidden">
                            @if($structure->person_photo)
                                <img src="{{ asset('storage/' . $structure->person_photo) }}" 
                                     alt="{{ $structure->person_name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400 text-3xl"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">
                                {{ $structure->person_name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $structure->position_name }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Row 1 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Position Name -->
                    <div>
                        <label for="position_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Jabatan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="position_name" 
                               id="position_name"
                               value="{{ old('position_name', $structure->position_name) }}"
                               required
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200">
                        @error('position_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Person Name -->
                    <div>
                        <label for="person_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Pengurus <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="person_name" 
                               id="person_name"
                               value="{{ old('person_name', $structure->person_name) }}"
                               required
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200">
                        @error('person_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Row 2 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Nomor Telepon
                        </label>
                        <input type="text" 
                               name="phone" 
                               id="phone"
                               value="{{ old('phone', $structure->phone) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email"
                               value="{{ old('email', $structure->email) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Row 3 -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-1">
                            Urutan <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               name="order" 
                               id="order"
                               value="{{ old('order', $structure->order) }}"
                               required
                               min="1"
                               max="100"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200">
                        <p class="mt-1 text-xs text-gray-500">Urutan tampil dalam struktur</p>
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Level -->
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 mb-1">
                            Level <span class="text-red-500">*</span>
                        </label>
                        <select name="level" 
                                id="level"
                                required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200">
                            <option value="pengurus" {{ old('level', $structure->level) == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                            <option value="anggota" {{ old('level', $structure->level) == 'anggota' ? 'selected' : '' }}>Anggota</option>
                        </select>
                        @error('level')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Status -->
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">
                            Status
                        </label>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', $structure->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-nasdem-red focus:ring-nasdem-red">
                                <span class="ml-2 text-sm text-gray-600">Aktif</span>
                            </label>
                        </div>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- New Photo Upload -->
                <div>
                    <label for="person_photo" class="block text-sm font-medium text-gray-700 mb-1">
                        Ganti Foto Pengurus (Opsional)
                    </label>
                    <div class="mt-1">
                        <input type="file" 
                               name="person_photo" 
                               id="person_photo"
                               accept="image/*"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-nasdem-red file:text-white
                                      hover:file:bg-red-700">
                        <p class="mt-1 text-xs text-gray-500">Ukuran maksimal 2MB. Kosongkan jika tidak ingin mengganti foto.</p>
                    </div>
                    @error('person_photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Responsibilities -->
                <div>
                    <label for="responsibilities" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggung Jawab & Tugas
                    </label>
                    <textarea name="responsibilities" 
                              id="responsibilities" 
                              rows="3"
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200"
                              placeholder="Deskripsikan tugas dan tanggung jawab jabatan ini">{{ old('responsibilities', $structure->responsibilities) }}</textarea>
                    @error('responsibilities')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Card Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-between">
                <div>
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-history mr-1"></i>
                        Terakhir diperbarui: {{ $structure->updated_at->format('d M Y H:i') }}
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.dprt.structure.index', $dprt) }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                        <i class="fas fa-save mr-2"></i>Perbarui Data
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="bg-white rounded-lg shadow overflow-hidden border border-red-200">
        <div class="px-6 py-4 border-b border-red-200 bg-red-50">
            <h3 class="text-lg font-medium text-red-800">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Zona Berbahaya
            </h3>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-medium text-gray-900">Hapus Pengurus</h4>
                    <p class="text-sm text-gray-600 mt-1">
                        Tindakan ini akan menghapus data pengurus secara permanen.
                    </p>
                </div>
                <form action="{{ route('admin.dprt.structure.destroy', [$dprt, $structure]) }}" 
                      method="POST" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengurus ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>Hapus Pengurus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection