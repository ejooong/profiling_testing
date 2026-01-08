@extends('layouts.admin')

@section('title', 'Tambah Gallery Baru')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Gallery Baru</h1>
            <p class="text-slate-600 mt-1">Tambahkan album foto kegiatan baru</p>
        </div>
        <a href="{{ route('admin.galleries.index') }}"
            class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-lg font-medium hover:bg-slate-200 transition-all-300">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" id="galleryForm">
            @csrf

            <div class="p-6">
                <!-- Basic Information -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Informasi Dasar</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Judul Gallery <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" required value="{{ old('title') }}"
                                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300"
                                placeholder="Contoh: Pelantikan Pengurus DPC Ngasem">
                            @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="category" required
                                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300">
                                <option value="">Pilih Kategori</option>
                                <option value="pelantikan" {{ old('category') == 'pelantikan' ? 'selected' : '' }}>Pelantikan</option>
                                <option value="sosial" {{ old('category') == 'sosial' ? 'selected' : '' }}>Bakti Sosial</option>
                                <option value="rapat" {{ old('category') == 'rapat' ? 'selected' : '' }}>Rapat Kerja</option>
                                <option value="kunjungan" {{ old('category') == 'kunjungan' ? 'selected' : '' }}>Kunjungan</option>
                                <option value="pelatihan" {{ old('category') == 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                <option value="kerjasama" {{ old('category') == 'kerjasama' ? 'selected' : '' }}>Kerjasama</option>
                                <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300"
                        placeholder="Deskripsi kegiatan...">{{ old('description') }}</textarea>
                </div>

                <!-- Event Details -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Detail Kegiatan</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Tanggal Kegiatan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="event_date" required value="{{ old('event_date') }}"
                                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300">
                            @error('event_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Waktu
                            </label>
                            <input type="time" name="event_time" value="{{ old('event_time') }}"
                                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Jumlah Peserta
                            </label>
                            <input type="number" name="participant_count" min="0" value="{{ old('participant_count') }}"
                                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300"
                                placeholder="Contoh: 100">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Lokasi
                        </label>
                        <input type="text" name="location" value="{{ old('location') }}"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300"
                            placeholder="Contoh: Aula Kecamatan Ngasem">
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Upload Foto</h2>

                    <div class="mb-4">
                        <div class="image-upload-item border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:border-accent transition-all-300 cursor-pointer"
                            id="dropZone">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-cloud-upload-alt text-5xl text-slate-400 mb-4"></i>
                                <p class="text-slate-600 font-medium text-lg mb-2">Upload Foto</p>
                                <p class="text-slate-500 text-sm mb-4">Drag & drop atau klik untuk upload multiple foto</p>
                                <input type="file" name="images[]" multiple accept="image/*"
                                    class="hidden" id="imageInput">
                                <button type="button" onclick="document.getElementById('imageInput').click()"
                                    class="inline-flex items-center px-6 py-3 bg-accent text-white rounded-lg font-medium hover:bg-accent-light transition-all-300 shadow-md hover:shadow-lg">
                                    <i class="fas fa-plus mr-3"></i>Pilih Foto (Multiple)
                                </button>
                                <p class="text-slate-400 text-xs mt-3">Maksimal 50 foto sekaligus • 10MB per foto</p>
                            </div>
                        </div>
                    </div>

                    <!-- Image Counter -->
                    <div id="imageCounter" class="flex items-center justify-between mb-4 hidden">
                        <span class="text-sm text-slate-600">
                            <span id="selectedCount">0</span> foto terpilih
                        </span>
                        <button type="button" onclick="clearAllImages()"
                            class="text-red-500 hover:text-red-700 text-sm font-medium">
                            <i class="fas fa-times mr-1"></i>Hapus Semua
                        </button>
                    </div>

                    <!-- Image Preview Grid -->
                    <div id="image-preview" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                        <!-- Image previews will appear here -->
                    </div>

                    <!-- Caption Template (hidden) -->
                    <div id="captionTemplate" class="hidden">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">Keterangan Foto</label>
                            <textarea name="captions[]"
                                class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent"
                                rows="2" placeholder="Tambahkan keterangan foto..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-8">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" class="rounded border-slate-300 text-accent focus:ring-accent"
                            {{ old('is_published') ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-slate-700">Publikasikan gallery</span>
                    </label>
                    <p class="text-slate-500 text-xs mt-1">Jika dicentang, gallery akan langsung ditampilkan di website</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-slate-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Format foto: JPG, PNG, GIF, WebP (maks. 10MB per foto)
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.galleries.index') }}"
                            class="px-6 py-2.5 border border-slate-300 text-slate-700 rounded-lg font-medium hover:bg-slate-50 transition-all-300">
                            Batal
                        </a>
                        <button type="submit" id="submitBtn"
                            class="px-6 py-2.5 bg-accent text-white rounded-lg font-medium hover:bg-accent-light transition-all-300 flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-save mr-2"></i>Simpan Gallery
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Global variables
    let imageFiles = [];
    let imagePreviews = [];

    // DOM Elements
    const imageInput = document.getElementById('imageInput');
    const dropZone = document.getElementById('dropZone');
    const imagePreview = document.getElementById('image-preview');
    const imageCounter = document.getElementById('imageCounter');
    const selectedCount = document.getElementById('selectedCount');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('galleryForm');

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Update submit button state
        updateSubmitButton();
    });

    // Click to upload
    if (imageInput) {
        imageInput.addEventListener('change', handleFileSelect);
    }

    // Drag and drop functions
    if (dropZone) {
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-accent', 'bg-blue-50');
        });

        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-accent', 'bg-blue-50');
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-accent', 'bg-blue-50');

            if (e.dataTransfer.files.length > 0) {
                handleFileSelect({
                    target: {
                        files: e.dataTransfer.files
                    }
                });
            }
        });
    }

    // Handle file selection
    function handleFileSelect(e) {
        const files = Array.from(e.target.files);

        // Filter only image files
        const imageFilesArray = files.filter(file => file.type.startsWith('image/'));

        if (imageFilesArray.length === 0) {
            alert('Harap pilih file gambar!');
            return;
        }

        // Check file sizes
        const oversizedFiles = imageFilesArray.filter(file => file.size > 10 * 1024 * 1024);
        if (oversizedFiles.length > 0) {
            alert(`${oversizedFiles.length} file melebihi 10MB!`);
            return;
        }

        // Check total images
        if (imageFiles.length + imageFilesArray.length > 50) {
            alert('Maksimal 50 foto per gallery!');
            return;
        }

        // Add new files to array
        imageFiles.push(...imageFilesArray);

        // Clear and update input
        imageInput.value = '';
        updateFileInput();

        // Create previews
        createPreviews(imageFilesArray);

        // Update UI
        updateImageCounter();
        updateSubmitButton();
    }

    // Create image previews
    function createPreviews(files) {
        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewId = Date.now() + '_' + index;

                const previewElement = document.createElement('div');
                previewElement.id = `preview-${previewId}`;
                previewElement.className = 'relative group bg-white rounded-lg overflow-hidden shadow-sm border border-slate-200';
                previewElement.innerHTML = `
                <div class="relative aspect-square">
                    <img src="${e.target.result}" 
                         alt="${file.name}" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <button type="button" onclick="removeImage('${previewId}')" 
                                class="text-white hover:text-red-300 p-2">
                            <i class="fas fa-trash text-xl"></i>
                        </button>
                    </div>
                    <div class="absolute top-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                        ${formatFileSize(file.size)}
                    </div>
                </div>
                <div class="p-3">
                    <p class="text-xs text-slate-600 truncate mb-2" title="${file.name}">
                        ${file.name}
                    </p>
                    <textarea name="captions[]" 
                              class="w-full px-3 py-2 text-xs border border-slate-200 rounded focus:ring-1 focus:ring-accent focus:border-transparent" 
                              rows="2" 
                              placeholder="Keterangan foto..."></textarea>
                </div>
            `;

                imagePreview.appendChild(previewElement);
                imagePreviews.push({
                    id: previewId,
                    element: previewElement
                });
            };
            reader.readAsDataURL(file);
        });
    }

    // Remove image
    function removeImage(previewId) {
        // Remove from preview array
        const previewIndex = imagePreviews.findIndex(p => p.id === previewId);
        if (previewIndex !== -1) {
            imagePreviews.splice(previewIndex, 1);
        }

        // Remove from files array (approximate based on preview count)
        // Since we don't have direct mapping, we'll remove the last file
        // This is a limitation of the browser's file input
        if (imageFiles.length > imagePreviews.length) {
            imageFiles.splice(imagePreviews.length, 1);
        }

        // Remove DOM element
        const element = document.getElementById(`preview-${previewId}`);
        if (element) {
            element.remove();
        }

        // Update UI
        updateFileInput();
        updateImageCounter();
        updateSubmitButton();
    }

    // Clear all images
    function clearAllImages() {
        if (!confirm('Hapus semua foto yang dipilih?')) return;

        imageFiles = [];
        imagePreviews = [];
        imagePreview.innerHTML = '';

        updateFileInput();
        updateImageCounter();
        updateSubmitButton();
    }

    // Update file input
    function updateFileInput() {
        // Create new DataTransfer
        const dt = new DataTransfer();

        // Add all files
        imageFiles.forEach(file => {
            dt.items.add(file);
        });

        // Update input files
        imageInput.files = dt.files;
    }

    // Update image counter
    function updateImageCounter() {
        const count = imageFiles.length;

        if (count > 0) {
            imageCounter.classList.remove('hidden');
            selectedCount.textContent = count;

            // Update drop zone text
            const dropZoneText = dropZone.querySelector('p:nth-child(3)');
            if (dropZoneText) {
                dropZoneText.textContent = `${count} foto terpilih • Drag & drop untuk tambah lagi`;
            }
        } else {
            imageCounter.classList.add('hidden');

            // Reset drop zone text
            const dropZoneText = dropZone.querySelector('p:nth-child(3)');
            if (dropZoneText) {
                dropZoneText.textContent = 'Drag & drop atau klik untuk upload multiple foto';
            }
        }
    }

    // Update submit button state
    function updateSubmitButton() {
        const hasImages = imageFiles.length > 0;

        submitBtn.disabled = !hasImages;
        if (!hasImages) {
            submitBtn.title = 'Harap upload minimal 1 foto';
        } else {
            submitBtn.title = '';
        }
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';

        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }

    // Form validation
    form.addEventListener('submit', function(e) {
        if (imageFiles.length === 0) {
            e.preventDefault();
            alert('Harap upload minimal 1 foto!');
            return false;
        }

        // Validate individual file sizes (already done, but double-check)
        for (let file of imageFiles) {
            if (file.size > 10 * 1024 * 1024) {
                e.preventDefault();
                alert(`File "${file.name}" melebihi 10MB!`);
                return false;
            }
        }

        // Show loading
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
        submitBtn.disabled = true;

        return true;
    });

    // Auto-save form data to localStorage (optional)
    let autoSaveTimer;
    form.addEventListener('input', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(() => {
            const formData = {
                title: form.querySelector('[name="title"]').value,
                description: form.querySelector('[name="description"]').value,
                category: form.querySelector('[name="category"]').value,
                event_date: form.querySelector('[name="event_date"]').value,
                event_time: form.querySelector('[name="event_time"]').value,
                location: form.querySelector('[name="location"]').value,
                participant_count: form.querySelector('[name="participant_count"]').value
            };
            localStorage.setItem('galleryDraft', JSON.stringify(formData));
        }, 1000);
    });

    // Load draft data
    window.addEventListener('load', function() {
        const draft = localStorage.getItem('galleryDraft');
        if (draft) {
            const formData = JSON.parse(draft);
            Object.keys(formData).forEach(key => {
                const element = form.querySelector(`[name="${key}"]`);
                if (element && formData[key]) {
                    element.value = formData[key];
                }
            });
        }
    });

    // Clear draft on successful submit
    form.addEventListener('submit', function() {
        localStorage.removeItem('galleryDraft');
    });
</script>
@endpush

@push('styles')
<style>
    .image-upload-item {
        transition: all 0.3s ease;
    }

    .image-upload-item:hover {
        border-color: #0ea5e9;
        background-color: rgba(14, 165, 233, 0.05);
    }

    #image-preview img {
        transition: transform 0.3s ease;
    }

    #image-preview img:hover {
        transform: scale(1.05);
    }

    /* Custom scrollbar for image preview */
    #image-preview {
        max-height: 500px;
        overflow-y: auto;
    }

    #image-preview::-webkit-scrollbar {
        width: 6px;
    }

    #image-preview::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    #image-preview::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    #image-preview::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endpush