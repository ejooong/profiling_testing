@extends('layouts.front')

@section('title', 'Galeri - NasDem Bojonegoro')

@section('content')
<!-- Hero Section with Particles Animation -->
<section class="nasdem-gradient py-16 md:py-20 full-width relative overflow-hidden">
    <!-- Animated Background Particles -->
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
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 fade-in-up">Galeri Kegiatan</h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-8 fade-in-up animation-delay-100">Dokumentasi kegiatan dan acara Partai NasDem Kabupaten Bojonegoro</p>

            <!-- Animated CTA Button -->
            <div class="fade-in-up animation-delay-200">
                <a href="#gallery-grid" class="inline-flex items-center bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-xl font-bold hover:bg-white/20 transition duration-300 shadow-lg hover:shadow-xl border border-white/20">
                    <i class="fas fa-images mr-3"></i>Lihat Galeri
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="full-width bg-gray-50 py-12 md:py-16">
    <div class="px-4 sm:px-6 lg:px-8 mx-auto">
        <!-- Category Filter -->
        <div class="mb-10 md:mb-12 fade-in-up">
            <div class="flex flex-wrap justify-center gap-3 md:gap-4 mb-6">
                <button class="filter-btn {{ $category == 'all' ? 'active' : '' }}" data-category="all">
                    <i class="fas fa-layer-group mr-2"></i>Semua
                </button>
                <button class="filter-btn {{ $category == 'pelantikan' ? 'active' : '' }}" data-category="pelantikan">
                    <i class="fas fa-user-tie mr-2"></i>Pelantikan
                </button>
                <button class="filter-btn {{ $category == 'sosial' ? 'active' : '' }}" data-category="sosial">
                    <i class="fas fa-hands-helping mr-2"></i>Bakti Sosial
                </button>
                <button class="filter-btn {{ $category == 'rapat' ? 'active' : '' }}" data-category="rapat">
                    <i class="fas fa-handshake mr-2"></i>Rapat Kerja
                </button>
                <button class="filter-btn {{ $category == 'kunjungan' ? 'active' : '' }}" data-category="kunjungan">
                    <i class="fas fa-map-marked-alt mr-2"></i>Kunjungan
                </button>
                <button class="filter-btn {{ $category == 'pelatihan' ? 'active' : '' }}" data-category="pelatihan">
                    <i class="fas fa-graduation-cap mr-2"></i>Pelatihan
                </button>
                <button class="filter-btn {{ $category == 'kerjasama' ? 'active' : '' }}" data-category="kerjasama">
                    <i class="fas fa-file-contract mr-2"></i>Kerjasama
                </button>
            </div>

            <div class="text-center fade-in-up animation-delay-100">
                <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full shadow-lg border border-white/20">
                    <div class="w-3 h-3 rounded-full mr-2 bg-green-400 animate-pulse"></div>
                    <span class="text-white font-medium">Menampilkan <span id="gallery-count" class="font-bold">{{ $galleries->count() }}</span> album galeri</span>
                </div>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div id="gallery-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 md:gap-8">
            @forelse($galleries as $index => $gallery)
            <div class="gallery-item fade-in-up animation-delay-{{ min($index, 5) * 100 }}" data-category="{{ $gallery->category }}">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover-card group">
                    <div class="relative h-56 md:h-60 overflow-hidden">
                        @if($gallery->featured_image)
                        <img src="{{ $gallery->featured_image->image_url }}"
                            alt="{{ $gallery->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-images text-gray-400 text-4xl"></i>
                        </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute top-4 left-4">
                            <span class="category-badge {{ $gallery->category_color }}">
                                {{ strtoupper($gallery->category_label) }}
                            </span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform translate-y-2 group-hover:translate-y-0">
                            <div class="flex items-center justify-between text-white">
                                <div class="flex items-center">
                                    <i class="fas fa-images mr-2"></i>
                                    <span class="text-sm font-medium">{{ $gallery->image_count }} foto</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-eye mr-1"></i>
                                    <span class="text-sm">{{ number_format($gallery->views) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 md:p-6">
                        <h3 class="font-bold text-lg md:text-xl text-[#001F3F] mb-3 group-hover:text-[#001F3F] transition duration-300 line-clamp-2">
                            {{ $gallery->title }}
                        </h3>

                        <p class="text-gray-600 text-sm md:text-base mb-5 line-clamp-2">{{ $gallery->description }}</p>

                        <div class="flex flex-wrap items-center text-gray-500 text-sm mb-4 gap-3">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-[#001F3F] mr-1.5"></i>
                                <span>{{ $gallery->event_date->translatedFormat('d M Y') }}</span>
                            </div>
                            @if($gallery->location)
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-[#001F3F] mr-1.5"></i>
                                <span class="text-xs">{{ Str::limit($gallery->location, 20) }}</span>
                            </div>
                            @endif
                            @if($gallery->event_time)
                            <div class="flex items-center ml-auto">
                                <i class="fas fa-clock text-[#001F3F] mr-1.5"></i>
                                <span>{{ $gallery->event_time }}</span>
                            </div>
                            @endif
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <a href="{{ route('gallery.show', $gallery->slug) }}" class="gallery-view-btn">
                                <span>Lihat Album</span>
                                <i class="fas fa-arrow-right ml-2 text-xs transform group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>

                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="fas fa-images mr-1"></i>
                                <span>{{ $gallery->image_count }} foto</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12 fade-in-up">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-6">
                    <i class="fas fa-images text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum ada gallery</h3>
                <p class="text-gray-500">Gallery akan segera tersedia.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($galleries->hasPages())
        <div class="mt-12 md:mt-16 fade-in-up">
            <div class="flex justify-center">
                {{ $galleries->links('vendor.pagination.tailwind') }}
            </div>
            <div class="text-center mt-4">
                <p class="text-gray-600 text-sm">Halaman {{ $galleries->currentPage() }} dari {{ $galleries->lastPage() }} • Total {{ $totalGalleries }} album</p>
            </div>
        </div>
        @endif

        <!-- Call to Action -->
        <div class="mt-16 md:mt-20 bg-gradient-to-r from-[#001F3F] via-blue-800 to-blue-900 rounded-2xl shadow-xl p-8 md:p-12 text-white text-center overflow-hidden relative fade-in-up">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
            </div>

            <div class="relative max-w-2xl mx-auto z-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/20 mb-6">
                    <i class="fas fa-camera-retro text-3xl text-white"></i>
                </div>
                <h3 class="text-2xl md:text-3xl font-bold mb-4">Kirim Dokumentasi Kegiatan Anda</h3>
                <p class="text-gray-200 text-lg mb-6">Bagi pengurus DPC/DPRT yang ingin dokumentasi kegiatan ditampilkan di galeri resmi Partai NasDem Bojonegoro</p>
                <button class="cta-submit-btn" onclick="showContactModal()">
                    <i class="fas fa-paper-plane mr-3"></i>Kirim Foto Kegiatan
                </button>
                <p class="text-gray-300 text-sm mt-4">
                    <i class="fas fa-info-circle mr-1"></i>
                    Format: JPG/PNG, maksimal 10MB per foto
                </p>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="mt-12 md:mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="stats-card fade-in-up animation-delay-100">
                <div class="icon-wrapper bg-blue-100">
                    <i class="fas fa-images text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-[#001F3F] mb-2">Total Galeri</h3>
                <p class="text-gray-600 mb-1">Album dokumentasi kegiatan</p>
                <p class="text-gray-800 font-semibold text-3xl">{{ $totalGalleries }}+</p>
                <div class="mt-4 text-sm text-gray-500">
                    <i class="fas fa-calendar-plus text-blue-500 mr-1"></i>
                    @php
                    $newThisMonth = App\Models\Gallery::where('is_published', true)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count();
                    @endphp
                    {{ $newThisMonth }} album baru bulan ini
                </div>
            </div>

            <div class="stats-card fade-in-up animation-delay-200">
                <div class="icon-wrapper bg-green-100">
                    <i class="fas fa-photo-video text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-[#001F3F] mb-2">Total Foto</h3>
                <p class="text-gray-600 mb-1">Dokumentasi visual kegiatan</p>
                <p class="text-gray-800 font-semibold text-3xl">{{ $totalImages }}+</p>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mr-2">
                            <div class="bg-green-500 h-1.5 rounded-full" style="width: 85%"></div>
                        </div>
                        <span>85%</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Foto berkualitas HD</p>
                </div>
            </div>

            <div class="stats-card fade-in-up animation-delay-300">
                <div class="icon-wrapper bg-purple-100">
                    <i class="fas fa-eye text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-[#001F3F] mb-2">Total Dilihat</h3>
                <p class="text-gray-600 mb-1">Pengunjung galeri</p>
                @php
                $totalViews = App\Models\Gallery::where('is_published', true)->sum('views');
                @endphp
                <p class="text-gray-800 font-semibold text-3xl">{{ $totalViews >= 1000 ? number_format($totalViews / 1000, 1) . 'K' : $totalViews }}</p>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <div class="flex -space-x-2 mr-3">
                        <div class="w-8 h-8 rounded-full bg-blue-500 border-2 border-white"></div>
                        <div class="w-8 h-8 rounded-full bg-green-500 border-2 border-white"></div>
                        <div class="w-8 h-8 rounded-full bg-yellow-500 border-2 border-white"></div>
                        <div class="w-8 h-8 rounded-full bg-purple-500 border-2 border-white">+97</div>
                    </div>
                    <span>100+ pengunjung/hari</span>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Contact Modal -->
<div id="contactModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-[#001F3F]">Kirim Gallery</h3>
                <button onclick="closeContactModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form id="galleryContactForm" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#001F3F] focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#001F3F] focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                    <input type="tel" name="phone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#001F3F] focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Gallery</label>
                    <input type="text" name="gallery_title" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#001F3F] focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea name="message" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#001F3F] focus:border-transparent"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lampiran (opsional)</label>
                    <input type="file" name="attachment"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#001F3F] focus:border-transparent"
                        accept=".jpg,.jpeg,.png,.zip,.rar">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, atau ZIP (maks. 10MB)</p>
                </div>

                <button type="submit" class="w-full bg-[#001F3F] text-white py-3 rounded-lg font-medium hover:bg-blue-900 transition duration-300">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Proposal
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Filter Gallery Items
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    const galleryCount = document.getElementById('gallery-count');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.dataset.category;

            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // Update URL with filter parameter
            const url = new URL(window.location);
            if (category === 'all') {
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('category', category);
            }
            window.location.href = url.toString();
        });
    });

    // Contact Modal Functions
    function showContactModal() {
        document.getElementById('contactModal').classList.remove('hidden');
        document.getElementById('contactModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeContactModal() {
        document.getElementById('contactModal').classList.add('hidden');
        document.getElementById('contactModal').classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // Handle contact form submission
    document.getElementById('galleryContactForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = `
        <div class="flex items-center justify-center">
            <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin mr-3"></div>
            <span>Mengirim...</span>
        </div>
    `;
        submitBtn.disabled = true;

        // Simulate API call
        setTimeout(() => {
            alert('Terima kasih! Proposal gallery Anda telah kami terima. Tim kami akan menghubungi Anda dalam 1x24 jam.');
            closeContactModal();
            this.reset();

            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 2000);
    });

    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeContactModal();
        }
    });

    // Close modal when clicking outside
    document.getElementById('contactModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeContactModal();
        }
    });

    // Initialize animations on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const fadeElements = document.querySelectorAll('.fade-in-up');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        fadeElements.forEach(el => observer.observe(el));
    });
</script>
@endpush

@push('styles')
<style>
    /* Custom colors */
    .nasdem-navy-color {
        color: #001F3F;
    }

    .nasdem-navy-bg {
        background-color: #001F3F;
    }

    /* Hero Section Particles - Sama seperti contact page */
    .particles {
        position: absolute;
        inset: 0;
        overflow: hidden;
    }

    .particle {
        position: absolute;
        width: var(--size);
        height: var(--size);
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        animation: float var(--duration) linear infinite var(--delay);
        left: var(--x);
        top: var(--y);
    }

    @keyframes float {
        0% {
            transform: translateY(0) translateX(0);
            opacity: 0;
        }

        10% {
            opacity: 1;
        }

        90% {
            opacity: 1;
        }

        100% {
            transform: translateY(-100vh) translateX(20px);
            opacity: 0;
        }
    }

    /* Animations */
    @keyframes fade-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .fade-in-up.animated {
        opacity: 1;
        transform: translateY(0);
    }

    .animation-delay-100 {
        transition-delay: 0.1s;
    }

    .animation-delay-200 {
        transition-delay: 0.2s;
    }

    .animation-delay-300 {
        transition-delay: 0.3s;
    }

    .animation-delay-400 {
        transition-delay: 0.4s;
    }

    .animation-delay-500 {
        transition-delay: 0.5s;
    }

    /* Filter Buttons */
    .filter-btn {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
        color: #4B5563;
        border: 2px solid #E5E7EB;
        cursor: pointer;
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border-color: #001F3F;
        color: #001F3F;
    }

    .filter-btn.active {
        background: #001F3F;
        color: white;
        border-color: #001F3F;
        box-shadow: 0 10px 20px rgba(0, 31, 63, 0.2);
    }

    .filter-btn i {
        font-size: 12px;
    }

    /* Category Badge */
    .category-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: bold;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
    }

    /* Gallery Item Hover Effects */
    .hover-card {
        transition: all 0.4s ease;
        border-bottom: 3px solid transparent;
    }

    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        border-bottom: 3px solid #001F3F;
    }

    .gallery-view-btn {
        display: inline-flex;
        align-items: center;
        color: #001F3F;
        font-weight: 600;
        font-size: 14px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px 0;
        position: relative;
        overflow: hidden;
    }

    .gallery-view-btn::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: #001F3F;
        transform: scaleX(0);
        transform-origin: right;
        transition: transform 0.3s ease;
    }

    .gallery-view-btn:hover::after {
        transform: scaleX(1);
        transform-origin: left;
    }

    /* CTA Submit Button */
    .cta-submit-btn {
        display: inline-flex;
        align-items: center;
        padding: 16px 32px;
        background: white;
        color: #001F3F;
        border-radius: 12px;
        font-weight: bold;
        font-size: 18px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
    }

    .cta-submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
        background: #F3F4F6;
    }

    .cta-submit-btn:active {
        transform: translateY(-1px);
    }

    /* Stats Cards */
    .stats-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
    }

    .stats-card.animated {
        opacity: 1;
        transform: translateY(0);
    }

    .stats-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        transition: transform 0.3s ease;
    }

    .stats-card:hover .icon-wrapper {
        transform: scale(1.1) rotate(5deg);
    }

    /* Line Clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Modal */
    #contactModal {
        transition: opacity 0.3s ease;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .filter-btn {
            padding: 8px 16px;
            font-size: 13px;
        }

        .filter-btn i {
            margin-right: 4px;
            font-size: 11px;
        }

        .category-badge {
            font-size: 10px;
            padding: 4px 8px;
        }

        .stats-card {
            padding: 20px;
        }

        .icon-wrapper {
            width: 60px;
            height: 60px;
        }

        .icon-wrapper i {
            font-size: 20px;
        }
    }

    @media (max-width: 640px) {
        .grid-cols-2 {
            grid-template-columns: 1fr;
        }

        .filter-btn {
            padding: 6px 12px;
            font-size: 12px;
        }
    }
</style>
@endpush