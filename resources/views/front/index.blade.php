@extends('layouts.front')

@section('title', 'Beranda - NasDem Bojonegoro')

@section('content')
<!-- Hero Slider Section -->
<section class="relative overflow-hidden group hero-section w-full">
    <div class="swiper heroSwiper w-full h-full">
        <div class="swiper-wrapper">
            @foreach($headlineNews as $index => $news)
            <div class="swiper-slide relative overflow-hidden w-full">
                <!-- Background Image dengan efek parallax -->
                <div class="absolute inset-0 w-full h-full transform group-hover:scale-105 transition-transform duration-700">
                    @if($news->featured_image && file_exists(public_path('storage/' . $news->featured_image)))
                    <img src="{{ asset('storage/' . $news->featured_image) }}"
                        alt="{{ $news->title }}"
                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-1000">
                    @else
                    <div class="w-full h-full bg-gradient-to-r from-[#001F3F] to-blue-800 transform group-hover:scale-105 transition-transform duration-700"></div>
                    @endif

                    <!-- Gradient Overlay dengan animasi -->
                    <div class="absolute inset-0 bg-gradient-to-r from-[#001F3F]/90 via-[#001F3F]/70 to-transparent opacity-100 group-hover:opacity-80 transition-opacity duration-500"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#001F3F]/80 via-transparent to-transparent"></div>

                    <!-- Particle Effect -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-20 transition-opacity duration-700">
                        <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-blue-400 rounded-full blur-3xl animate-pulse"></div>
                        <div class="absolute bottom-1/4 right-1/4 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                    </div>
                </div>

                <!-- Glow Effect Border -->
                <div class="absolute inset-0 border-4 border-transparent group-hover:border-white/20 rounded-xl transition-all duration-500 pointer-events-none"></div>

                <!-- Content dengan efek glassmorphism -->
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full px-4 sm:px-6 lg:px-8">
                        <div class="max-w-2xl fade-in-up" data-delay="{{ $index * 100 }}">
                            <!-- Badge dengan efek glow -->
                            <span class="inline-flex items-center bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-bold px-4 py-2 rounded-full mb-6 group-hover:bg-white/20 group-hover:shadow-[0_0_20px_rgba(255,255,255,0.3)] transition-all duration-500">
                                <div class="w-2 h-2 rounded-full bg-blue-400 mr-2 animate-pulse group-hover:animate-none group-hover:scale-125 transition-transform"></div>
                                {{ $news->category->name ?? 'Berita' }}
                            </span>

                            <!-- Title dengan efek gradien text -->
                            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight relative">
                                <span class="bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent group-hover:from-blue-300 group-hover:to-white transition-all duration-700">
                                    {{ $news->title }}
                                </span>
                                <!-- Underline animasi -->
                                <!-- <span class="absolute -bottom-4 left-0 w-0 h-1 bg-gradient-to-r from-blue-400 to-white group-hover:w-full transition-all duration-700 ease-out"></span>
                            </h1> -->

                                <!-- Excerpt dengan efek fade in -->
                                <p class="text-gray-200 text-lg md:text-xl mb-8 opacity-90 group-hover:opacity-100 group-hover:translate-x-2 transition-all duration-500">
                                    {{ Str::limit($news->excerpt, 150) }}
                                </p>

                                <!-- Buttons dengan efek modern -->
                                <div class="flex flex-wrap gap-4">
                                    <a href="{{ route('news.show', $news->slug) }}"
                                        class="hero-btn-primary group/btn relative overflow-hidden">
                                        <span class="relative z-10">Baca Selengkapnya</span>
                                        <i class="fas fa-arrow-right ml-3 transform group-hover/btn:translate-x-2 transition-transform duration-300 relative z-10"></i>
                                        <!-- Hover background effect -->
                                        <span class="absolute inset-0 bg-gradient-to-r from-white to-blue-100 transform -translate-x-full group-hover/btn:translate-x-0 transition-transform duration-500"></span>
                                    </a>

                                    @if($news->category)
                                    <a href="{{ route('news.category', $news->category->slug) }}"
                                        class="hero-btn-secondary group/btn2 relative overflow-hidden">
                                        <i class="fas fa-folder mr-2 relative z-10"></i>
                                        <span class="relative z-10">Lebih Banyak {{ $news->category->name }}</span>
                                        <!-- Glow effect -->
                                        <span class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-transparent opacity-0 group-hover/btn2:opacity-100 transition-opacity duration-500"></span>
                                        <!-- Border animasi -->
                                        <span class="absolute inset-0 border border-transparent group-hover/btn2:border-white/50 rounded-lg transition-all duration-500"></span>
                                    </a>
                                    @endif
                                </div>

                                <!-- Read More Indicator -->
                                <div class="mt-10 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                                    <div class="flex items-center text-white/60 text-sm">
                                        <span class="mr-3">Scroll untuk berita lainnya</span>
                                        <div class="flex space-x-1">
                                            <div class="w-1 h-1 bg-white rounded-full animate-bounce" style="animation-delay: 0s"></div>
                                            <div class="w-1 h-1 bg-white rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                            <div class="w-1 h-1 bg-white rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <!-- Corner Accents -->
                <div class="absolute top-4 left-4 w-8 h-8 border-t-2 border-l-2 border-white/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="absolute top-4 right-4 w-8 h-8 border-t-2 border-r-2 border-white/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="absolute bottom-4 left-4 w-8 h-8 border-b-2 border-l-2 border-white/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="absolute bottom-4 right-4 w-8 h-8 border-b-2 border-r-2 border-white/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </div>
            @endforeach
        </div>

        <!-- Navigation buttons dengan efek glassmorphism -->
        <div class="swiper-button-next hero-nav-btn group/nav">
            <i class="fas fa-chevron-right transform group-hover/nav:translate-x-1 transition-transform"></i>
            <span class="absolute -right-2 top-1/2 -translate-y-1/2 bg-white text-[#001F3F] text-xs font-bold px-2 py-1 rounded opacity-0 group-hover/nav:opacity-100 transition-opacity">
                Next
            </span>
        </div>
        <div class="swiper-button-prev hero-nav-btn group/nav">
            <i class="fas fa-chevron-left transform group-hover/nav:-translate-x-1 transition-transform"></i>
            <span class="absolute -left-2 top-1/2 -translate-y-1/2 bg-white text-[#001F3F] text-xs font-bold px-2 py-1 rounded opacity-0 group-hover/nav:opacity-100 transition-opacity">
                Prev
            </span>
        </div>

        <!-- Pagination dengan efek modern -->
        <div class="swiper-pagination hero-pagination"></div>

        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 opacity-70 hover:opacity-100 transition-opacity cursor-pointer">
            <div class="animate-bounce-slow flex flex-col items-center">
                <span class="text-white text-xs mb-2">Scroll Down</span>
                <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
                    <div class="w-1 h-3 bg-white rounded-full mt-2 animate-scroll"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mouse Follow Effect -->
    <div class="mouse-follower"></div>
</section>

<!-- Main Content -->
<main class="py-6 bg-gradient-to-r from-[#E69D00] to-[#E69D00]">
    <div class="px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
           <!-- Latest News Section -->
<div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-10">
        <div class="mb-6 sm:mb-0">
            <div class="inline-flex items-center px-4 py-2 bg-nasdem-red/10 dark:bg-nasdem-red/20 rounded-full mb-4">
                <span class="w-2 h-2 bg-nasdem-red rounded-full mr-2 animate-pulse"></span>
                <span class="text-nasdem-red dark:text-red-400 font-semibold text-sm uppercase tracking-wider">UPDATE TERBARU</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">Berita Terkini</h2>
            <p class="text-gray-600 dark:text-gray-300 text-lg">Informasi terkini dari Partai NasDem Bojonegoro</p>
        </div>
        <a href="{{ route('news.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-nasdem-navy to-nasdem-blue dark:from-gray-800 dark:to-gray-900 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/20 transition-all duration-300 group border border-gray-200 dark:border-gray-700">
            <span class="font-semibold">Lihat Semua</span>
            <i class="fas fa-arrow-right ml-3 transform group-hover:translate-x-2 transition-transform duration-300"></i>
        </a>
    </div>

    <!-- Featured News -->
    @if($latestNews->isNotEmpty())
    <div class="mb-12 group relative">
        <div class="bg-gradient-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-lg hover:shadow-2xl transition-all duration-500">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                <!-- Featured Image -->
                <div class="relative overflow-hidden h-64 lg:h-auto min-h-[300px]">
                    @if($latestNews->first()->featured_image && file_exists(public_path('storage/' . $latestNews->first()->featured_image)))
                    <img src="{{ asset('storage/' . $latestNews->first()->featured_image) }}"
                         alt="{{ $latestNews->first()->title }}"
                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-nasdem-navy to-nasdem-blue flex items-center justify-center">
                        <i class="fas fa-newspaper text-white/30 text-6xl"></i>
                    </div>
                    @endif
                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <!-- Featured Badge -->
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-4 py-2 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm rounded-full">
                            <span class="w-2 h-2 bg-nasdem-red rounded-full mr-2 animate-pulse"></span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">FEATURED</span>
                        </span>
                    </div>
                </div>
                
                <!-- Featured Content -->
                <div class="p-8 lg:p-10 flex flex-col justify-center">
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-block px-4 py-1.5 text-xs font-semibold text-white rounded-full" 
                              style="background-color: {{ $latestNews->first()->category->color ?? '#001F3F' }}">
                            {{ $latestNews->first()->category->name ?? 'Berita' }}
                        </span>
                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            {{ $latestNews->first()->published_at->format('d M Y') }}
                        </span>
                    </div>
                    
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                        <a href="{{ route('news.show', $latestNews->first()->slug) }}" 
                           class="hover:text-nasdem-blue dark:hover:text-blue-400 transition-colors duration-300">
                            {{ $latestNews->first()->title }}
                        </a>
                    </h3>
                    
                    <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                        {{ Str::limit($latestNews->first()->excerpt, 200) }}
                    </p>
                    
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('news.show', $latestNews->first()->slug) }}" 
                           class="inline-flex items-center text-nasdem-blue dark:text-blue-400 font-semibold hover:text-nasdem-red dark:hover:text-red-400 transition-colors duration-300 group">
                            <span>Baca Artikel Lengkap</span>
                            <i class="fas fa-arrow-right ml-3 transform group-hover:translate-x-2 transition-transform duration-300"></i>
                        </a>
                        <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                            <i class="fas fa-clock mr-2"></i>
                            <span>{{ $latestNews->first()->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($latestNews->skip(1)->take(4) as $news)
        <div class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
            <!-- News Image -->
            <div class="relative overflow-hidden h-48">
                @if($news->featured_image && file_exists(public_path('storage/' . $news->featured_image)))
                <img src="{{ asset('storage/' . $news->featured_image) }}"
                     alt="{{ $news->title }}"
                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                @else
                <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                    <i class="fas fa-newspaper text-white/20 text-4xl"></i>
                </div>
                @endif
                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                <!-- Category Badge -->
                <span class="absolute top-4 left-4 inline-block px-3 py-1 text-xs font-semibold text-white rounded-full backdrop-blur-sm"
                      style="background-color: {{ $news->category->color ?? '#001F3F' }}">
                    {{ $news->category->name ?? 'Berita' }}
                </span>
            </div>
            
            <!-- News Content -->
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-500 dark:text-gray-400 text-sm">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        {{ $news->published_at->format('d M Y') }}
                    </span>
                    <span class="text-gray-500 dark:text-gray-400 text-sm">
                        <i class="fas fa-eye mr-2"></i>
                        {{ number_format($news->views) }}
                    </span>
                </div>
                
                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3 leading-snug">
                    <a href="{{ route('news.show', $news->slug) }}" 
                       class="hover:text-nasdem-blue dark:hover:text-blue-400 transition-colors duration-300">
                        {{ Str::limit($news->title, 65) }}
                    </a>
                </h4>
                
                <p class="text-gray-600 dark:text-gray-300 text-sm mb-5 line-clamp-2">
                    {{ Str::limit($news->excerpt, 120) }}
                </p>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('news.show', $news->slug) }}" 
                       class="inline-flex items-center text-sm text-nasdem-blue dark:text-blue-400 font-medium hover:text-nasdem-red dark:hover:text-red-400 transition-colors duration-300 group">
                        <span>Baca Selengkapnya</span>
                        <i class="fas fa-arrow-right ml-2 text-xs transform group-hover:translate-x-1 transition-transform duration-300"></i>
                    </a>
                    <div class="text-gray-400 text-xs">
                        {{ $news->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Membership Check -->
<!-- Cek Keanggotaan - Versi Modern -->
<div class="bg-gradient-to-r from-[#001F3F] to-blue-900 rounded-2xl shadow-xl overflow-hidden relative group">
    <!-- Background efek -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-white rounded-full translate-y-20 -translate-x-20"></div>
    </div>
    
    <div class="relative p-6">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-blue-300 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                <i class="fas fa-user-check text-white text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Status Kader</h3>
            <p class="text-gray-300">Periksa status pendaftaran Anda</p>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4">
            <!-- Button Cek Status -->
            <a href="{{ route('kader.check.form') }}" 
               class="block w-full group/btn">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-5 text-center hover:bg-white/20 hover:border-white/30 transition-all duration-300 group-hover/btn:translate-x-2">
                    <div class="flex items-center justify-center">
                        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mr-4 group-hover/btn:bg-white/30 transition-colors">
                            <i class="fas fa-search text-white text-xl"></i>
                        </div>
                        <div class="text-left">
                            <div class="text-white font-bold text-lg">Cek Status</div>
                            <div class="text-gray-300 text-sm">Periksa status pendaftaran</div>
                        </div>
                        <div class="ml-auto">
                            <i class="fas fa-arrow-right text-white/60 group-hover/btn:text-white group-hover/btn:translate-x-1 transition-all"></i>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Button Daftar Baru -->
            <a href="{{ route('kader.register') }}" 
               class="block w-full group/btn2">
                <div class="bg-gradient-to-r from-[#e31b23] to-red-600 rounded-xl p-5 text-center hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl group-hover/btn2:-translate-y-1">
                    <div class="flex items-center justify-center">
                        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mr-4">
                            <i class="fas fa-user-plus text-white text-xl"></i>
                        </div>
                        <div class="text-left">
                            <div class="text-white font-bold text-lg">Daftar Kader</div>
                            <div class="text-white/90 text-sm">Bergabung bersama kami</div>
                        </div>
                        <div class="ml-auto">
                            <i class="fas fa-arrow-right text-white/80 group-hover/btn2:text-white group-hover/btn2:translate-x-1 transition-all"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Info -->
        <div class="mt-8 pt-6 border-t border-white/10">
            <div class="flex items-center justify-center text-gray-300 text-sm">
                <i class="fas fa-clock mr-2"></i>
                <span>Proses verifikasi: 1-3 hari kerja</span>
            </div>
            <div class="flex items-center justify-center text-gray-300 text-sm mt-2">
                <i class="fas fa-shield-alt mr-2"></i>
                <span>Data Anda terlindungi</span>
            </div>
        </div>
    </div>
</div>

                <!-- Quick Links -->
                <div class="bg-gradient-to-r from-[#001F3F] to-blue-900 rounded-2xl shadow-xl overflow-hidden relative group p-6">

                    <h3 class="text-xl font-bold  text-white mb-6">Akses Cepat</h3>
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
                <div class="bg-gradient-to-r from-[#001F3F] to-blue-900 rounded-2xl shadow-xl overflow-hidden relative group p-6">

                    <h3 class="text-xl font-bold text-white mb-6">Berita Populer</h3>
                    <div class="space-y-4 ">
                        @foreach($popularNews ?? [] as $popular)
                        <a href="{{ route('news.show', $popular->slug) }}" class="popular-news-item group " >
                            <div class="popular-news-image">
                                @if($popular->featured_image && file_exists(public_path('storage/' . $popular->featured_image)))
                                <img src="{{ asset('storage/' . $popular->featured_image) }}"
                                    alt="{{ $popular->title }}"
                                    class="group-hover:scale-105">
                                @else
                                <div class="w-full h-full flex items-center justify-center"> 
                                    <!-- bg-gradient-to-r from-[#001F3F] to-blue-800  -->
                                    <i class="fas fa-newspaper  text-lg opacity-50"></i>
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
<div class="mt-20 py-16 bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 rounded-3xl">
    <div class="px-4 sm:px-6 lg:px-8 mx-auto max-w-7xl">
        <!-- Header -->
        <div class="text-center mb-14">
            <div class="inline-flex items-center px-5 py-2.5 bg-nasdem-red/10 dark:bg-red-900/30 rounded-full mb-6">
                <div class="w-2 h-2 bg-nasdem-red rounded-full mr-2 animate-pulse"></div>
                <span class="text-nasdem-red dark:text-red-400 font-semibold text-sm uppercase tracking-wider">EXPLORE CATEGORIES</span>
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                Jelajahi <span class="bg-gradient-to-r from-nasdem-blue to-blue-600 dark:from-blue-400 dark:to-blue-300 bg-clip-text text-transparent">Kategori</span> Berita
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                Temukan informasi terkini berdasarkan kategori yang sesuai dengan minat Anda
            </p>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($categories ?? [] as $category)
            @php
                $color = $category->color ?? '#001F3F';
                $count = $category->beritas()->count() ?? 0;
            @endphp
            
            <a href="{{ route('news.category', $category->slug) }}" 
               class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-3">
                
                <!-- Animated Background -->
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-700"
                     style="background: radial-gradient(circle at 50% 0%, {{ $color }}15 0%, transparent 70%);">
                </div>
                
                <!-- Content -->
                <div class="relative p-6 z-10">
                    <!-- Icon with animation -->
                    <div class="w-16 h-16 rounded-2xl mb-5 mx-auto flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-12 transition-all duration-500"
                         style="background: linear-gradient(135deg, {{ $color }}, {{ $color }}dd); box-shadow: 0 10px 25px {{ $color }}40;">
                        <i class="fas fa-folder text-white text-2xl"></i>
                    </div>
                    
                    <!-- Category Info -->
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-nasdem-blue dark:group-hover:text-blue-400 transition-colors duration-300">
                            {{ $category->name }}
                        </h3>
                        
                        <!-- Counter with animation -->
                        <div class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                {{ $count }} Berita
                            </span>
                            @if($count > 0)
                            <div class="ml-2 w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                            @endif
                        </div>
                        
                        <!-- Description -->
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-6">
                            Jelajahi semua berita terkait {{ strtolower($category->name) }}
                        </p>
                    </div>
                    
                    <!-- Explore Button -->
                    <div class="flex items-center justify-center pt-4 border-t border-gray-100 dark:border-gray-700">
                        <span class="text-sm font-semibold text-nasdem-blue dark:text-blue-400 group-hover:text-nasdem-red dark:group-hover:text-red-400 transition-colors duration-300">
                            Jelajahi Kategori
                        </span>
                        <i class="fas fa-arrow-right ml-3 transform group-hover:translate-x-2 transition-transform duration-300 text-nasdem-blue dark:text-blue-400"></i>
                    </div>
                </div>
                
                <!-- Hover Line Animation -->
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-{{ str_replace('#', '', $color) }} to-transparent transform -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
            </a>
            @endforeach
            
            <!-- Empty State -->
            @if(empty($categories) || count($categories) == 0)
            <div class="col-span-full text-center py-12">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 mb-6">
                    <i class="fas fa-folder text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3">Belum Ada Kategori</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">
                    Kategori berita akan segera tersedia. Pantau terus perkembangan kami.
                </p>
            </div>
            @endif
        </div>
        
        <!-- CTA -->
        @if(!empty($categories) && count($categories) > 0)
        <div class="text-center mt-14">
            <a href="{{ route('news.categories') ?? '#' }}" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-nasdem-navy to-nasdem-blue dark:from-gray-800 dark:to-gray-900 text-white rounded-xl hover:shadow-2xl hover:shadow-blue-500/30 transition-all duration-500 group border border-gray-200 dark:border-gray-700">
                <span class="font-bold text-lg">Lihat Semua Kategori</span>
                <i class="fas fa-chevron-right ml-4 transform group-hover:translate-x-2 transition-transform duration-300"></i>
            </a>
        </div>
        @endif
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

    // Mouse follow effect
    const heroSection = document.querySelector('.hero-section');
    const mouseFollower = document.querySelector('.mouse-follower');

    if (heroSection && mouseFollower) {
        // Gunakan fixed position untuk mouse follower
        mouseFollower.style.position = 'fixed';
        mouseFollower.style.zIndex = '99999';

        heroSection.addEventListener('mousemove', (e) => {
            const x = e.clientX;
            const y = e.clientY;

            mouseFollower.style.left = `${x}px`;
            mouseFollower.style.top = `${y}px`;

            // Resize berdasarkan posisi mouse
            const centerX = window.innerWidth / 2;
            const centerY = window.innerHeight / 2;
            const distanceFromCenter = Math.sqrt(
                Math.pow(x - centerX, 2) + Math.pow(y - centerY, 2)
            );

            const maxDistance = Math.sqrt(Math.pow(centerX, 2) + Math.pow(centerY, 2));
            const scale = 1 + (distanceFromCenter / maxDistance) * 0.5;

            mouseFollower.style.width = `${40 * scale}px`;
            mouseFollower.style.height = `${40 * scale}px`;
        });

        heroSection.addEventListener('mouseenter', () => {
            mouseFollower.style.opacity = '1';
        });

        heroSection.addEventListener('mouseleave', () => {
            mouseFollower.style.opacity = '0';
        });
    }

    // Parallax effect pada scroll
    window.addEventListener('scroll', () => {
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            heroSection.style.transform = `translate3d(0, ${rate}px, 0)`;
        }
    });

    // Animated Number Counting
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
            }, {
                threshold: 0.5
            });

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
    /* Category Cards Enhancements */
.category-card {
    position: relative;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.category-card::before {
    content: '';
    position: absolute;
    top: -1px;
    left: -1px;
    right: -1px;
    bottom: -1px;
    background: linear-gradient(45deg, 
        var(--category-color, #001F3F) 0%, 
        transparent 30%, 
        transparent 70%, 
        var(--category-color, #001F3F) 100%);
    border-radius: 24px;
    opacity: 0;
    z-index: -1;
    transition: opacity 0.4s ease;
}

.category-card:hover::before {
    opacity: 1;
}

/* Gradient border effect */
.category-card::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 24px;
    padding: 2px;
    background: linear-gradient(45deg, 
        var(--category-color, #001F3F), 
        transparent, 
        var(--category-color, #001F3F));
    -webkit-mask: 
        linear-gradient(#fff 0 0) content-box, 
        linear-gradient(#fff 0 0);
    mask: 
        linear-gradient(#fff 0 0) content-box, 
        linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0;
    transition: opacity 0.4s ease;
}

.category-card:hover::after {
    opacity: 1;
}

/* Floating animation */
@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.category-card:hover .fa-folder {
    animation: float 1.5s ease-in-out infinite;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .category-card {
        padding: 1.5rem !important;
    }
    
    .category-card h3 {
        font-size: 1.125rem !important;
    }
    
    .category-card .fa-folder {
        font-size: 1.5rem !important;
    }
}

/* Glass effect for dark mode */
.dark .category-card {
    backdrop-filter: blur(10px);
    background: rgba(30, 41, 59, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.dark .category-card:hover {
    background: rgba(30, 41, 59, 0.9);
    border-color: rgba(59, 130, 246, 0.3);
}
    /* Animasi baru */
    @keyframes bounce-slow {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes scroll {
        0% {
            transform: translateY(0);
            opacity: 1;
        }

        100% {
            transform: translateY(15px);
            opacity: 0;
        }
    }

    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    .animate-bounce-slow {
        animation: bounce-slow 2s infinite;
    }

    .animate-scroll {
        animation: scroll 1.5s infinite;
    }

    /* Hero Slider dengan efek modern */
    .heroSwiper {
        height: 500px;
    }

    @media (min-width: 768px) {
        .heroSwiper {
            height: 600px;
        }
    }

    /* Mouse follower effect */
 .mouse-follower {
    position: fixed !important; /* GANTI ke fixed */
    width: 40px;
    height: 40px;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.4) 0%, rgba(59, 130, 246, 0.1) 50%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
    z-index: 10000 !important; /* LEBIH TINGGI */
    transform: translate(-50%, -50%);
    transition: width 0.3s, height 0.3s, opacity 0.3s;
    opacity: 0;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
}

    .hero-section:hover .mouse-follower {
        opacity: 1;
    }

    /* Enhanced navigation buttons */
    .hero-nav-btn {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: rgba(0, 31, 63, 0.8);
        backdrop-filter: blur(20px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .hero-nav-btn:hover {
        background: rgba(0, 31, 63, 0.95);
        border-color: rgba(255, 255, 255, 0.8);
        transform: scale(1.15);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4), 0 0 20px rgba(59, 130, 246, 0.5);
    }

    .hero-nav-btn i {
        font-size: 18px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
    }

    /* Enhanced pagination */
    .hero-pagination {
        bottom: 30px !important;
    }

    .hero-pagination .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 1;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        margin: 0 8px !important;
        position: relative;
        overflow: hidden;
    }

    .hero-pagination .swiper-pagination-bullet::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
        transition: left 0.5s;
    }

    .hero-pagination .swiper-pagination-bullet:hover::before {
        left: 100%;
    }

    .hero-pagination .swiper-pagination-bullet-active {
        background: white;
        transform: scale(1.4);
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
    }

    /* Enhanced progress bar */
    .hero-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: rgba(255, 255, 255, 0.1);
        z-index: 10;
        backdrop-filter: blur(10px);
    }

    .hero-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #3B82F6, #60A5FA, #93C5FD);
        width: 0%;
        transition: width 5s linear;
        position: relative;
        overflow: hidden;
    }

    .hero-progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: shimmer 2s infinite;
    }

    /* Button hover effects enhancement */
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

    /* Slide content animations */
    .swiper-slide {
        transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .fade-in-up.animated {
        opacity: 1;
        transform: translateY(0);
    }

    /* Gradient text animation */
    .hero-section:hover .bg-gradient-to-r {
        background-size: 200% auto;
        background-position: right center;
        transition: background-position 0.7s ease;
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
        color: ;
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
        background-color: #fb8d00;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .popular-news-item:hover {
        background: #01016dff;
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
        color: #fcfcfcff;
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

        .hero-nav-btn {
            width: 44px;
            height: 44px;
            display: none;
        }

        .hero-pagination {
            bottom: 20px !important;
        }

        .hero-pagination .swiper-pagination-bullet {
            width: 8px;
            height: 8px;
            margin: 0 4px !important;
        }

        .mouse-follower,
        .corner-accents {
            display: none;
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