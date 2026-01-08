@extends('layouts.admin')

@section('title', 'Tambah Kategori Berita')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Kategori Berita</h1>
            <p class="mt-1 text-sm text-gray-600">Tambah kategori baru untuk berita</p>
        </div>
        <div>
            <a href="{{ route('admin.berita.categories.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="{{ route('admin.berita.categories.store') }}" method="POST">
            @csrf
            
            <div class="p-6 space-y-6">
                <!-- Category Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kategori</h3>
                    
                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori *</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                   placeholder="Contoh: Berita Politik">
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="3"
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Deskripsi singkat tentang kategori ini.</p>
                            @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Icon & Color -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icon (Font Awesome)</label>
                                <div class="relative">
                                    <input type="text" 
                                           name="icon" 
                                           id="icon" 
                                           value="{{ old('icon', 'fa-newspaper') }}"
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50 pl-10"
                                           placeholder="fas fa-newspaper">
                                    <div class="absolute left-3 top-2.5">
                                        <i class="fas fa-icons text-gray-400"></i>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Nama class Font Awesome (contoh: fas fa-newspaper)</p>
                                @error('icon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Warna Latar</label>
                                <select name="color" 
                                        id="color"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                    <option value="bg-blue-100" {{ old('color') == 'bg-blue-100' ? 'selected' : '' }}>Biru Muda</option>
                                    <option value="bg-red-100" {{ old('color') == 'bg-red-100' ? 'selected' : '' }}>Merah Muda</option>
                                    <option value="bg-green-100" {{ old('color') == 'bg-green-100' ? 'selected' : '' }}>Hijau Muda</option>
                                    <option value="bg-yellow-100" {{ old('color') == 'bg-yellow-100' ? 'selected' : '' }}>Kuning Muda</option>
                                    <option value="bg-purple-100" {{ old('color') == 'bg-purple-100' ? 'selected' : '' }}>Ungu Muda</option>
                                    <option value="bg-pink-100" {{ old('color') == 'bg-pink-100' ? 'selected' : '' }}>Pink Muda</option>
                                    <option value="bg-indigo-100" {{ old('color') == 'bg-indigo-100' ? 'selected' : '' }}>Indigo Muda</option>
                                </select>
                                @error('color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Color Text -->
                        <div>
                            <label for="color_text" class="block text-sm font-medium text-gray-700 mb-2">Warna Teks Icon</label>
                            <select name="color_text" 
                                    id="color_text"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                <option value="text-blue-600" {{ old('color_text') == 'text-blue-600' ? 'selected' : '' }}>Biru</option>
                                <option value="text-red-600" {{ old('color_text') == 'text-red-600' ? 'selected' : '' }}>Merah</option>
                                <option value="text-green-600" {{ old('color_text') == 'text-green-600' ? 'selected' : '' }}>Hijau</option>
                                <option value="text-yellow-600" {{ old('color_text') == 'text-yellow-600' ? 'selected' : '' }}>Kuning</option>
                                <option value="text-purple-600" {{ old('color_text') == 'text-purple-600' ? 'selected' : '' }}>Ungu</option>
                                <option value="text-pink-600" {{ old('color_text') == 'text-pink-600' ? 'selected' : '' }}>Pink</option>
                                <option value="text-indigo-600" {{ old('color_text') == 'text-indigo-600' ? 'selected' : '' }}>Indigo</option>
                            </select>
                            @error('color_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Order -->
                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampilan *</label>
                            <input type="number" 
                                   name="order" 
                                   id="order" 
                                   value="{{ old('order', 0) }}"
                                   min="0"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            <p class="mt-1 text-sm text-gray-500">Angka lebih kecil akan ditampilkan lebih awal.</p>
                            @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Status Kategori</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       id="is_active" 
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-nasdem-red focus:ring-red-200 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 text-sm text-gray-700">Aktif</label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_featured" 
                                       id="is_featured" 
                                       value="1"
                                       {{ old('is_featured') ? 'checked' : '' }}
                                       class="h-4 w-4 text-nasdem-red focus:ring-red-200 border-gray-300 rounded">
                                <label for="is_featured" class="ml-2 text-sm text-gray-700">Featured Kategori</label>
                            </div>
                        </div>
                        
                        <div class="text-sm text-gray-500">
                            <p>• Kategori aktif akan ditampilkan di frontend.</p>
                            <p>• Featured kategori akan ditampilkan lebih menonjol.</p>
                        </div>
                    </div>
                </div>

                <!-- SEO -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">SEO (Opsional)</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                            <input type="text" 
                                   name="meta_title" 
                                   id="meta_title" 
                                   value="{{ old('meta_title') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('meta_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                            <textarea name="meta_description" 
                                      id="meta_description" 
                                      rows="2"
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                            <input type="text" 
                                   name="meta_keywords" 
                                   id="meta_keywords" 
                                   value="{{ old('meta_keywords') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                   placeholder="Pisahkan dengan koma">
                            @error('meta_keywords')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                <a href="{{ route('admin.berita.categories.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-nasdem-red text-white rounded-md text-sm font-medium hover:bg-red-700">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Auto-generate slug from name
const nameInput = document.getElementById('name');
const slugInput = document.createElement('input');
slugInput.type = 'hidden';
slugInput.name = 'slug';
slugInput.id = 'slug';
nameInput.parentNode.appendChild(slugInput);

nameInput.addEventListener('blur', function() {
    const slug = this.value
        .toLowerCase()
        .replace(/[^\w\s]/gi, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
    
    slugInput.value = slug;
});

// Preview color combination
function updatePreview() {
    const color = document.getElementById('color').value;
    const colorText = document.getElementById('color_text').value;
    const icon = document.getElementById('icon').value;
    
    // Update preview if exists
    const preview = document.getElementById('color-preview');
    if (preview) {
        preview.className = `w-12 h-12 ${color} rounded-full flex items-center justify-center mr-3`;
        const iconElement = preview.querySelector('i');
        if (iconElement) {
            iconElement.className = `${icon} ${colorText}`;
        }
    }
}

// Create preview element
const previewDiv = document.createElement('div');
previewDiv.className = 'flex items-center mb-4';
previewDiv.innerHTML = `
    <h4 class="text-sm font-medium text-gray-700 mr-4">Preview:</h4>
    <div id="color-preview" class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
        <i class="fas fa-newspaper text-blue-600"></i>
    </div>
    <div>
        <p class="text-sm text-gray-600">Ini adalah preview tampilan ikon kategori</p>
    </div>
`;

// Insert preview after color_text select
const colorTextSelect = document.getElementById('color_text');
colorTextSelect.parentNode.parentNode.appendChild(previewDiv);

// Add event listeners for preview updates
document.getElementById('color').addEventListener('change', updatePreview);
document.getElementById('color_text').addEventListener('change', updatePreview);
document.getElementById('icon').addEventListener('input', updatePreview);

// Initialize preview
updatePreview();
</script>
@endpush
@endsection