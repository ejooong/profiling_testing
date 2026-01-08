@extends('layouts.front')

@section('title', $gallery->title . ' - Galeri NasDem Bojonegoro')

@section('content')
<!-- Hero Section -->
<section class="nasdem-gradient py-12 md:py-16 full-width relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="particles">
            @for ($i = 0; $i < 20; $i++)
                <div class="particle" style="
                --size: {{ rand(2, 6) }}px;
                --x: {{ rand(0, 100) }}%;
                --y: {{ rand(0, 100) }}%;
                --duration: {{ rand(10, 30) }}s;
                --delay: {{ rand(0, 10) }}s;
            ">
        </div>
        @endfor
    </div>
    </div>

    <div class="px-4 sm:px-6 lg:px-8 mx-auto relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center mb-6">
                <a href="{{ route('gallery') }}" class="text-white/80 hover:text-white transition-colors mr-3">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Galeri
                </a>
                <span class="category-badge {{ $gallery->category_color }}">
                    {{ strtoupper($gallery->category_label) }}
                </span>
            </div>

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">{{ $gallery->title }}</h1>

            <div class="flex flex-wrap items-center justify-center gap-4 text-gray-200 mb-8">
                <div class="flex items-center">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span>{{ $gallery->event_date->translatedFormat('d F Y') }}</span>
                </div>
                @if($gallery->event_time)
                <div class="flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    <span>{{ $gallery->event_time }}</span>
                </div>
                @endif
                @if($gallery->location)
                <div class="flex items-center">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    <span>{{ $gallery->location }}</span>
                </div>
                @endif
                @if($gallery->participant_count)
                <div class="flex items-center">
                    <i class="fas fa-users mr-2"></i>
                    <span>{{ number_format($gallery->participant_count) }} peserta</span>
                </div>
                @endif
            </div>

            <div class="flex items-center justify-center gap-6">
                <div class="flex items-center">
                    <i class="fas fa-images mr-2 text-xl"></i>
                    <span class="text-lg font-medium">{{ $gallery->images->count() }} foto</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-eye mr-2 text-xl"></i>
                    <span class="text-lg font-medium">{{ number_format($gallery->views) }} dilihat</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Content -->
<main class="full-width bg-gray-50 py-8 md:py-12">
    <div class="px-4 sm:px-6 lg:px-8 mx-auto">
        <!-- Description -->
        @if($gallery->description)
        <div class="mb-8 md:mb-12">
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <h2 class="text-xl font-bold text-[#001F3F] mb-4">Deskripsi Kegiatan</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($gallery->description)) !!}
                </div>
            </div>
        </div>
        @endif

        <!-- Gallery Images -->
        <div class="mb-8 md:mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-[#001F3F]">Album Foto</h2>
                <span class="text-gray-600">{{ $gallery->images->count() }} foto</span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($gallery->images as $image)
                <div class="relative group overflow-hidden rounded-xl shadow-lg bg-white">
                    <img src="{{ Storage::url($image->image_path) }}"
                        alt="{{ $image->caption ?: $gallery->title }}"
                        class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300 cursor-pointer"
                        onclick="openImageModal('{{ Storage::url($image->image_path) }}', '{{ $image->caption ?: $gallery->title }}')">

                    @if($image->caption)
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                        <p class="text-white p-4 text-sm">{{ $image->caption }}</p>
                    </div>
                    @endif

                    <div class="absolute top-4 right-4 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer"
                        onclick="openImageModal('{{ Storage::url($image->image_path) }}', '{{ $image->caption ?: $gallery->title }}')">
                        <i class="fas fa-expand text-gray-700"></i>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Image Modal -->
        <div id="imageModal" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center p-4">
            <div class="relative max-w-4xl w-full max-h-[90vh]">
                <button onclick="closeImageModal()"
                    class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                    <i class="fas fa-times text-2xl"></i>
                </button>
                <img id="modalImage" src="" alt="" class="w-full h-auto max-h-[80vh] object-contain">
                <p id="modalCaption" class="text-white text-center mt-4 text-lg"></p>
            </div>
        </div>

        <!-- Share Section -->
        <div class="mb-8 md:mb-12">
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h3 class="text-lg font-bold text-[#001F3F] mb-2">Bagikan Album Ini</h3>
                        <p class="text-gray-600">Bagikan momen spesial ini dengan yang lain</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                            target="_blank"
                            class="share-btn bg-blue-600 hover:bg-blue-700">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($gallery->title . ' ' . url()->current()) }}"
                            target="_blank"
                            class="share-btn bg-green-500 hover:bg-green-600">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <button onclick="copyLink()"
                            class="share-btn bg-gray-700 hover:bg-gray-800">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Galleries -->
        @if($relatedGalleries->count() > 0)
        <div class="mb-8 md:mb-12">
            <h2 class="text-2xl font-bold text-[#001F3F] mb-6">Gallery Lainnya</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedGalleries as $related)
                <a href="{{ route('gallery.show', $related->slug) }}"
                    class="bg-white rounded-xl shadow-lg overflow-hidden hover-card group">
                    <div class="relative h-40 overflow-hidden">
                        @if($related->featured_image)
                        <img src="{{ Storage::url($related->featured_image->image_path) }}"
                            alt="{{ $related->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-images text-gray-400 text-2xl"></i>
                        </div>
                        @endif
                        <div class="absolute top-2 left-2">
                            <span class="category-badge text-xs {{ $related->category_color }}">
                                {{ strtoupper($related->category_label) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-4">
                        <h3 class="font-bold text-[#001F3F] mb-2 line-clamp-2">{{ $related->title }}</h3>
                        <div class="flex items-center text-gray-500 text-xs">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            <span>{{ $related->event_date->translatedFormat('d M Y') }}</span>
                            <span class="mx-2">•</span>
                            <i class="fas fa-images mr-1"></i>
                            <span>{{ $related->images_count }} foto</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</main>
@endsection

@push('scripts')
<script>
    // Image Modal Functions
    function openImageModal(src, caption) {
        document.getElementById('modalImage').src = src;
        document.getElementById('modalCaption').textContent = caption;
        document.getElementById('imageModal').classList.remove('hidden');
        document.getElementById('imageModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.getElementById('imageModal').classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // Copy link function
    function copyLink() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Link berhasil disalin!');
        });
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });

    // Close modal when clicking outside
    document.getElementById('imageModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });
</script>
@endpush

@push('styles')
<style>
    .share-btn {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .share-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
</style>
@endpush