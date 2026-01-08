@extends('layouts.admin')

@section('title', 'Tambah Kader Baru')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Kader Baru</h1>
            <p class="mt-1 text-sm text-gray-600">Tambah data kader Partai NasDem</p>
        </div>
        <div>
            <a href="{{ route('admin.kader.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="{{ route('admin.kader.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6 space-y-6">
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pribadi</h3>
                    
                    <div class="space-y-6">
                        <!-- Full Name -->
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                            <input type="text" 
                                   name="full_name" 
                                   id="full_name" 
                                   value="{{ old('full_name') }}"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('full_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIK -->
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK (Nomor Induk Kependudukan) *</label>
                            <input type="text" 
                                   name="nik" 
                                   id="nik" 
                                   value="{{ old('nik') }}"
                                   required
                                   pattern="[0-9]{16}"
                                   maxlength="16"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                   placeholder="16 digit NIK">
                            @error('nik')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email & Phone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon *</label>
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

                        <!-- Date of Birth & Place -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="place_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir *</label>
                                <input type="text" 
                                       name="place_of_birth" 
                                       id="place_of_birth" 
                                       value="{{ old('place_of_birth') }}"
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('place_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir *</label>
                                <input type="date" 
                                       name="date_of_birth" 
                                       id="date_of_birth" 
                                       value="{{ old('date_of_birth') }}"
                                       required
                                       max="{{ date('Y-m-d') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('date_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Gender & Education -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin *</label>
                                <select name="gender" 
                                        id="gender" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="education" class="block text-sm font-medium text-gray-700 mb-2">Pendidikan Terakhir</label>
                                <select name="education" 
                                        id="education"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="sd" {{ old('education') == 'sd' ? 'selected' : '' }}>SD</option>
                                    <option value="smp" {{ old('education') == 'smp' ? 'selected' : '' }}>SMP</option>
                                    <option value="sma" {{ old('education') == 'sma' ? 'selected' : '' }}>SMA/SMK</option>
                                    <option value="d1" {{ old('education') == 'd1' ? 'selected' : '' }}>D1</option>
                                    <option value="d2" {{ old('education') == 'd2' ? 'selected' : '' }}>D2</option>
                                    <option value="d3" {{ old('education') == 'd3' ? 'selected' : '' }}>D3</option>
                                    <option value="s1" {{ old('education') == 's1' ? 'selected' : '' }}>S1/D4</option>
                                    <option value="s2" {{ old('education') == 's2' ? 'selected' : '' }}>S2</option>
                                    <option value="s3" {{ old('education') == 's3' ? 'selected' : '' }}>S3</option>
                                </select>
                                @error('education')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Photo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Kader</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-nasdem-red hover:text-red-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-nasdem-red">
                                            <span>Upload foto</span>
                                            <input id="photo" name="photo" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">atau drag & drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG maksimal 2MB</p>
                                </div>
                            </div>
                            @error('photo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Organization -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Keanggotaan Organisasi</h3>
                    
                    <div class="space-y-6">
                        <!-- DPD Selection -->
                        <div>
                            <label for="dpd_id" class="block text-sm font-medium text-gray-700 mb-2">DPD *</label>
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

                        <!-- DPC Selection -->
                        <div>
                            <label for="dpc_id" class="block text-sm font-medium text-gray-700 mb-2">DPC *</label>
                            <select name="dpc_id" 
                                    id="dpc_id" 
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                <option value="">Pilih DPC</option>
                                @foreach($dpcs as $dpc)
                                <option value="{{ $dpc->id }}" {{ old('dpc_id') == $dpc->id ? 'selected' : '' }}>
                                    {{ $dpc->kecamatan_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('dpc_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- DPRT Selection -->
                        <div>
                            <label for="dprt_id" class="block text-sm font-medium text-gray-700 mb-2">DPRT (Opsional)</label>
                            <select name="dprt_id" 
                                    id="dprt_id"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                <option value="">Pilih DPRT</option>
                                @foreach($dprts as $dprt)
                                <option value="{{ $dprt->id }}" {{ old('dprt_id') == $dprt->id ? 'selected' : '' }}>
                                    {{ $dprt->desa_name }} - {{ $dprt->dpc->kecamatan_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('dprt_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Position -->
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Jabatan di Partai (Opsional)</label>
                            <input type="text" 
                                   name="position" 
                                   id="position" 
                                   value="{{ old('position') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                   placeholder="Contoh: Anggota Departemen Politik">
                            @error('position')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                    
                    <div class="space-y-6">
                        <!-- Skills -->
                        <div>
                            <label for="skills" class="block text-sm font-medium text-gray-700 mb-2">Keahlian (Opsional)</label>
                            <textarea name="skills" 
                                      id="skills" 
                                      rows="2"
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('skills') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Pisahkan dengan koma (contoh: Public Speaking, Organisasi, IT)</p>
                            @error('skills')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" 
                                      id="notes" 
                                      rows="3"
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('notes') }}</textarea>
                            @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Status Kader</h3>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Keanggotaan *</label>
                                <select name="status" 
                                        id="status" 
                                        required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu Verifikasi)</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="registration_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Registrasi *</label>
                                <input type="date" 
                                       name="registration_date" 
                                       id="registration_date" 
                                       value="{{ old('registration_date', date('Y-m-d')) }}"
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('registration_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_verified" 
                                       id="is_verified" 
                                       value="1"
                                       {{ old('is_verified') ? 'checked' : '' }}
                                       class="h-4 w-4 text-nasdem-red focus:ring-red-200 border-gray-300 rounded">
                                <label for="is_verified" class="ml-2 text-sm text-gray-700">Terverifikasi</label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       id="is_active" 
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-nasdem-red focus:ring-red-200 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 text-sm text-gray-700">Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                <a href="{{ route('admin.kader.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-nasdem-red text-white rounded-md text-sm font-medium hover:bg-red-700">
                    Simpan Kader
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Preview photo upload
const photoInput = document.getElementById('photo');
const dropArea = photoInput.closest('.border-dashed');

dropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropArea.classList.add('border-nasdem-red', 'bg-red-50');
});

dropArea.addEventListener('dragleave', () => {
    dropArea.classList.remove('border-nasdem-red', 'bg-red-50');
});

dropArea.addEventListener('drop', (e) => {
    e.preventDefault();
    dropArea.classList.remove('border-nasdem-red', 'bg-red-50');
    
    if (e.dataTransfer.files.length) {
        photoInput.files = e.dataTransfer.files;
        previewImage(e.dataTransfer.files[0]);
    }
});

photoInput.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        previewImage(this.files[0]);
    }
});

function previewImage(file) {
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'mx-auto h-32 w-32 object-cover rounded-full';
            
            const existingImg = dropArea.querySelector('img');
            if (existingImg) existingImg.remove();
            
            dropArea.querySelector('svg').style.display = 'none';
            dropArea.querySelector('.space-y-1').prepend(img);
        };
        reader.readAsDataURL(file);
    }
}

// Filter DPRT based on selected DPC
const dpcSelect = document.getElementById('dpc_id');
const dprtSelect = document.getElementById('dprt_id');

dpcSelect.addEventListener('change', function() {
    const dpcId = this.value;
    
    // Clear DPRT options
    dprtSelect.innerHTML = '<option value="">Pilih DPRT</option>';
    
    if (dpcId) {
        // Filter DPRTs based on selected DPC
        const filteredDprts = @json($dprts->toArray()).filter(dprt => dprt.dpc_id == dpcId);
        
        filteredDprts.forEach(dprt => {
            const option = document.createElement('option');
            option.value = dprt.id;
            option.textContent = `${dprt.desa_name} - ${dprt.dpc ? dprt.dpc.kecamatan_name : ''}`;
            dprtSelect.appendChild(option);
        });
    }
});

// Initialize DPRT options based on selected DPC if any
@if(old('dpc_id'))
window.addEventListener('DOMContentLoaded', function() {
    const dpcId = {{ old('dpc_id') }};
    const filteredDprts = @json($dprts->toArray()).filter(dprt => dprt.dpc_id == dpcId);
    
    filteredDprts.forEach(dprt => {
        const option = document.createElement('option');
        option.value = dprt.id;
        option.textContent = `${dprt.desa_name} - ${dprt.dpc ? dprt.dpc.kecamatan_name : ''}`;
        if ({{ old('dprt_id') }} == dprt.id) {
            option.selected = true;
        }
        dprtSelect.appendChild(option);
    });
});
@endif
</script>
@endpush
@endsection