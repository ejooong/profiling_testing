@extends('layouts.admin')

@section('title', 'Edit Gallery')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit Gallery</h1>
            <p class="text-slate-600 mt-1">Edit album foto kegiatan</p>
        </div>
        <a href="{{ route('admin.galleries.index') }}"
            class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-lg font-medium hover:bg-slate-200 transition-all-300">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data" id="galleryForm">
            @csrf
            @method('PUT')

            <div class="p-6">
                <!-- Basic Information -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Informasi Dasar</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Judul Gallery <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" required value="{{ old('title', $gallery->title) }}"
                                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300">
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
                                <option value="pelantikan" {{ old('category', $gallery->category) == 'pelantikan' ? 'selected' : '' }}>Pelantikan</option>
                                <option value="sosial" {{ old('category', $gallery->category) == 'sosial' ? 'selected' : '' }}>Bakti Sosial</option>
                                <option value="rapat" {{ old('category', $gallery->category) == 'rapat' ? 'selected' : '' }}>Rapat Kerja</option>
                                <option value="kunjungan" {{ old('category', $gallery->category) == 'kunjungan' ? 'selected' : '' }}>Kunjungan</option>
                                <option value="pelatihan" {{ old('category', $gallery->category) == 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                <option value="kerjasama" {{ old('category', $gallery->category) == 'kerjasama' ? 'selected' : '' }}>Kerjasama</option>
                                <option value="lainnya" {{ old('category', $gallery->category) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300">{{ old('description', $gallery->description) }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bagian Event Details -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Detail Kegiatan</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Tanggal Kegiatan <span class="text-red-500">*</span>
                            </label>
                            @php
                            $eventDate = old('event_date', $gallery->event_date);
                            if ($eventDate instanceof \Carbon\Carbon) {
                            $eventDate = $eventDate->format('Y-m-d');
                            } elseif (is_string($eventDate)) {
                            try {
                            $eventDate = date('Y-m-d', strtotime($eventDate));
                            } catch (\Exception $e) {
                            $eventDate = '';
                            }
                            }
                            @endphp
                            <input type="date" name="event_date" required value="{{ $eventDate }}"
                                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300">
                            @error('event_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Waktu
                            </label>
                            @php
                            $eventTime = old('event_time', $gallery->event_time);

                            // Format waktu dengan benar untuk input type="time"
                            if (!empty($eventTime)) {
                            if ($eventTime instanceof \DateTime) {
                            $eventTime = $eventTime->format('H:i');
                            } elseif (is_string($eventTime)) {
                            // Coba parse berbagai format waktu
                            try {
                            // Coba format 24 jam (H:i)
                            if (preg_match('/^\d{1,2}:\d{2}$/', $eventTime)) {
                            // Jika sudah format H:i, langsung gunakan
                            $eventTime = date('H:i', strtotime($eventTime));
                            } else {
                            // Coba format lain
                            $time = \Carbon\Carbon::parse($eventTime);
                            $eventTime = $time->format('H:i');
                            }
                            } catch (\Exception $e) {
                            $eventTime = '';
                            }
                            }
                            } else {
                            $eventTime = '';
                            }
                            @endphp
                            <input type="time" name="event_time" value="{{ $eventTime }}"
                                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300"
                                placeholder="HH:MM (24 jam)">
                            <p class="text-xs text-slate-500 mt-1">Format: 24 jam (contoh: 14:30)</p>
                            @error('event_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Jumlah Peserta
                            </label>
                            <input type="number" name="participant_count" min="0" value="{{ old('participant_count', $gallery->participant_count) }}"
                                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300">
                            @error('participant_count')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Lokasi
                        </label>
                        <input type="text" name="location" value="{{ old('location', $gallery->location) }}"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300">
                        @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Existing Images -->
                @if($gallery->images->count() > 0)
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Foto yang Ada</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6" id="existing-images-container">
                        @foreach($gallery->images as $image)
                        <div class="relative group bg-white rounded-lg overflow-hidden shadow-sm border border-slate-200" data-image-id="{{ $image->id }}">
                            <div class="relative aspect-square">
                                <img src="{{ Storage::url($image->image_path) }}"
                                    alt="{{ $image->caption ?: $gallery->title }}"
                                    class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <button type="button" onclick="deleteImage({{ $image->id }})"
                                        class="text-white hover:text-red-300 p-2">
                                        <i class="fas fa-trash text-xl"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-3">
                                <textarea name="existing_captions[{{ $image->id }}]"
                                    class="w-full px-3 py-2 text-xs border border-slate-200 rounded focus:ring-1 focus:ring-accent focus:border-transparent"
                                    rows="2">{{ old('existing_captions.' . $image->id, $image->caption) }}</textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Add New Images -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Tambah Foto Baru</h2>

                    <div class="mb-4">
                        <div class="image-upload-item border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:border-accent transition-all-300 cursor-pointer"
                            id="dropZone">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-cloud-upload-alt text-5xl text-slate-400 mb-4"></i>
                                <p class="text-slate-600 font-medium text-lg mb-2">Tambah Foto Baru</p>
                                <p class="text-slate-500 text-sm mb-4">Drag & drop atau klik untuk upload foto tambahan</p>
                                <input type="file" name="new_images[]" multiple accept="image/*"
                                    class="hidden" id="imageInput">
                                <button type="button" onclick="document.getElementById('imageInput').click()"
                                    class="inline-flex items-center px-6 py-3 bg-accent text-white rounded-lg font-medium hover:bg-accent-light transition-all-300 shadow-md hover:shadow-lg">
                                    <i class="fas fa-plus mr-3"></i>Pilih Foto Tambahan
                                </button>
                                <p class="text-slate-400 text-xs mt-3">Maksimal 10MB per foto • Format: JPG, PNG, GIF, WebP</p>
                            </div>
                        </div>
                    </div>

                    <!-- New Images Preview -->
                    <div id="new-images-preview" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-6">
                        <!-- New image previews will appear here -->
                    </div>
                    @error('new_images')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    @error('new_images.*')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-8">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" class="rounded border-slate-300 text-accent focus:ring-accent"
                            {{ old('is_published', $gallery->is_published) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-slate-700">Publikasikan gallery</span>
                    </label>
                    @error('is_published')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-slate-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Total foto: <span id="total-images-count">{{ $gallery->images->count() }}</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.galleries.index') }}"
                            class="px-6 py-2.5 border border-slate-300 text-slate-700 rounded-lg font-medium hover:bg-slate-50 transition-all-300">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-accent text-white rounded-lg font-medium hover:bg-accent-light transition-all-300 flex items-center">
                            <i class="fas fa-save mr-2"></i>Update Gallery
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
    // Variables for new images
    let newImageFiles = [];

    // DOM Elements
    const imageInput = document.getElementById('imageInput');
    const dropZone = document.getElementById('dropZone');
    const newImagesPreview = document.getElementById('new-images-preview');
    const totalImagesCountElement = document.getElementById('total-images-count');
    const existingImagesContainer = document.getElementById('existing-images-container');

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Gallery edit script loaded');
    });

    // Click to upload
    if (imageInput) {
        imageInput.addEventListener('change', handleFileSelect);
        console.log('Image input event listener added');
    }

    // Drag and drop functions
    if (dropZone) {
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.add('border-accent', 'bg-blue-50');
        });

        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.remove('border-accent', 'bg-blue-50');
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
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
        console.log('File selected:', e.target.files.length);
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

        // Check file extensions
        const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        const invalidFiles = imageFilesArray.filter(file => {
            const extension = file.name.split('.').pop().toLowerCase();
            return !allowedExtensions.includes(extension);
        });

        if (invalidFiles.length > 0) {
            alert(`${invalidFiles.length} file memiliki format yang tidak didukung! Hanya JPG, PNG, GIF, WebP yang diperbolehkan.`);
            return;
        }

        // Add new files to array
        newImageFiles.push(...imageFilesArray);
        console.log('Total files in array:', newImageFiles.length);

        // Update file input dengan semua file
        updateFileInput();

        // Create previews
        createPreviews(imageFilesArray);

        // Update total images count
        updateTotalImagesCount();
    }

    // Create image previews
    function createPreviews(files) {
        console.log('Creating previews for', files.length, 'files');
        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewId = Date.now() + '_' + index;

                const previewElement = document.createElement('div');
                previewElement.id = `new-preview-${previewId}`;
                previewElement.className = 'relative group bg-white rounded-lg overflow-hidden shadow-sm border border-slate-200 mb-4';
                previewElement.innerHTML = `
                    <div class="relative aspect-square">
                        <img src="${e.target.result}" 
                             alt="${file.name}" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <button type="button" onclick="removeNewImage('${previewId}', '${file.name}')" 
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
                        <textarea name="new_captions[]" 
                                  class="w-full px-3 py-2 text-xs border border-slate-200 rounded focus:ring-1 focus:ring-accent focus:border-transparent" 
                                  rows="2" 
                                  placeholder="Keterangan foto..."></textarea>
                    </div>
                `;

                newImagesPreview.appendChild(previewElement);
                console.log('Preview added for:', file.name);
            };
            reader.readAsDataURL(file);
        });
    }

    // Remove new image
    function removeNewImage(previewId, fileName) {
        console.log('Removing image:', fileName);

        // Hapus file dari array berdasarkan nama
        const fileIndex = newImageFiles.findIndex(f => f.name === fileName);
        if (fileIndex !== -1) {
            newImageFiles.splice(fileIndex, 1);
            console.log('File removed from array, remaining:', newImageFiles.length);
        }

        // Remove DOM element
        const element = document.getElementById(`new-preview-${previewId}`);
        if (element) {
            element.remove();
            console.log('Preview element removed');
        }

        // Update file input
        updateFileInput();

        // Update total images count
        updateTotalImagesCount();
    }

    // Update file input dengan semua file yang dipilih
    function updateFileInput() {
        console.log('Updating file input with', newImageFiles.length, 'files');

        // Buat new DataTransfer object
        const dataTransfer = new DataTransfer();

        // Tambahkan semua file ke DataTransfer
        newImageFiles.forEach(file => {
            dataTransfer.items.add(file);
        });

        // Assign files ke input
        imageInput.files = dataTransfer.files;

        // Log untuk debugging
        console.log('Input files updated:', imageInput.files.length);
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';

        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }

    // Update total images count
    function updateTotalImagesCount() {
        let existingCount = 0;
        if (existingImagesContainer) {
            existingCount = existingImagesContainer.querySelectorAll('.group').length;
        }

        const newCount = newImagesPreview.querySelectorAll('.group').length;
        const totalCount = existingCount + newCount;

        if (totalImagesCountElement) {
            totalImagesCountElement.textContent = totalCount;
        }
    }

    // Delete existing image via AJAX
    function deleteImage(imageId) {
        if (!confirm('Hapus foto ini?')) return;

        // URL untuk delete image
        const url = "{{ route('admin.galleries.gallery-images.destroy', ':imageId') }}".replace(':imageId', imageId);
        console.log('Deleting image:', imageId, 'URL:', url);

        fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    if (response.status === 404) {
                        throw new Error(`Endpoint not found (404)`);
                    } else if (response.status === 403) {
                        throw new Error('Unauthorized (403)');
                    } else if (response.status === 500) {
                        throw new Error('Server error (500)');
                    } else {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Hapus elemen dari DOM
                    const imageElement = document.querySelector(`[data-image-id="${imageId}"]`);
                    if (imageElement) {
                        imageElement.remove();
                    }

                    // Update total images count
                    updateTotalImagesCount();

                    alert('Foto berhasil dihapus');
                } else {
                    alert('Gagal menghapus foto: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error details:', error);
                alert('Terjadi kesalahan: ' + error.message);
            });
    }

    // Form validation before submit
    document.getElementById('galleryForm').addEventListener('submit', function(e) {
        // Validasi minimal ada satu gambar (existing atau baru)
        const existingCount = existingImagesContainer ? existingImagesContainer.querySelectorAll('.group').length : 0;
        const newCount = newImagesPreview.querySelectorAll('.group').length;

        if (existingCount === 0 && newCount === 0) {
            e.preventDefault();
            alert('Gallery harus memiliki minimal 1 foto!');
            return false;
        }

        return true;
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

    #new-images-preview img {
        transition: transform 0.3s ease;
    }

    #new-images-preview img:hover {
        transform: scale(1.05);
    }

    /* Style for file input */
    input[type="file"]::-webkit-file-upload-button {
        background: #0ea5e9;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Style untuk input time */
    input[type="time"]::-webkit-calendar-picker-indicator {
        background: none;
        display: none;
    }

    input[type="time"] {
        font-family: monospace;
    }

    /* Custom time picker styling */
    input[type="time"]:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
    }
</style>
@endpush