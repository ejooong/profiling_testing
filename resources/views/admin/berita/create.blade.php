@extends('layouts.admin')

@section('title', 'Tambah Berita Baru')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Berita Baru</h1>
            <p class="mt-1 text-sm text-gray-600">Buat berita atau artikel baru untuk website</p>
        </div>
        <div>
            <a href="{{ route('admin.berita.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Berita *</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title') }}"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                            <select name="category_id" 
                                    id="category_id" 
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- DPC -->
                        <div>
                            <label for="dpc_id" class="block text-sm font-medium text-gray-700 mb-2">DPC (Opsional)</label>
                            <select name="dpc_id" 
                                    id="dpc_id"
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

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                            <select name="status" 
                                    id="status" 
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Featured & Headline -->
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_featured" 
                                       id="is_featured" 
                                       value="1"
                                       {{ old('is_featured') ? 'checked' : '' }}
                                       class="h-4 w-4 text-nasdem-red focus:ring-red-200 border-gray-300 rounded">
                                <label for="is_featured" class="ml-2 text-sm text-gray-700">Featured Berita</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_headline" 
                                       id="is_headline" 
                                       value="1"
                                       {{ old('is_headline') ? 'checked' : '' }}
                                       class="h-4 w-4 text-nasdem-red focus:ring-red-200 border-gray-300 rounded">
                                <label for="is_headline" class="ml-2 text-sm text-gray-700">Headline Berita</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Featured Image</h3>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-nasdem-red hover:text-red-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-nasdem-red">
                                    <span>Upload gambar</span>
                                    <input id="featured_image" name="featured_image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">atau drag & drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF maksimal 2MB</p>
                        </div>
                    </div>
                    @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excerpt -->
                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Ringkasan (Excerpt) *</label>
                    <textarea name="excerpt" 
                              id="excerpt" 
                              rows="3" 
                              required
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('excerpt') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Ringkasan singkat berita yang akan ditampilkan di halaman daftar berita.</p>
                    @error('excerpt')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten Berita *</label>
                    <textarea name="content" 
                              id="content" 
                              rows="15" 
                              required
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('content') }}</textarea>
                    @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SEO -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">SEO & Meta Information</h3>
                    
                    <div class="space-y-4">
                        <!-- Meta Keywords -->
                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                            <input type="text" 
                                   name="meta_keywords" 
                                   id="meta_keywords" 
                                   value="{{ old('meta_keywords') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            <p class="mt-1 text-sm text-gray-500">Pisahkan dengan koma (contoh: nasdem, bojonegoro, politik)</p>
                            @error('meta_keywords')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Meta Description -->
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                            <textarea name="meta_description" 
                                      id="meta_description" 
                                      rows="3"
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('meta_description') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Deskripsi singkat untuk SEO (maksimal 160 karakter).</p>
                            @error('meta_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                <a href="{{ route('admin.berita.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-nasdem-red text-white rounded-md text-sm font-medium hover:bg-red-700">
                    Simpan Berita
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Simple character counter for meta description
const metaDescription = document.getElementById('meta_description');
const charCount = document.createElement('div');
charCount.className = 'text-xs text-gray-500 mt-1';
charCount.innerHTML = '0/160 karakter';
metaDescription.parentNode.appendChild(charCount);

metaDescription.addEventListener('input', function() {
    const length = this.value.length;
    charCount.innerHTML = `${length}/160 karakter`;
    if (length > 160) {
        charCount.classList.add('text-red-500');
    } else {
        charCount.classList.remove('text-red-500');
    }
});

// Preview image upload
const featuredImageInput = document.getElementById('featured_image');
const dropArea = featuredImageInput.closest('.border-dashed');

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
        featuredImageInput.files = e.dataTransfer.files;
        
        // Preview image
        const file = e.dataTransfer.files[0];
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'mx-auto h-32 object-contain';
                
                const existingImg = dropArea.querySelector('img');
                if (existingImg) existingImg.remove();
                
                dropArea.querySelector('svg').style.display = 'none';
                dropArea.querySelector('.space-y-1').prepend(img);
            };
            reader.readAsDataURL(file);
        }
    }
});

featuredImageInput.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const file = this.files[0];
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'mx-auto h-32 object-contain';
                
                const existingImg = dropArea.querySelector('img');
                if (existingImg) existingImg.remove();
                
                dropArea.querySelector('svg').style.display = 'none';
                dropArea.querySelector('.space-y-1').prepend(img);
            };
            reader.readAsDataURL(file);
        }
    }
});
</script>
@endpush
@endsection