@extends('layouts.admin')

@section('title', 'Edit Kader: ' . $kader->name) {{-- Ubah dari full_name ke name --}}

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Kader</h1>
            <p class="mt-1 text-sm text-gray-600">Edit data: {{ $kader->name }}</p>
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
        <form action="{{ route('admin.kader.update', $kader) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-6 space-y-6">
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pribadi</h3>
                    
                    <div class="space-y-6">
                        <!-- Current Photo -->
   @if($kader->photo_path)
<div class="mb-4">
    <label class="block text-sm text-gray-600 mb-2">Foto saat ini:</label>
    <div class="flex items-center space-x-4">
        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-nasdem-red">
            <img src="{{ asset('storage/' . $kader->photo_path) }}" 
                 alt="{{ $kader->name }}" 
                 class="w-full h-full object-cover">
        </div>
        <div>
            <label class="flex items-center text-sm text-red-600">
                <input type="checkbox" name="remove_photo" value="1" class="mr-2">
                Hapus foto saat ini
            </label>
        </div>
    </div>
</div>
@endif

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $kader->name) }}"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIK -->
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK (Nomor Induk Kependudukan) *</label>
                            <input type="text" 
                                   name="nik" 
                                   id="nik" 
                                   value="{{ old('nik', $kader->nik) }}"
                                   required
                                   pattern="[0-9]{16}"
                                   maxlength="16"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
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
                                       value="{{ old('email', $kader->email) }}"
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
                                       value="{{ old('phone', $kader->phone) }}"
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
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('address', $kader->address) }}</textarea>
                            @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth & Place -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="birth_place" class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir *</label>
                                <input type="text" 
                                       name="birth_place" 
                                       id="birth_place" 
                                       value="{{ old('birth_place', $kader->birth_place) }}"
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('birth_place')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir *</label>
                                <input type="date" 
                                       name="birth_date" 
                                       id="birth_date" 
                                       value="{{ old('birth_date', $kader->birth_date->format('Y-m-d')) }}"
                                       required
                                       max="{{ date('Y-m-d') }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('birth_date')
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
                                    <option value="L" {{ old('gender', $kader->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender', $kader->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="education" class="block text-sm font-medium text-gray-700 mb-2">Pendidikan Terakhir</label>
                                <input type="text"
                                       name="education" 
                                       id="education"
                                       value="{{ old('education', $kader->education) }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('education')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- New Photo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Foto Baru</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="photo_path" class="relative cursor-pointer bg-white rounded-md font-medium text-nasdem-red hover:text-red-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-nasdem-red">
                                            <span>Upload foto baru</span>
                                            <input id="photo_path" name="photo_path" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">atau drag & drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG maksimal 2MB</p>
                                </div>
                            </div>
                            @error('photo_path')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Organization -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Keanggotaan Organisasi</h3>
                    
                    <div class="space-y-6">
                        <!-- DPC Selection -->
                        <div>
                            <label for="dpc_id" class="block text-sm font-medium text-gray-700 mb-2">DPC *</label>
                            <select name="dpc_id" 
                                    id="dpc_id" 
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                <option value="">Pilih DPC</option>
                                @foreach($dpcs as $dpc)
                                <option value="{{ $dpc->id }}" {{ old('dpc_id', $kader->dpc_id) == $dpc->id ? 'selected' : '' }}>
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
                            <label for="dprt_id" class="block text-sm font-medium text-gray-700 mb-2">DPRT *</label>
                            <select name="dprt_id" 
                                    id="dprt_id"
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                <option value="">Pilih DPRT</option>
                                @foreach($dprts as $dprt)
                                <option value="{{ $dprt->id }}" {{ old('dprt_id', $kader->dprt_id) == $dprt->id ? 'selected' : '' }}>
                                    {{ $dprt->desa_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('dprt_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- RT/RW -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="rt" class="block text-sm font-medium text-gray-700 mb-2">RT *</label>
                                <input type="text" 
                                       name="rt" 
                                       id="rt" 
                                       value="{{ old('rt', $kader->rt) }}"
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('rt')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="rw" class="block text-sm font-medium text-gray-700 mb-2">RW *</label>
                                <input type="text" 
                                       name="rw" 
                                       id="rw" 
                                       value="{{ old('rw', $kader->rw) }}"
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('rw')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Village & District -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-2">Kelurahan/Desa *</label>
                                <input type="text" 
                                       name="kelurahan" 
                                       id="kelurahan" 
                                       value="{{ old('kelurahan', $kader->kelurahan) }}"
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('kelurahan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-2">Kecamatan *</label>
                                <input type="text" 
                                       name="kecamatan" 
                                       id="kecamatan" 
                                       value="{{ old('kecamatan', $kader->kecamatan) }}"
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('kecamatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Profession & Position -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="profession" class="block text-sm font-medium text-gray-700 mb-2">Profesi/Pekerjaan *</label>
                                <input type="text" 
                                       name="profession" 
                                       id="profession" 
                                       value="{{ old('profession', $kader->profession) }}"
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('profession')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="position_in_party" class="block text-sm font-medium text-gray-700 mb-2">Jabatan di Partai (Opsional)</label>
                                <input type="text" 
                                       name="position_in_party" 
                                       id="position_in_party" 
                                       value="{{ old('position_in_party', $kader->position_in_party) }}"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('position_in_party')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
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
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('skills', $kader->skills) }}</textarea>
                            @error('skills')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Join Date -->
                        <div>
                            <label for="join_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Bergabung *</label>
                            <input type="date" 
                                   name="join_date" 
                                   id="join_date" 
                                   value="{{ old('join_date', $kader->join_date->format('Y-m-d')) }}"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('join_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Status Kader</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Keanggotaan *</label>
                            <select name="status" 
                                    id="status" 
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                <option value="pending" {{ old('status', $kader->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ old('status', $kader->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="non_active" {{ old('status', $kader->status) == 'non_active' ? 'selected' : '' }}>Non Aktif</option>
                            </select>
                            @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="is_verified" 
                                   id="is_verified" 
                                   value="1"
                                   {{ old('is_verified', $kader->is_verified) ? 'checked' : '' }}
                                   class="h-4 w-4 text-nasdem-red focus:ring-red-200 border-gray-300 rounded">
                            <label for="is_verified" class="ml-2 text-sm text-gray-700">Terverifikasi</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-between">
                <div>
                    <button type="button" 
                            onclick="if(confirm('Apakah Anda yakin ingin menghapus kader ini?')) document.getElementById('delete-form').submit();"
                            class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>Hapus Kader
                    </button>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.kader.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-nasdem-red text-white rounded-md text-sm font-medium hover:bg-red-700">
                        Update Kader
                    </button>
                </div>
            </div>
        </form>
        
        <!-- Delete Form -->
        <form id="delete-form" action="{{ route('admin.kader.destroy', $kader) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

@push('scripts')
<script>
// Preview new photo upload
const photoInput = document.getElementById('photo_path');
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

// Autofill kelurahan and kecamatan based on DPRT selection
const dprtSelect = document.getElementById('dprt_id');
const kelurahanInput = document.getElementById('kelurahan');
const kecamatanInput = document.getElementById('kecamatan');

dprtSelect.addEventListener('change', async function() {
    const dprtId = this.value;
    
    if (dprtId) {
        try {
            // Fetch DPRT data via API or from preloaded data
            const response = await fetch(`/api/dprt/${dprtId}`);
            const dprt = await response.json();
            
            if (dprt) {
                kelurahanInput.value = dprt.desa_name || '';
                if (dprt.dpc) {
                    kecamatanInput.value = dprt.dpc.kecamatan_name || '';
                }
            }
        } catch (error) {
            console.error('Error fetching DPRT data:', error);
        }
    }
});
</script>
@endpush
@endsection