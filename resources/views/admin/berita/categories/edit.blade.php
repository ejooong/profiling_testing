@extends('layouts.admin')

@section('title', 'Edit Kategori Berita: ' . $category->name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Kategori Berita</h1>
            <p class="mt-1 text-sm text-gray-600">Edit kategori: {{ $category->name }}</p>
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
        <form action="{{ route('admin.berita.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

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
                                value="{{ old('name', $category->name) }}"
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
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('description', $category->description) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Deskripsi singkat tentang kategori ini.</p>
                            @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Color -->
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Warna</label>
                            <div class="flex items-center space-x-4">
                                <input type="color"
                                    name="color"
                                    id="color"
                                    value="{{ old('color', $category->color) }}"
                                    class="w-16 h-10 border-0 rounded cursor-pointer">
                                <input type="text"
                                    name="color_hex"
                                    id="color_hex"
                                    value="{{ old('color', $category->color) }}"
                                    class="w-32 border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                    placeholder="#001F3F"
                                    pattern="^#[0-9A-Fa-f]{6}$">
                                <div id="color_preview" class="w-10 h-10 rounded border border-gray-300" style="background-color: {{ $category->color }}"></div>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Pilih warna untuk kategori (format hex: #RRGGBB)</p>
                            @error('color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Order -->
                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampilan *</label>
                            <input type="number"
                                name="order"
                                id="order"
                                value="{{ old('order', $category->order) }}"
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
                        <div class="flex items-center">
                            <input type="checkbox"
                                name="is_active"
                                id="is_active"
                                value="1"
                                {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 text-nasdem-red focus:ring-red-200 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 text-sm text-gray-700">Kategori Aktif</label>
                        </div>

                        <div class="text-sm text-gray-500">
                            <p>• Kategori aktif akan ditampilkan di frontend dan dapat digunakan untuk berita.</p>
                            <p>• Non-aktif kategori tetap ada di database tapi tidak ditampilkan.</p>
                        </div>
                    </div>
                </div>

                <!-- Category Stats -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Statistik Kategori</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-sm text-gray-600">Total Berita</div>
                            <div class="text-2xl font-bold text-blue-600">{{ $category->beritas_count ?? 0 }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Dibuat Pada</div>
                            <div class="text-sm text-gray-900">{{ $category->created_at->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-between">
                <div>
                    @if($category->beritas_count == 0)
                    <button type="button"
                        onclick="confirmDelete()"
                        class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>Hapus Kategori
                    </button>
                    @else
                    <span class="text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-2"></i>Tidak dapat dihapus karena ada {{ $category->beritas_count }} berita
                    </span>
                    @endif
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.berita.categories.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-nasdem-red text-white rounded-md text-sm font-medium hover:bg-red-700">
                        Update Kategori
                    </button>
                </div>
            </div>
        </form>

        <!-- Delete Form (hidden) -->
        @if($category->beritas_count == 0)
        <form id="deleteForm" action="{{ route('admin.berita.categories.destroy', $category) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('blur', function() {
        const name = this.value;
        if (name.trim() === '') return;

        // Generate slug
        const slug = name
            .toLowerCase()
            .replace(/[^\w\s]/gi, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();

        // Create hidden slug field if not exists
        let slugInput = document.getElementById('slug');
        if (!slugInput) {
            slugInput = document.createElement('input');
            slugInput.type = 'hidden';
            slugInput.name = 'slug';
            slugInput.id = 'slug';
            this.parentNode.appendChild(slugInput);
        }
        slugInput.value = slug;
    });

    // Color picker functionality
    const colorPicker = document.getElementById('color');
    const colorHex = document.getElementById('color_hex');
    const colorPreview = document.getElementById('color_preview');

    // Update hex input when color picker changes
    colorPicker.addEventListener('input', function() {
        colorHex.value = this.value;
        colorPreview.style.backgroundColor = this.value;
    });

    // Update color picker when hex input changes
    colorHex.addEventListener('input', function() {
        if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
            colorPicker.value = this.value;
            colorPreview.style.backgroundColor = this.value;
        }
    });

    // Delete confirmation
    function confirmDelete() {
        if (confirm('Apakah Anda yakin ingin menghapus kategori ini?\n\nData yang dihapus tidak dapat dikembalikan.')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
@endpush
@endsection