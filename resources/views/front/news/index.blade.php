@extends('layouts.front')

@section('title', 'Berita - NasDem Bojonegoro')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden nasdem-gradient py-16 md:py-24 full-width">
    <div class="absolute inset-0 bg-gradient-to-b from-[#001F3F]/90 via-[#001F3F]/70 to-[#001F3F]/90"></div>
    
    <!-- Animated Background -->
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
        <div class="text-center max-w-4xl mx-auto fade-in-up">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full mb-6">
                <span class="w-2 h-2 bg-nasdem-red rounded-full mr-2 animate-pulse"></span>
                <span class="text-white font-semibold text-sm uppercase tracking-wider">INFORMASI TERBARU</span>
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                Berita & Kegiatan
                <span class="block text-2xl md:text-3xl text-white/80 mt-2">Partai NasDem Bojonegoro</span>
            </h1>
            
            <p class="text-xl text-gray-200 mb-8">
                Informasi terkini tentang kegiatan, program kerja, dan perkembangan terbaru Partai NasDem Kabupaten Bojonegoro
            </p>
            
            <!-- Animated CTA Button -->
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#news-grid" class="hero-btn-primary group/btn">
                    <span class="relative z-10">Lihat Berita</span>
                    <i class="fas fa-arrow-down ml-3 relative z-10"></i>
                </a>
                <a href="{{ route('home') }}" class="hero-btn-secondary group/btn">
                    <i class="fas fa-home mr-3 relative z-10"></i>
                    <span class="relative z-10">Kembali ke Beranda</span>
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
                   data-category="{{ $category->slug }}"
                   style="--category-color: {{ $category->color ?? '#001F3F' }}">
                    <i class="fas fa-folder mr-2"></i>{{ $category->name }}
                </a>
                @endforeach
            </div>
            
            @if(request()->has('category') && isset($currentCategory))
            <div class="text-center fade-in-up animation-delay-100">
                <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full shadow-lg border border-white/20">
                    <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $currentCategory->color ?? '#001F3F' }}; animation: pulse 2s infinite"></div>
                    <span class="text-white font-medium">Menampilkan berita kategori: <span class="font-bold">{{ $currentCategory->name }}</span></span>
                </div>
            </div>
            @endif
        </div>

        <div class="flex flex-col lg:flex-row gap-8 xl:gap-12">
            <!-- News List -->
            <div class="lg:w-2/3">
                @if($news->count() > 0)
                <div id="news-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6 md:gap-8">
                    @foreach($news as $item)
                    <div class="news-item fade-in-up hover-card" data-category="{{ $item->category->slug }}">
                        <!-- Card Container -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500">
                            <!-- News Image -->
                            <div class="relative overflow-hidden h-56 md:h-60">
                                @if($item->featured_image && file_exists(public_path('storage/' . $item->featured_image)))
                                <img src="{{ asset('storage/' . $item->featured_image) }}" 
                                     alt="{{ $item->title }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                @else
                                <div class="w-full h-full bg-gradient-to-br from-[#001F3F] to-[#0a2f5a] flex items-center justify-center">
                                    <i class="fas fa-newspaper text-white/30 text-5xl"></i>
                                </div>
                                @endif
                                
                                <!-- Overlay Gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="category-badge" 
                                          style="background-color: {{ $item->category->color ?? '#001F3F' }}">
                                        {{ $item->category->name ?? 'Berita' }}
                                    </span>
                                </div>
                                
                                <!-- Featured Badge -->
                                @if($item->is_featured)
                                <div class="absolute top-4 right-4">
                                    <span class="featured-badge">
                                        <i class="fas fa-star mr-1"></i>Featured
                                    </span>
                                </div>
                                @endif
                                
                                <!-- Hover Read More -->
                                <div class="absolute bottom-4 left-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform translate-y-2 group-hover:translate-y-0">
                                    <div class="flex items-center justify-between text-white">
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-eye mr-2"></i>
                                            <span>{{ number_format($item->views) }} views</span>
                                        </div>
                                        <a href="{{ route('news.show', $item->slug) }}" 
                                           class="read-more-btn">
                                            Baca <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- News Content -->
                            <div class="p-6">
                                <!-- Meta Information -->
                                <div class="flex flex-wrap items-center text-gray-500 dark:text-gray-400 text-sm mb-4 gap-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        <span>{{ $item->published_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-eye mr-2"></i>
                                        <span>{{ number_format($item->views) }}</span>
                                    </div>
                                    @if($item->dpc)
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        <span class="text-xs">{{ Str::limit($item->dpc->kecamatan_name, 15) }}</span>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Title -->
                                <h3 class="text-lg md:text-xl font-bold text-[#001F3F] dark:text-white mb-3 leading-snug hover:text-[#001F3F]/80 dark:hover:text-blue-400 transition-colors duration-300">
                                    <a href="{{ route('news.show', $item->slug) }}">
                                        {{ $item->title }}
                                    </a>
                                </h3>
                                
                                <!-- Excerpt -->
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-5 line-clamp-2">
                                    {{ $item->excerpt }}
                                </p>
                                
                                <!-- Footer -->
                                <div class="flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <a href="{{ route('news.show', $item->slug) }}" 
                                       class="news-view-btn text-sm group">
                                        <span>Baca Selengkapnya</span>
                                        <i class="fas fa-arrow-right ml-2 text-xs transform group-hover:translate-x-1 transition-transform duration-300"></i>
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
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-12 md:p-16 text-center bounce-in">
                    <div class="w-24 h-24 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-newspaper text-gray-400 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Belum ada berita</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-lg mb-8">
                        @if(request()->has('category'))
                        Tidak ada berita yang tersedia untuk kategori "{{ $currentCategory->name ?? 'ini' }}".
                        @else
                        Belum ada berita yang tersedia.
                        @endif
                    </p>
                    <a href="{{ route('news.index') }}" class="cta-btn">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Semua Berita
                    </a>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3 space-y-8">
                <!-- Popular News -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 md:p-8 fade-in-up animation-delay-100">
    <div class="flex items-center mb-8">
        <div class="w-2 h-8 bg-[#001F3F] rounded-full mr-4"></div>
        <h3 class="text-xl md:text-2xl font-bold text-[#001F3F] dark:text-white">Berita Populer</h3>
    </div>
    
    <div class="space-y-6">
        @foreach($popularNews as $popular)
        <a href="{{ route('news.show', $popular->slug) }}" class="group block hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-xl p-4 transition-all duration-300 hover:shadow-md">
            <div class="flex items-start">
                <!-- Thumbnail -->
                @if($popular->featured_image)
                <div class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden mr-4 shadow-md border border-gray-200 dark:border-gray-700">
                    <img src="{{ asset('storage/' . $popular->featured_image) }}" 
                         alt="{{ $popular->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                @else
                <div class="flex-shrink-0 w-20 h-20 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center mr-4 shadow-md border border-gray-200 dark:border-gray-700">
                    <i class="fas fa-newspaper text-gray-400 text-xl"></i>
                </div>
                @endif
                
                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-sm md:text-base text-[#001F3F] dark:text-white group-hover:text-[#001F3F] dark:group-hover:text-blue-400 mb-2 line-clamp-2 transition-colors duration-300 leading-relaxed">
                        {{ $popular->title }}
                    </h4>
                    <div class="flex flex-wrap items-center text-gray-500 dark:text-gray-400 text-xs gap-3">
                        <div class="flex items-center bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-full">
                            <i class="fas fa-eye mr-1.5 text-xs"></i>
                            <span class="font-medium">{{ number_format($popular->views) }}</span>
                        </div>
                        <div class="flex items-center bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-full">
                            <i class="fas fa-calendar mr-1.5 text-xs"></i>
                            <span class="font-medium">{{ $popular->published_at->format('d M Y') }}</span>
                        </div>
                        @if($popular->category)
                        <div class="flex items-center bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-full">
                            <span class="w-2 h-2 rounded-full mr-1.5" style="background-color: {{ $popular->category->color ?? '#001F3F' }}"></span>
                            <span class="font-medium text-xs">{{ Str::limit($popular->category->name, 15) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Arrow Indicator -->
                <div class="flex-shrink-0 ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-[#001F3F] dark:group-hover:text-blue-400 transition-colors duration-300"></i>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    
    <!-- View All Link -->
    @if($popularNews->count() > 0)
    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
        <a href="{{ route('news.index') }}" class="flex items-center justify-center text-sm font-medium text-[#001F3F] dark:text-blue-400 hover:text-[#001F3F]/80 dark:hover:text-blue-300 transition-colors duration-300 group">
            <span>Lihat Semua Berita Populer</span>
            <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-300"></i>
        </a>
    </div>
    @endif
</div>

                <!-- Categories -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 md:p-8 fade-in-up animation-delay-200">
                    <div class="flex items-center mb-6">
                        <div class="w-2 h-8 bg-[#001F3F] rounded-full mr-4"></div>
                        <h3 class="text-xl md:text-2xl font-bold text-[#001F3F] dark:text-white">Kategori Berita</h3>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($categories as $category)
                        <a href="{{ route('news.category', $category->slug) }}" 
                           class="category-item group"
                           style="--category-color: {{ $category->color }}">
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium group-hover:text-[#001F3F] dark:group-hover:text-white transition-colors duration-300">
                                    {{ $category->name }}
                                </span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-full">
                                    {{ $category->beritas()->count() }}
                                </span>
                                <i class="fas fa-chevron-right text-gray-400 ml-2 text-xs group-hover:text-[#001F3F] dark:group-hover:text-white transition-all duration-300 group-hover:translate-x-1"></i>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="bg-gradient-to-br from-[#001F3F] via-blue-800 to-blue-900 rounded-2xl shadow-xl p-6 md:p-8 text-white fade-in-up animation-delay-300">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-envelope-open-text text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Berlangganan Berita</h3>
                        <p class="text-gray-300 text-sm">Dapatkan berita terbaru langsung ke email Anda</p>
                    </div>
                    
                    <form class="space-y-4">
                        <div>
                            <input type="email" 
                                   placeholder="Email Anda" 
                                   class="w-full px-4 py-3 rounded-lg text-gray-900 text-sm md:text-base focus:outline-none focus:ring-2 focus:ring-[#001F3F]">
                        </div>
                        <button type="submit" 
                                class="w-full cta-submit-btn group">
                            <span class="relative z-10">
                                <i class="fas fa-paper-plane mr-2"></i>Berlangganan
                            </span>
                            <span class="absolute inset-0 bg-white/10 transform translate-x-full group-hover:translate-x-0 transition-transform duration-500"></span>
                        </button>
                    </form>
                    
                    <p class="text-xs text-gray-400 mt-4 text-center">
                        <i class="fas fa-shield-alt mr-1"></i>Kami tidak akan mengirim spam
                    </p>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 md:p-8 fade-in-up animation-delay-400">
                    <div class="flex items-center mb-6">
                        <div class="w-2 h-8 bg-[#001F3F] rounded-full mr-4"></div>
                        <h3 class="text-xl md:text-2xl font-bold text-[#001F3F] dark:text-white">Statistik Berita</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3">
                                    <i class="fas fa-newspaper text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Total Berita</div>
                                    <div class="text-lg font-bold text-[#001F3F] dark:text-white">{{ $totalNews }}+</div>
                                </div>
                            </div>
                            <div class="text-xs text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30 px-2 py-1 rounded-full">
                                +{{ $recentNewsCount }} baru
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-3">
                                    <i class="fas fa-eye text-green-600 dark:text-green-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Total Dilihat</div>
                                    <div class="text-lg font-bold text-[#001F3F] dark:text-white">{{ number_format($totalViews) }}+</div>
                                </div>
                            </div>
                            <div class="text-xs text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/30 px-2 py-1 rounded-full">
                                ↑ 78%
                            </div>
                        </div>
                    </div>
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
        const href = this.getAttribute('href');
        
        if (href) {
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
        }
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

// Smooth scroll to news grid
const scrollToNewsBtn = document.querySelector('a[href="#news-grid"]');
if (scrollToNewsBtn) {
    scrollToNewsBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector('#news-grid');
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
}
</script>
@endpush

@push('styles')
<style>
/* Hero Section Particles */
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

    .animation-delay-50 {
        transition-delay: 0.05s;
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

    .animation-delay-600 {
        transition-delay: 0.6s;
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
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    border-color: var(--category-color, #001F3F);
    color: var(--category-color, #001F3F);
}

.filter-btn.active {
    background: var(--category-color, #001F3F);
    color: white;
    border-color: var(--category-color, #001F3F);
    box-shadow: 0 10px 20px rgba(0, 31, 63, 0.2);
}

.dark .filter-btn {
    background: #374151;
    border-color: #4B5563;
    color: #D1D5DB;
}

.dark .filter-btn:hover {
    border-color: var(--category-color, #3B82F6);
    color: var(--category-color, #3B82F6);
}

.dark .filter-btn.active {
    background: var(--category-color, #001F3F);
    border-color: var(--category-color, #001F3F);
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
    padding: 6px 12px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
    backdrop-filter: blur(10px);
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

.dark .hover-card:hover {
    border-bottom: 3px solid #3B82F6;
}

.news-view-btn {
    display: inline-flex;
    align-items: center;
    color: #001F3F;
    font-weight: 600;
    background: none;
    border: none;
    cursor: pointer;
    text-decoration: none;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
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

.dark .news-view-btn {
    color: #3B82F6;
}

.dark .news-view-btn::after {
    background: #3B82F6;
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

.dark .read-more-btn {
    background: rgba(59, 130, 246, 0.9);
}

.dark .read-more-btn:hover {
    background: #3B82F6;
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

.dark .featured-tag {
    background: linear-gradient(135deg, #4B5563, #6B7280);
    color: #FBBF24;
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
    background: white;
}

.category-item:hover {
    background: #F9FAFB;
    border-color: var(--category-color, #D1D5DB);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transform: translateX(5px);
}

.dark .category-item {
    background: #374151;
    border-color: #4B5563;
    color: #D1D5DB;
}

.dark .category-item:hover {
    background: #4B5563;
    border-color: var(--category-color, #3B82F6);
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

.dark .cta-btn {
    background: #3B82F6;
}

.dark .cta-btn:hover {
    background: #2563EB;
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
    position: relative;
    overflow: hidden;
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

/* Hero Buttons (from homepage) */
.hero-btn-primary {
    position: relative;
    overflow: hidden;
    background: white;
    color: #001F3F;
    border-radius: 12px;
    font-weight: bold;
    font-size: 16px;
    padding: 14px 28px;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    border: 2px solid transparent;
    display: inline-flex;
    align-items: center;
}

.hero-btn-primary:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3), 0 0 20px rgba(255, 255, 255, 0.3);
    border-color: white;
}

.hero-btn-secondary {
    position: relative;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    font-weight: 600;
    font-size: 16px;
    padding: 14px 28px;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
}

.hero-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: white;
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2), inset 0 0 20px rgba(255, 255, 255, 0.1);
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

.dark .pagination li a,
.dark .pagination li span {
    background-color: #374151;
    border-color: #4B5563;
    color: #D1D5DB;
}

.dark .pagination li.active span {
    background-color: #3B82F6;
    border-color: #3B82F6;
}

.dark .pagination li a:hover:not(.disabled) {
    background-color: #3B82F6;
    border-color: #3B82F6;
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
    
    .news-item-card {
        padding: 20px;
    }
    
    .hero-btn-primary,
    .hero-btn-secondary {
        padding: 12px 24px;
        font-size: 14px;
    }
}

@media (max-width: 640px) {
    .grid-cols-2 {
        grid-template-columns: 1fr;
    }
    
    .xl\:grid-cols-3 {
        grid-template-columns: 1fr;
    }
}

/* Dark Mode Support */
.dark .stats-card {
    background: #374151;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.dark .stats-card:hover {
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
}

.dark .icon-wrapper {
    background: rgba(59, 130, 246, 0.1);
}

.dark .icon-wrapper i {
    color: #60A5FA;
}
</style>
@endpush