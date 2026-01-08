@extends('layouts.admin')

@section('title', 'Tambah Pengurus DPRT: ' . $dprt->desa_name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Pengurus DPRT</h1>
            <p class="mt-1 text-sm text-gray-600">{{ $dprt->desa_name }} - {{ $dprt->dpc->kecamatan_name ?? 'DPC' }}</p>
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
        <form action="{{ route('admin.dprt.structure.store', $dprt) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Card Header -->
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-medium text-gray-900">Informasi Pengurus</h2>
                <p class="text-sm text-gray-600">Isi data pengurus DPRT {{ $dprt->desa_name }}</p>
            </div>
            
            <!-- Card Content -->
            <div class="p-6 space-y-6">
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
                               value="{{ old('position_name') }}"
                               required
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200"
                               placeholder="Contoh: Ketua, Sekretaris, Bendahara">
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
                               value="{{ old('person_name') }}"
                               required
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200"
                               placeholder="Nama lengkap pengurus">
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
                               value="{{ old('phone') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200"
                               placeholder="0812-3456-7890">
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
                               value="{{ old('email') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200"
                               placeholder="email@example.com">
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
                               value="{{ old('order', 1) }}"
                               required
                               min="1"
                               max="100"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200">
                        <p class="mt-1 text-xs text-gray-500">Urutan tampil dalam struktur (1 = paling atas)</p>
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
                            <option value="pengurus" {{ old('level') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                            <option value="anggota" {{ old('level') == 'anggota' ? 'selected' : '' }}>Anggota</option>
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
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-nasdem-red focus:ring-nasdem-red">
                                <span class="ml-2 text-sm text-gray-600">Aktif</span>
                            </label>
                        </div>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Photo Upload -->
                <div>
                    <label for="person_photo" class="block text-sm font-medium text-gray-700 mb-1">
                        Foto Pengurus
                    </label>
                    <div class="mt-1 flex items-center space-x-4">
                        <div class="w-24 h-24 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-camera text-gray-400 text-2xl mb-2"></i>
                                <p class="text-xs text-gray-500">Foto</p>
                            </div>
                        </div>
                        <div class="flex-1">
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
                            <p class="mt-1 text-xs text-gray-500">Ukuran maksimal 2MB. Format: JPG, PNG, JPEG</p>
                        </div>
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
                              placeholder="Deskripsikan tugas dan tanggung jawab jabatan ini">{{ old('responsibilities') }}</textarea>
                    @error('responsibilities')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Card Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-between">
                <div>
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        Pastikan data yang diisi sudah benar
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.dprt.structure.index', $dprt) }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                        <i class="fas fa-save mr-2"></i>Simpan Pengurus
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Help Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            <i class="fas fa-question-circle text-nasdem-red mr-2"></i>
            Panduan Pengisian
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-gray-900 mb-2">Urutan (Order)</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• 1: Ketua (posisi tertinggi)</li>
                    <li>• 2: Sekretaris</li>
                    <li>• 3: Bendahara</li>
                    <li>• 4-10: Pengurus lainnya</li>
                    <li>• 11+: Anggota</li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 mb-2">Level</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• <strong>Pengurus</strong>: Struktur inti (Ketua, Sekretaris, Bendahara)</li>
                    <li>• <strong>Anggota</strong>: Anggota biasa atau seksi-seksi</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Preview image upload
document.getElementById('person_photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewDiv = document.querySelector('.bg-gray-100.rounded-lg');
            previewDiv.innerHTML = `
                <img src="${e.target.result}" 
                     alt="Preview" 
                     class="w-full h-full object-cover rounded-lg">
                <div class="absolute top-2 right-2">
                    <button type="button" onclick="removePhoto()" 
                            class="w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            `;
            previewDiv.classList.add('relative');
        }
        reader.readAsDataURL(file);
    }
});

function removePhoto() {
    const input = document.getElementById('person_photo');
    const previewDiv = document.querySelector('.bg-gray-100.rounded-lg');
    
    input.value = '';
    previewDiv.innerHTML = `
        <div class="text-center">
            <i class="fas fa-camera text-gray-400 text-2xl mb-2"></i>
            <p class="text-xs text-gray-500">Foto</p>
        </div>
    `;
    previewDiv.classList.remove('relative');
}
</script>
@endpush
@endsection