@extends('layouts.front')

@section('title', 'Berita - NasDem Bojonegoro')

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
            "></div>
            @endfor
        </div>
    </div>
    
    <div class="px-4 sm:px-6 lg:px-8 mx-auto relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 fade-in-up">Berita Terkini</h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-8 fade-in-up animation-delay-100">Informasi dan kegiatan terbaru Partai NasDem Kabupaten Bojonegoro</p>
            
            <!-- Animated CTA Button -->
            <div class="fade-in-up animation-delay-200">
                <a href="#news-grid" class="inline-flex items-center bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-xl font-bold hover:bg-white/20 transition duration-300 shadow-lg hover:shadow-xl border border-white/20">
                    <i class="fas fa-newspaper mr-3"></i>Lihat Berita
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="full-width bg-gradient-to-r from-[#E69D00] to-[#E69D00] py-12 md:py-16">
    <div class="px-4 sm:px-6 lg:px-8 mx-auto">
        <!-- Category Filter -->
        <div class="mb-10 md:mb-12 fade-in-up">
            <div class="flex flex-wrap justify-center gap-3 md:gap-4 mb-6">
                <a href="{{ route('news.index') }}" 
                   class="filter-btn {{ !request()->has('category') ? 'active' : '' }}" 
                   data-category="all">
                    <i class="fas fa-layer-group mr-2"></i>Semua
                </a>
                @foreach($categories as $category)
                <a href="{{ route('news.category', $category->slug) }}" 
                   class="filter-btn {{ request('category') == $category->slug ? 'active' : '' }}"
                   data-category="{{ $category->slug }}">
                    <i class="fas fa-folder mr-2"></i>{{ $category->name }}
                </a>
                @endforeach
            </div>
            
            @if(request()->has('category') && isset($currentCategory))
            <div class="text-center fade-in-up animation-delay-100">
                <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full shadow-lg border border-white/20">
                    <div class="w-3 h-3 rounded-full mr-2 bg-green-400 animate-pulse"></div>
                    <span class="text-white font-medium">Menampilkan berita kategori: <span class="font-bold">{{ $currentCategory->name }}</span></span>
                </div>
            </div>
            @endif
        </div>

        <div class="flex flex-col lg:flex-row gap-8 xl:gap-12">
            <!-- News List -->
            <div class="lg:w-2/3">
                @if($news->count() > 0)
                <div id="news-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 md:gap-8">
                    @foreach($news as $item)
                    <div class="news-item fade-in-up" data-category="{{ $item->category->slug }}">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover-card group">
                            <div class="relative h-56 md:h-60 overflow-hidden">
                                @if($item->featured_image)
                                <img src="{{ asset('storage/' . $item->featured_image) }}" 
                                     alt="{{ $item->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                <div class="w-full h-full bg-gradient-to-r from-gray-100 to-gray-200 flex items-center justify-center">
                                    <div class="text-center">
                                        <i class="fas fa-newspaper text-gray-400 text-5xl mb-3"></i>
                                        <p class="text-gray-500 text-sm">Tidak ada gambar</p>
                                    </div>
                                </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="absolute top-4 left-4">
                                    <span class="category-badge" style="background-color: {{ $item->category->color }}">
                                        {{ $item->category->name }}
                                    </span>
                                </div>
                                @if($item->is_featured)
                                <div class="absolute top-4 right-4">
                                    <span class="featured-badge">
                                        <i class="fas fa-star mr-1"></i>Featured
                                    </span>
                                </div>
                                @endif
                                <div class="absolute bottom-4 left-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform translate-y-2 group-hover:translate-y-0">
                                    <div class="flex items-center justify-between text-white">
                                        <div class="flex items-center">
                                            <i class="fas fa-eye mr-2"></i>
                                            <span class="text-sm font-medium">{{ $item->views }} views</span>
                                        </div>
                                        <a href="{{ route('news.show', $item->slug) }}" 
                                           class="read-more-btn">
                                            Baca <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-5 md:p-6">
                                <div class="flex flex-wrap items-center text-gray-500 text-sm mb-4 gap-2">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-[#001F3F] mr-1.5"></i>
                                        <span>{{ $item->published_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-eye text-[#001F3F] mr-1.5"></i>
                                        <span>{{ $item->views }}</span>
                                    </div>
                                    @if($item->dpc)
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-[#001F3F] mr-1.5"></i>
                                        <span class="text-xs">{{ Str::limit($item->dpc->kecamatan_name, 15) }}</span>
                                    </div>
                                    @endif
                                </div>
                                
                                <h3 class="font-bold text-lg md:text-xl text-[#001F3F] mb-3 group-hover:text-[#001F3F] transition duration-300 line-clamp-2">
                                    <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                                </h3>
                                
                                <p class="text-gray-600 text-sm md:text-base mb-5 line-clamp-2">{{ $item->excerpt }}</p>
                                
                                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                    <a href="{{ route('news.show', $item->slug) }}" 
                                       class="news-view-btn group">
                                        <span>Baca Selengkapnya</span>
                                        <i class="fas fa-arrow-right ml-2 text-xs transform group-hover:translate-x-2 transition-transform duration-300"></i>
                                    </a>
                                    
                                    @if($item->is_featured)
                                    <span class="featured-tag">
                                        <i class="fas fa-star mr-1"></i>Featured
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-12 md:mt-16 fade-in-up">
                    {{ $news->links() }}
                </div>
                
                @else
                <div class="bg-white rounded-2xl shadow-xl p-12 md:p-16 text-center bounce-in">
                    <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-newspaper text-gray-300 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum ada berita</h3>
                    <p class="text-gray-600 text-lg mb-8">Tidak ada berita yang tersedia untuk kategori ini.</p>
                    <a href="{{ route('news.index') }}" class="cta-btn">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Semua Berita
                    </a>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3">
                <!-- Popular News -->
                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 mb-8 fade-in-up animation-delay-100">
                    <div class="flex items-center mb-6">
                        <div class="w-2 h-8 bg-[#001F3F] rounded-full mr-4"></div>
                        <h3 class="text-xl md:text-2xl font-bold text-[#001F3F]">Berita Populer</h3>
                    </div>
                    
                    <div class="space-y-5">
                        @foreach($popularNews as $popular)
                        <div class="flex items-start pb-5 border-b border-gray-100 last:border-0 last:pb-0 group hover-item">
                            @if($popular->featured_image)
                            <div class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden mr-4 shadow-md">
                                <img src="{{ asset('storage/' . $popular->featured_image) }}" 
                                     alt="{{ $popular->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            @else
                            <div class="flex-shrink-0 w-20 h-20 rounded-xl bg-gray-100 flex items-center justify-center mr-4 shadow-md">
                                <i class="fas fa-newspaper text-gray-400"></i>
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-sm md:text-base text-[#001F3F] hover:text-[#001F3F] mb-1.5 line-clamp-2">
                                    <a href="{{ route('news.show', $popular->slug) }}" class="hover:underline">{{ $popular->title }}</a>
                                </h4>
                                <div class="flex flex-wrap items-center text-gray-500 text-xs gap-2">
                                    <div class="flex items-center">
                                        <i class="fas fa-eye mr-1"></i>
                                        <span>{{ $popular->views }} views</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar mr-1"></i>
                                        <span>{{ $popular->published_at->format('d M') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 mb-8 fade-in-up animation-delay-200">
                    <h3 class="text-xl md:text-2xl font-bold text-[#001F3F] mb-6">Kategori Berita</h3>
                    
                    <div class="space-y-3">
                        @foreach($categories as $category)
                        <a href="{{ route('news.category', $category->slug) }}" 
                           class="category-item group">
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                                <span class="text-gray-700 font-medium group-hover:text-[#001F3F]">{{ $category->name }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-500 text-sm font-medium bg-gray-100 px-2 py-1 rounded-full">{{ $category->beritas()->count() }}</span>
                                <i class="fas fa-chevron-right text-gray-400 ml-2 text-xs group-hover:text-[#001F3F] transition-transform duration-300 group-hover:translate-x-1"></i>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Subscribe -->
                <div class="bg-gradient-to-br from-[#001F3F] via-blue-800 to-blue-900 rounded-2xl shadow-xl p-6 md:p-8 text-white fade-in-up animation-delay-300">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-envelope-open-text text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Berlangganan Berita</h3>
                        <p class="text-gray-300 text-sm">Dapatkan berita terbaru langsung ke email Anda.</p>
                    </div>
                    
                    <form class="space-y-4">
                        <div>
                            <input type="email" 
                                   placeholder="Email Anda" 
                                   class="w-full px-4 py-3 rounded-lg text-gray-900 text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-[#001F3F]">
                        </div>
                        <button type="submit" 
                                class="w-full cta-submit-btn">
                            <i class="fas fa-paper-plane mr-2"></i>Berlangganan
                        </button>
                    </form>
                    
                    <p class="text-xs text-gray-400 mt-4 text-center">
                        <i class="fas fa-shield-alt mr-1"></i>Kami tidak akan mengirim spam.
                    </p>
                </div>
            </div>
        </div>

        <!-- Newsletter Stats -->
        <div class="mt-12 md:mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="stats-card fade-in-up animation-delay-100">
                <div class="icon-wrapper bg-blue-100">
                    <i class="fas fa-newspaper text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-[#001F3F] mb-2">Total Berita</h3>
                <p class="text-gray-600 mb-1">Artikel terbit</p>
                <p class="text-gray-800 font-semibold text-3xl">{{ $totalNews }}+</p>
                <div class="mt-4 text-sm text-gray-500">
                    <i class="fas fa-calendar-plus text-blue-500 mr-1"></i>
                    {{ $recentNewsCount }} berita baru bulan ini
                </div>
            </div>
            
            <div class="stats-card fade-in-up animation-delay-200">
                <div class="icon-wrapper bg-green-100">
                    <i class="fas fa-eye text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-[#001F3F] mb-2">Total Dilihat</h3>
                <p class="text-gray-600 mb-1">Pembaca berita</p>
                <p class="text-gray-800 font-semibold text-3xl">{{ number_format($totalViews) }}+</p>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mr-2">
                            <div class="bg-green-500 h-1.5 rounded-full" style="width: 78%"></div>
                        </div>
                        <span>78%</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Peningkatan pembaca bulan ini</p>
                </div>
            </div>
            
            <div class="stats-card fade-in-up animation-delay-300">
                <div class="icon-wrapper bg-purple-100">
                    <i class="fas fa-users text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-[#001F3F] mb-2">Pembaca Aktif</h3>
                <p class="text-gray-600 mb-1">Pengunjung reguler</p>
                <p class="text-gray-800 font-semibold text-3xl">500+</p>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <div class="flex -space-x-2 mr-3">
                        <div class="w-8 h-8 rounded-full bg-blue-500 border-2 border-white"></div>
                        <div class="w-8 h-8 rounded-full bg-green-500 border-2 border-white"></div>
                        <div class="w-8 h-8 rounded-full bg-yellow-500 border-2 border-white"></div>
                        <div class="w-8 h-8 rounded-full bg-purple-500 border-2 border-white">+497</div>
                    </div>
                    <span>500+ pembaca aktif</span>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
// Filter News Items
const filterBtns = document.querySelectorAll('.filter-btn');
const newsItems = document.querySelectorAll('.news-item');

filterBtns.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const category = this.dataset.category;
        
        // Update active button
        filterBtns.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        // Filter news items
        let visibleCount = 0;
        newsItems.forEach(item => {
            if (category === 'all' || item.dataset.category === category) {
                item.style.display = 'block';
                visibleCount++;
                
                // Add animation
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 50);
            } else {
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    item.style.display = 'none';
                }, 300);
            }
        });
    });
});

// News View Button Animation
const newsViewBtns = document.querySelectorAll('.news-view-btn');

newsViewBtns.forEach(btn => {
    btn.addEventListener('mouseenter', function() {
        this.style.transform = 'translateX(5px)';
    });
    
    btn.addEventListener('mouseleave', function() {
        this.style.transform = 'translateX(0)';
    });
});

// Category Item Hover Effect
const categoryItems = document.querySelectorAll('.category-item');

categoryItems.forEach(item => {
    item.addEventListener('mouseenter', function() {
        this.style.transform = 'translateX(5px)';
    });
    
    item.addEventListener('mouseleave', function() {
        this.style.transform = 'translateX(0)';
    });
});

// Subscribe Form
const subscribeForm = document.querySelector('form');
if (subscribeForm) {
    subscribeForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const emailInput = this.querySelector('input[type="email"]');
        const submitBtn = this.querySelector('button[type="submit"]');
        
        if (emailInput.value) {
            // Show loading state
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
                alert('Terima kasih! Anda telah berlangganan newsletter kami.');
                emailInput.value = '';
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 1500);
        }
    });
}

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

// Read More Button Hover Effect
const readMoreBtns = document.querySelectorAll('.read-more-btn');

readMoreBtns.forEach(btn => {
    btn.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.05)';
    });
    
    btn.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
    });
});
</script>
@endpush

@push('styles')
<style>
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
@keyframes bounce-in {
    0% {
        opacity: 0;
        transform: scale(0.3);
    }
    50% {
        opacity: 1;
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        transform: scale(1);
    }
}

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

.bounce-in {
    animation: bounce-in 0.6s ease-out forwards;
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

.animation-delay-100 { transition-delay: 0.1s; }
.animation-delay-200 { transition-delay: 0.2s; }
.animation-delay-300 { transition-delay: 0.3s; }

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
    text-decoration: none;
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

.featured-badge {
    background: linear-gradient(135deg, #FFD700, #FFA500);
    color: #000;
    font-size: 11px;
    font-weight: bold;
    padding: 4px 8px;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
}

/* News Card Hover Effects */
.hover-card {
    transition: all 0.4s ease;
    border-bottom: 3px solid transparent;
}

.hover-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    border-bottom: 3px solid #001F3F;
}

.news-view-btn {
    display: inline-flex;
    align-items: center;
    color: #001F3F;
    font-weight: 600;
    font-size: 14px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px 0;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.news-view-btn::after {
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

.news-view-btn:hover::after {
    transform: scaleX(1);
    transform-origin: left;
}

.read-more-btn {
    display: inline-flex;
    align-items: center;
    background: rgba(0, 31, 63, 0.9);
    color: white;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.read-more-btn:hover {
    background: #001F3F;
    transform: scale(1.05);
}

/* Featured Tag */
.featured-tag {
    font-size: 11px;
    font-weight: bold;
    background: linear-gradient(135deg, #FFF3CD, #FFE594);
    color: #856404;
    padding: 4px 8px;
    border-radius: 6px;
    display: flex;
    align-items: center;
}

/* Category Items */
.category-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    border-radius: 12px;
    transition: all 0.3s ease;
    text-decoration: none;
    border: 1px solid #E5E7EB;
}

.category-item:hover {
    background: #F9FAFB;
    border-color: #D1D5DB;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transform: translateX(5px);
}

/* CTA Buttons */
.cta-btn {
    display: inline-flex;
    align-items: center;
    padding: 12px 24px;
    background: #001F3F;
    color: white;
    border-radius: 12px;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px rgba(0, 31, 63, 0.2);
}

.cta-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(0, 31, 63, 0.3);
    background: #0a2f5a;
}

.cta-submit-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 14px;
    background: white;
    color: #001F3F;
    border-radius: 12px;
    font-weight: bold;
    font-size: 16px;
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

/* Hover Items */
.hover-item {
    transition: all 0.3s ease;
}

.hover-item:hover {
    transform: translateY(-2px);
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

/* Pagination Custom Styles */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination li {
    margin: 0 4px;
}

.pagination li a,
.pagination li span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 12px;
    border-radius: 10px;
    text-decoration: none;
    color: #4B5563;
    background-color: white;
    border: 2px solid #E5E7EB;
    font-weight: 500;
    transition: all 0.3s ease;
}

.pagination li.active span {
    background-color: #001F3F;
    color: white;
    border-color: #001F3F;
    box-shadow: 0 4px 12px rgba(0, 31, 63, 0.3);
}

.pagination li a:hover:not(.disabled) {
    background-color: #001F3F;
    color: white;
    border-color: #001F3F;
    transform: translateY(-2px);
}

.pagination li.disabled span {
    color: #9CA3AF;
    cursor: not-allowed;
    background-color: #F3F4F6;
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
}
</style>
@endpush