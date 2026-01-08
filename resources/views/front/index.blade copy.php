@extends('layouts.front')

@section('title', 'Beranda - NasDem Bojonegoro')

@section('content')
<!-- Hero Slider Section -->
<section class="relative overflow-hidden">
    <div class="swiper heroSwiper">
        <div class="swiper-wrapper">
            @foreach($headlineNews as $index => $news)
            <div class="swiper-slide relative">
                @if($news->featured_image && file_exists(public_path('storage/' . $news->featured_image)))
                <img src="{{ asset('storage/' . $news->featured_image) }}" 
                     alt="{{ $news->title }}" 
                     class="w-full h-[500px] md:h-[600px] object-cover">
                @else
                <div class="w-full h-[500px] md:h-[600px] bg-gradient-to-r from-[#001F3F] to-blue-800"></div>
                @endif
                
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#001F3F]/90 via-[#001F3F]/70 to-transparent"></div>
                
                <!-- Content -->
                <div class="absolute inset-0 flex items-center">
                    <div class="px-4 sm:px-6 lg:px-8 w-full">
                        <div class="max-w-3xl fade-in-up" data-delay="{{ $index * 100 }}">
                            <span class="inline-flex items-center bg-white/20 backdrop-blur-sm text-white text-sm font-bold px-4 py-2 rounded-full mb-6">
                                <div class="w-2 h-2 rounded-full bg-blue-400 mr-2 animate-pulse"></div>
                                {{ $news->category->name ?? 'Berita' }}
                            </span>
                            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                                {{ $news->title }}
                            </h1>
                            <p class="text-gray-200 text-lg md:text-xl mb-8 opacity-90">{{ Str::limit($news->excerpt, 150) }}</p>
                            <div class="flex flex-wrap gap-4">
                                <a href="{{ route('news.show', $news->slug) }}" 
                                   class="hero-btn-primary">
                                    <span>Baca Selengkapnya</span>
                                    <i class="fas fa-arrow-right ml-3 transform group-hover:translate-x-1 transition-transform"></i>
                                </a>
                                @if($news->category)
                                <a href="{{ route('news.category', $news->category->slug) }}" 
                                   class="hero-btn-secondary">
                                    <i class="fas fa-folder mr-2"></i>Lebih Banyak {{ $news->category->name }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Navigation buttons -->
        <div class="swiper-button-next hero-nav-btn">
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="swiper-button-prev hero-nav-btn">
            <i class="fas fa-chevron-left"></i>
        </div>
        
        <!-- Pagination -->
        <div class="swiper-pagination hero-pagination"></div>
        
        <!-- Progress Bar -->
        <div class="hero-progress">
            <div class="hero-progress-bar"></div>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class=" bg-gray-50">
    <div class="px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Latest News Section -->
            <div class="lg:col-span-2">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-[#001F3F] mb-2">Berita Terbaru</h2>
                        <p class="text-gray-600">Informasi terkini dari Partai NasDem Bojonegoro</p>
                    </div>
                    <a href="{{ route('news.index') }}" class="section-cta-btn">
                        Lihat Semua <i class="fas fa-arrow-right ml-2 text-sm"></i>
                    </a>
                </div>
                
                <!-- Featured News -->
                @if($latestNews->isNotEmpty())
                <div class="mb-12">
                    <div class="featured-news-card group">
                        @if($latestNews->first()->featured_image && file_exists(public_path('storage/' . $latestNews->first()->featured_image)))
                        <div class="featured-news-image">
                            <img src="{{ asset('storage/' . $latestNews->first()->featured_image) }}" 
                                 alt="{{ $latestNews->first()->title }}" 
                                 class="group-hover:scale-110">
                        </div>
                        @else
                        <div class="featured-news-image">
                            <div class="w-full h-full bg-gradient-to-r from-[#001F3F] to-blue-800 flex items-center justify-center">
                                <i class="fas fa-newspaper text-white text-6xl opacity-50"></i>
                            </div>
                        </div>
                        @endif
                        <div class="featured-news-content">
                            <div class="featured-news-meta">
                                <span class="featured-news-category" style="background-color: {{ $latestNews->first()->category->color ?? '#001F3F' }}">
                                    {{ $latestNews->first()->category->name ?? 'Berita' }}
                                </span>
                                <div class="flex items-center text-gray-500 text-sm">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    {{ $latestNews->first()->published_at->format('d F Y') }}
                                </div>
                            </div>
                            <h3 class="featured-news-title">
                                <a href="{{ route('news.show', $latestNews->first()->slug) }}">{{ $latestNews->first()->title }}</a>
                            </h3>
                            <p class="featured-news-excerpt">{{ Str::limit($latestNews->first()->excerpt, 180) }}</p>
                            <a href="{{ route('news.show', $latestNews->first()->slug) }}" class="featured-news-link">
                                Baca Artikel Lengkap <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- News List -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($latestNews->skip(1)->take(4) as $news)
                    <div class="news-item-card fade-in-up animation-delay-{{ ($loop->index + 1) * 100 }}">
                        <div class="news-item-image">
                            @if($news->featured_image && file_exists(public_path('storage/' . $news->featured_image)))
                            <img src="{{ asset('storage/' . $news->featured_image) }}" 
                                 alt="{{ $news->title }}" 
                                 class="group-hover:scale-110">
                            @else
                            <div class="w-full h-full bg-gradient-to-r from-[#001F3F] to-blue-800 flex items-center justify-center">
                                <i class="fas fa-newspaper text-white text-4xl opacity-50"></i>
                            </div>
                            @endif
                            <div class="news-item-category" style="background-color: {{ $news->category->color ?? '#001F3F' }}">
                                {{ $news->category->name ?? 'Berita' }}
                            </div>
                        </div>
                        <div class="news-item-content">
                            <div class="news-item-meta">
                                <span class="news-item-date">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    {{ $news->published_at->format('d M Y') }}
                                </span>
                                <span class="news-item-views">
                                    <i class="fas fa-eye mr-2"></i>
                                    {{ number_format($news->views) }}
                                </span>
                            </div>
                            <h4 class="news-item-title">
                                <a href="{{ route('news.show', $news->slug) }}">{{ Str::limit($news->title, 70) }}</a>
                            </h4>
                            <p class="news-item-excerpt">{{ Str::limit($news->excerpt, 100) }}</p>
                            <a href="{{ route('news.show', $news->slug) }}" class="news-item-link">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Membership Check -->
                <div class="bg-gradient-to-br from-[#001F3F] to-blue-900 rounded-2xl p-6 shadow-xl">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-id-card text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Cek Keanggotaan</h3>
                        <p class="text-gray-300 text-sm">Masukkan NIK untuk mengecek status keanggotaan Anda</p>
                    </div>
                    
                    <form action="{{ route('membership.check') }}" method="GET" class="space-y-4">
                        <div class="relative">
                            <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" 
                                   name="nik" 
                                   placeholder="16 digit NIK" 
                                   maxlength="16"
                                   pattern="[0-9]{16}"
                                   title="Masukkan 16 digit NIK"
                                   class="membership-input"
                                   required>
                        </div>
                        <button type="submit" class="membership-submit-btn">
                            <i class="fas fa-search mr-3"></i>Cek Status Keanggotaan
                        </button>
                    </form>
                    
                    <p class="text-gray-400 text-xs text-center mt-4">
                        <i class="fas fa-shield-alt mr-1"></i>Data Anda aman dan terjamin kerahasiaannya
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-[#001F3F] mb-6">Akses Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('kader.register') }}" class="quick-link-item bg-blue-50 hover:bg-blue-100">
                            <div class="quick-link-icon bg-blue-100 text-blue-600">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="flex-1">
                                <span class="quick-link-text">Daftar Kader Baru</span>
                                <span class="quick-link-desc">Bergabung bersama kami</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </a>
                        
                        <a href="{{ route('structure') }}" class="quick-link-item bg-green-50 hover:bg-green-100">
                            <div class="quick-link-icon bg-green-100 text-green-600">
                                <i class="fas fa-sitemap"></i>
                            </div>
                            <div class="flex-1">
                                <span class="quick-link-text">Struktur Organisasi</span>
                                <span class="quick-link-desc">Lihat kepengurusan</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </a>
                        
                        <a href="{{ route('gallery') }}" class="quick-link-item bg-purple-50 hover:bg-purple-100">
                            <div class="quick-link-icon bg-purple-100 text-purple-600">
                                <i class="fas fa-images"></i>
                            </div>
                            <div class="flex-1">
                                <span class="quick-link-text">Galeri Kegiatan</span>
                                <span class="quick-link-desc">Foto & video dokumentasi</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </a>
                        
                        <a href="{{ route('contact') }}" class="quick-link-item bg-yellow-50 hover:bg-yellow-100">
                            <div class="quick-link-icon bg-yellow-100 text-yellow-600">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="flex-1">
                                <span class="quick-link-text">Hubungi Kami</span>
                                <span class="quick-link-desc">Layanan dan kontak</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </a>
                    </div>
                </div>

                <!-- Popular News -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-[#001F3F] mb-6">Berita Populer</h3>
                    <div class="space-y-4">
                        @foreach($popularNews ?? [] as $popular)
                        <a href="{{ route('news.show', $popular->slug) }}" class="popular-news-item group">
                            <div class="popular-news-image">
                                @if($popular->featured_image && file_exists(public_path('storage/' . $popular->featured_image)))
                                <img src="{{ asset('storage/' . $popular->featured_image) }}" 
                                     alt="{{ $popular->title }}"
                                     class="group-hover:scale-105">
                                @else
                                <div class="w-full h-full bg-gradient-to-r from-[#001F3F] to-blue-800 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-white text-lg opacity-50"></i>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="popular-news-title">{{ Str::limit($popular->title, 50) }}</h4>
                                <div class="popular-news-meta">
                                    <span><i class="fas fa-eye mr-1"></i> {{ number_format($popular->views) }}</span>
                                    <span>{{ $popular->published_at->format('d M') }}</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Mission Section -->
        <div class="mt-20 py-16 bg-gradient-to-r from-[#001F3F] to-blue-900 rounded-2xl shadow-xl overflow-hidden relative">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
            </div>
            
            <div class="relative px-4 sm:px-6 lg:px-8 mx-auto text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/20 mb-6">
                    <i class="fas fa-bullseye text-white text-3xl"></i>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Menuju Bojonegoro Maju, Adil, dan Sejahtera</h2>
                <p class="text-xl text-gray-200 mb-10 max-w-3xl mx-auto">
                    Bersama Rakyat, NasDem Berkomitmen Membangun Desa, Kecamatan, dan Kabupaten yang Mandiri melalui program-program nyata untuk kesejahteraan masyarakat.
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="{{ route('profile') }}" class="mission-btn-primary">
                        <i class="fas fa-info-circle mr-3"></i>Pelajari Visi & Misi
                    </a>
                    <a href="{{ route('contact') }}" class="mission-btn-secondary">
                        <i class="fas fa-handshake mr-3"></i>Bergabung Bersama Kami
                    </a>
                </div>
            </div>
        </div>

        <!-- Category Highlights -->
        <div class="mt-20">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-[#001F3F] mb-4">Kategori Berita</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Temukan berita berdasarkan kategori yang Anda minati</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($categories ?? [] as $category)
                <a href="{{ route('news.category', $category->slug) }}" 
                   class="category-card group"
                   style="--category-color: {{ $category->color ?? '#001F3F' }}">
                    <div class="category-icon" style="background-color: {{ $category->color ?? '#001F3F' }}">
                        <i class="fas fa-folder text-white"></i>
                    </div>
                    <h3 class="category-name">{{ $category->name }}</h3>
                    <div class="category-count">{{ $category->beritas()->count() ?? 0 }} Berita</div>
                    <div class="category-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
// Initialize Hero Swiper
const heroSwiper = new Swiper('.heroSwiper', {
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    loop: true,
    speed: 1000,
    effect: 'fade',
    fadeEffect: {
        crossFade: true
    },
    pagination: {
        el: '.hero-pagination',
        clickable: true,
        dynamicBullets: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    on: {
        init: function() {
            updateProgressBar(this);
        },
        slideChange: function() {
            updateProgressBar(this);
        }
    }
});

// Progress Bar Animation
function updateProgressBar(swiper) {
    const progressBar = document.querySelector('.hero-progress-bar');
    if (progressBar) {
        const progress = (swiper.activeIndex + 1) / swiper.slides.length * 100;
        progressBar.style.width = `${progress}%`;
    }
}

// Animated Number Counting (untuk tampilan lain yang memerlukan)
document.addEventListener('DOMContentLoaded', function() {
    const countElements = document.querySelectorAll('.stats-number');
    
    if (countElements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const target = parseInt(element.getAttribute('data-count') || 0);
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    let current = 0;
                    
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            element.textContent = target.toLocaleString();
                            clearInterval(timer);
                        } else {
                            element.textContent = Math.floor(current).toLocaleString();
                        }
                    }, 16);
                    
                    observer.unobserve(element);
                }
            });
        }, { threshold: 0.5 });

        countElements.forEach(el => observer.observe(el));
    }
});

// Initialize animations on scroll
document.addEventListener('DOMContentLoaded', function() {
    const fadeElements = document.querySelectorAll('.fade-in-up');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.getAttribute('data-delay') || 0;
                setTimeout(() => {
                    entry.target.classList.add('animated');
                }, parseInt(delay));
            }
        });
    }, { 
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    fadeElements.forEach(el => observer.observe(el));
});

// Bounce-in animation (jika masih ada elemen dengan class ini)
const bounceElements = document.querySelectorAll('.bounce-in');
bounceElements.forEach(el => {
    const delay = el.classList.contains('animation-delay-100') ? 100 :
                  el.classList.contains('animation-delay-200') ? 200 :
                  el.classList.contains('animation-delay-300') ? 300 :
                  el.classList.contains('animation-delay-400') ? 400 : 0;
    
    setTimeout(() => {
        el.classList.add('animated');
    }, delay);
});

// Membership form validation
const membershipForm = document.querySelector('form[action*="membership.check"]');
if (membershipForm) {
    const nikInput = membershipForm.querySelector('input[name="nik"]');
    
    nikInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 16);
    });
    
    membershipForm.addEventListener('submit', function(e) {
        if (nikInput.value.length !== 16) {
            e.preventDefault();
            alert('Masukkan 16 digit NIK yang valid');
            nikInput.focus();
        }
    });
}

// Card hover effects
const cards = document.querySelectorAll('.news-item-card, .category-card, .quick-link-item');
cards.forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-8px)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});
</script>
@endpush

@push('styles')
<style>
/* Hero Slider */
.heroSwiper {
    height: 500px;
}

@media (min-width: 768px) {
    .heroSwiper {
        height: 600px;
    }
}

.hero-nav-btn {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(0, 31, 63, 0.7);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.2);
    color: white;
    transition: all 0.3s ease;
}

.hero-nav-btn:hover {
    background: #001F3F;
    border-color: white;
    transform: scale(1.1);
}

.hero-nav-btn::after {
    font-size: 16px;
    font-weight: bold;
}

.hero-pagination {
    bottom: 20px !important;
}

.hero-pagination .swiper-pagination-bullet {
    width: 10px;
    height: 10px;
    background: rgba(255, 255, 255, 0.5);
    opacity: 1;
    transition: all 0.3s ease;
}

.hero-pagination .swiper-pagination-bullet-active {
    background: white;
    transform: scale(1.2);
}

.hero-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: rgba(255, 255, 255, 0.2);
    z-index: 10;
}

.hero-progress-bar {
    height: 100%;
    background: white;
    width: 0%;
    transition: width 5s linear;
}

/* Hero Buttons */
.hero-btn-primary {
    display: inline-flex;
    align-items: center;
    padding: 12px 24px;
    background: white;
    color: #001F3F;
    border-radius: 10px;
    font-weight: bold;
    font-size: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.hero-btn-primary:hover {
    background: #F3F4F6;
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}

.hero-btn-secondary {
    display: inline-flex;
    align-items: center;
    padding: 12px 24px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.hero-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: white;
    transform: translateY(-3px);
}

/* Featured News */
.featured-news-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    transition: all 0.4s ease;
}

.featured-news-card:hover {
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
}

.featured-news-image {
    height: 300px;
    overflow: hidden;
}

.featured-news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.7s ease;
}

.featured-news-content {
    padding: 32px;
}

.featured-news-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.featured-news-category {
    padding: 6px 16px;
    border-radius: 20px;
    color: white;
    font-size: 14px;
    font-weight: 600;
}

.featured-news-title {
    font-size: 28px;
    font-weight: bold;
    color: #001F3F;
    margin-bottom: 16px;
    line-height: 1.3;
}

.featured-news-title a {
    color: inherit;
    text-decoration: none;
}

.featured-news-title a:hover {
    text-decoration: underline;
}

.featured-news-excerpt {
    font-size: 18px;
    line-height: 1.6;
    color: #4B5563;
    margin-bottom: 24px;
}

.featured-news-link {
    display: inline-flex;
    align-items: center;
    color: #001F3F;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.featured-news-link:hover {
    color: #0a2f5a;
    transform: translateX(5px);
}

.featured-news-link i {
    margin-left: 8px;
    transition: transform 0.3s ease;
}

.featured-news-link:hover i {
    transform: translateX(5px);
}

/* News Item Cards */
.news-item-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    opacity: 0;
    transform: translateY(20px);
}

.news-item-card.animated {
    opacity: 1;
    transform: translateY(0);
}

.news-item-card:hover {
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
    transform: translateY(-8px);
}

.news-item-image {
    height: 200px;
    position: relative;
    overflow: hidden;
}

.news-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.7s ease;
}

.news-item-card:hover .news-item-image img {
    transform: scale(1.1);
}

.news-item-category {
    position: absolute;
    top: 16px;
    left: 16px;
    padding: 4px 12px;
    border-radius: 12px;
    color: white;
    font-size: 12px;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.news-item-content {
    padding: 24px;
}

.news-item-meta {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: #6B7280;
    margin-bottom: 12px;
}

.news-item-title {
    font-size: 18px;
    font-weight: 600;
    color: #001F3F;
    margin-bottom: 12px;
    line-height: 1.4;
}

.news-item-title a {
    color: inherit;
    text-decoration: none;
}

.news-item-title a:hover {
    color: #0a2f5a;
    text-decoration: underline;
}

.news-item-excerpt {
    font-size: 14px;
    line-height: 1.6;
    color: #4B5563;
    margin-bottom: 16px;
}

.news-item-link {
    display: inline-flex;
    align-items: center;
    color: #001F3F;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.news-item-link:hover {
    color: #0a2f5a;
    transform: translateX(3px);
}

/* Membership Section */
.membership-input {
    width: 100%;
    padding: 14px 16px 14px 42px;
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid transparent;
    border-radius: 10px;
    font-size: 16px;
    color: #001F3F;
    transition: all 0.3s ease;
}

.membership-input:focus {
    outline: none;
    border-color: white;
    box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
}

.membership-submit-btn {
    width: 100%;
    padding: 16px;
    background: white;
    color: #001F3F;
    border: none;
    border-radius: 10px;
    font-weight: bold;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.membership-submit-btn:hover {
    background: #F3F4F6;
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}

/* Quick Links */
.quick-link-item {
    display: flex;
    align-items: center;
    padding: 16px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    gap: 12px;
}

.quick-link-item:hover {
    transform: translateX(5px);
}

.quick-link-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 18px;
}

.quick-link-text {
    display: block;
    font-weight: 600;
    color: #001F3F;
    margin-bottom: 2px;
}

.quick-link-desc {
    display: block;
    font-size: 12px;
    color: #6B7280;
}

/* Popular News */
.popular-news-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.popular-news-item:hover {
    background: #F9FAFB;
    transform: translateX(5px);
}

.popular-news-image {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
}

.popular-news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.popular-news-title {
    font-weight: 600;
    color: #001F3F;
    font-size: 14px;
    line-height: 1.4;
    margin-bottom: 4px;
}

.popular-news-meta {
    display: flex;
    gap: 12px;
    font-size: 12px;
    color: #6B7280;
}

/* Mission Buttons */
.mission-btn-primary {
    display: inline-flex;
    align-items: center;
    padding: 16px 32px;
    background: white;
    color: #001F3F;
    border-radius: 12px;
    font-weight: bold;
    font-size: 18px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
}

.mission-btn-primary:hover {
    background: #F3F4F6;
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
}

.mission-btn-secondary {
    display: inline-flex;
    align-items: center;
    padding: 16px 32px;
    background: transparent;
    color: white;
    border: 2px solid white;
    border-radius: 12px;
    font-weight: bold;
    font-size: 18px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.mission-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-3px);
}

/* Category Cards */
.category-card {
    position: relative;
    background: white;
    border-radius: 16px;
    padding: 32px 24px;
    text-align: center;
    text-decoration: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    overflow: hidden;
}

.category-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--category-color, #001F3F);
}

.category-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
}

.category-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 24px;
}

.category-name {
    font-size: 18px;
    font-weight: 600;
    color: #001F3F;
    margin-bottom: 8px;
}

.category-count {
    font-size: 14px;
    color: #6B7280;
    margin-bottom: 20px;
}

.category-arrow {
    opacity: 0;
    transform: translateX(-10px);
    color: var(--category-color, #001F3F);
    transition: all 0.3s ease;
}

.category-card:hover .category-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Section CTA */
.section-cta-btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    background: #001F3F;
    color: white;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.section-cta-btn:hover {
    background: #0a2f5a;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 31, 63, 0.2);
}

/* Responsive Design */
@media (max-width: 768px) {
    .heroSwiper {
        height: 400px;
    }
    
    .featured-news-image {
        height: 200px;
    }
    
    .featured-news-content {
        padding: 24px;
    }
    
    .featured-news-title {
        font-size: 22px;
    }
    
    .category-card {
        padding: 24px 16px;
    }
}

@media (max-width: 640px) {
    .grid-cols-2 {
        grid-template-columns: 1fr;
    }
    
    .news-item-image {
        height: 180px;
    }
    
    .mission-btn-primary,
    .mission-btn-secondary {
        padding: 12px 24px;
        font-size: 16px;
        width: 100%;
        justify-content: center;
    }
    
    .section-cta-btn {
        padding: 8px 16px;
        font-size: 13px;
    }
}
</style>
@endpush