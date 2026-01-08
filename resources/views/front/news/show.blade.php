@extends('layouts.front')

@section('title', $news->title . ' - NasDem Bojonegoro')

@section('content')
<!-- Hero Section with Particles Animation -->
<section class="relative overflow-hidden nasdem-gradient py-16 md:py-20 full-width">
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
    
    <div class="relative px-4 sm:px-6 lg:px-8 mx-auto z-10">
        <div class="max-w-6xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="mb-8 md:mb-12 fade-in-up">
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route('home') }}" class="breadcrumb-item">
                            <i class="fas fa-home mr-2"></i>Beranda
                        </a>
                    </li>
                    <li>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                    </li>
                    <li>
                        <a href="{{ route('news.index') }}" class="breadcrumb-item">
                            <i class="fas fa-newspaper mr-2"></i>Berita
                        </a>
                    </li>
                    <li>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                    </li>
                    <li>
                        <a href="{{ route('news.category', $news->category->slug) }}" 
                           class="breadcrumb-item" 
                           style="color: {{ $news->category->color }}">
                            <i class="fas fa-folder mr-2"></i>{{ $news->category->name }}
                        </a>
                    </li>
                    <li>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                    </li>
                    <li class="breadcrumb-current">
                        <span class="truncate">{{ Str::limit($news->title, 40) }}</span>
                    </li>
                </ol>
            </nav>

            <!-- Article Header -->
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-block mb-6 fade-in-up animation-delay-100">
                    <span class="category-display" style="background-color: {{ $news->category->color }}">
                        {{ $news->category->name }}
                    </span>
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight fade-in-up animation-delay-200">{{ $news->title }}</h1>
                
                <div class="flex flex-wrap items-center justify-center text-gray-200 text-sm md:text-base mb-6 gap-4 fade-in-up animation-delay-300">
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ $news->published_at->format('d F Y') }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-eye mr-2"></i>
                        <span>{{ $news->views }} kali dilihat</span>
                    </div>
                    @if($news->dpc)
                    <div class="meta-item">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>DPC {{ $news->dpc->kecamatan_name }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="full-width bg-gray-50 py-12 md:py-16">
    <div class="px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="flex flex-col lg:flex-row gap-8 xl:gap-12">
            <!-- Article Content -->
            <div class="lg:w-2/3">
                <article class="bg-white rounded-2xl shadow-xl overflow-hidden hover-card fade-in-up">
                    <!-- Featured Image -->
                    @if($news->featured_image)
                    <div class="relative h-80 md:h-96 lg:h-[500px]">
                        <img src="{{ asset('storage/' . $news->featured_image) }}" 
                             alt="{{ $news->title }}" 
                             class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                        @if($news->is_featured)
                        <div class="absolute top-6 right-6">
                            <span class="featured-display">
                                <i class="fas fa-star mr-2"></i>Featured
                            </span>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Article Body -->
                    <div class="p-6 md:p-8 lg:p-10">
                        <!-- Author -->
                        <div class="author-card mb-8">
                            @if($news->author_photo)
                            <img src="{{ asset('storage/' . $news->author_photo) }}" 
                                 alt="{{ $news->author_name }}" 
                                 class="author-photo">
                            @else
                            <div class="author-avatar">
                                <span class="text-xl font-bold">{{ substr($news->author_name ?: $news->user->name, 0, 1) }}</span>
                            </div>
                            @endif
                            <div class="author-info">
                                <div class="author-name">{{ $news->author_name ?: $news->user->name }}</div>
                                <div class="author-role">Penulis Berita</div>
                                <div class="author-date">
                                    <i class="fas fa-clock mr-1"></i>
                                    Dipublikasikan {{ $news->published_at->format('d F Y') }}
                                </div>
                            </div>
                        </div>

                        <!-- Excerpt -->
                        <div class="excerpt-box fade-in-up animation-delay-100">
                            <i class="fas fa-quote-left excerpt-icon"></i>
                            {{ $news->excerpt }}
                        </div>

                        <!-- Content -->
                        <div class="article-content mb-12 fade-in-up animation-delay-200">
                            {!! $news->content !!}
                        </div>

                        <!-- Tags -->
                        @if($news->meta_keywords && count($news->meta_keywords) > 0)
                        <div class="mb-12 fade-in-up animation-delay-300">
                            <h3 class="section-title">
                                <i class="fas fa-tags mr-3"></i>Tags
                            </h3>
                            <div class="tags-container">
                                @foreach($news->meta_keywords as $keyword)
                                <a href="{{ route('news.index') }}?tag={{ urlencode(trim($keyword)) }}" 
                                   class="tag-item">
                                    #{{ trim($keyword) }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Share Buttons -->
                        <div class="share-section fade-in-up animation-delay-400">
                            <h3 class="section-title">
                                <i class="fas fa-share-alt mr-3"></i>Bagikan Berita Ini
                            </h3>
                            <div class="share-buttons">
                                <a href="#" class="share-btn facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="share-btn twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="share-btn whatsapp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="#" class="share-btn link">
                                    <i class="fas fa-link"></i>
                                </a>
                                <a href="#" class="share-btn instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Comments Section -->
                <div class="mt-12 bg-white rounded-2xl shadow-xl p-8 hover-card fade-in-up">
                    <h2 class="section-title-large">
                        <i class="fas fa-comments mr-3"></i>Komentar ({{ $news->comments_count ?? 0 }})
                    </h2>
                    <div class="info-box mb-8">
                        <i class="fas fa-info-circle info-icon"></i>
                        <div>
                            <h4 class="info-title">Fitur Komentar</h4>
                            <p class="info-text">Fitur komentar sedang dalam pengembangan. Silakan hubungi kami untuk memberikan masukan.</p>
                        </div>
                    </div>
                    
                    <!-- Comment Form (Placeholder) -->
                    <div class="comment-form-container">
                        <h3 class="form-title">Tinggalkan Komentar</h3>
                        <p class="form-description">Silakan login untuk memberikan komentar.</p>
                        <div class="form-buttons">
                            <a href="{{ route('login') }}" class="form-btn primary">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login untuk Komentar
                            </a>
                            <a href="{{ route('contact') }}" class="form-btn secondary">
                                <i class="fas fa-envelope mr-2"></i>Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3">
                <!-- Popular News Sidebar -->
                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 mb-8 fade-in-up animation-delay-100">
                    <div class="sidebar-header">
                        <div class="sidebar-icon"></div>
                        <h3 class="sidebar-title">Berita Populer</h3>
                    </div>
                    
                    <div class="sidebar-list">
                        @foreach($popularNews as $popular)
                        <div class="sidebar-item group">
                            @if($popular->featured_image)
                            <div class="sidebar-image">
                                <img src="{{ asset('storage/' . $popular->featured_image) }}" 
                                     alt="{{ $popular->title }}" 
                                     class="group-hover:scale-105">
                            </div>
                            @else
                            <div class="sidebar-image-placeholder">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            @endif
                            <div class="sidebar-content">
                                <h4 class="sidebar-item-title">
                                    <a href="{{ route('news.show', $popular->slug) }}">{{ $popular->title }}</a>
                                </h4>
                                <div class="sidebar-meta">
                                    <div class="meta-stat">
                                        <i class="fas fa-eye"></i>
                                        <span>{{ $popular->views }} views</span>
                                    </div>
                                    <div class="meta-stat">
                                        <i class="fas fa-calendar"></i>
                                        <span>{{ $popular->published_at->format('d M') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Related News -->
                @if($relatedNews->count() > 0)
                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 mb-8 fade-in-up animation-delay-200">
                    <div class="sidebar-header">
                        <div class="sidebar-icon"></div>
                        <h3 class="sidebar-title">Berita Terkait</h3>
                    </div>
                    
                    <div class="related-list">
                        @foreach($relatedNews as $related)
                        <div class="related-item group">
                            @if($related->featured_image)
                            <img src="{{ asset('storage/' . $related->featured_image) }}" 
                                 alt="{{ $related->title }}" 
                                 class="related-image group-hover:scale-105">
                            @endif
                            <div class="related-meta">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $related->published_at->format('d M Y') }}
                            </div>
                            <h4 class="related-title">
                                <a href="{{ route('news.show', $related->slug) }}">{{ $related->title }}</a>
                            </h4>
                            <div class="related-action">
                                <a href="{{ route('news.show', $related->slug) }}" class="related-link">
                                    Baca <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Categories -->
                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 fade-in-up animation-delay-300">
                    <h3 class="sidebar-title mb-6">Kategori Berita</h3>
                    
                    <div class="categories-list">
                        @foreach($categories as $category)
                        <a href="{{ route('news.category', $category->slug) }}" 
                           class="category-sidebar-item group">
                            <div class="category-sidebar-content">
                                <div class="category-dot" style="background-color: {{ $category->color }}"></div>
                                <span class="category-name">{{ $category->name }}</span>
                            </div>
                            <div class="category-sidebar-meta">
                                <span class="category-count">{{ $category->beritas()->count() }}</span>
                                <i class="fas fa-chevron-right category-arrow"></i>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter CTA -->
        <div class="mt-16 md:mt-20 bg-gradient-to-r from-[#001F3F] via-blue-800 to-blue-900 rounded-2xl shadow-xl p-8 md:p-12 text-white text-center overflow-hidden relative fade-in-up">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
            </div>
            
            <div class="relative max-w-2xl mx-auto z-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/20 mb-6">
                    <i class="fas fa-newspaper text-3xl"></i>
                </div>
                <h3 class="text-2xl md:text-3xl font-bold mb-4">Tetap Update dengan Berita Kami</h3>
                <p class="text-gray-200 text-lg mb-6">Berlangganan newsletter untuk mendapatkan berita terbaru langsung ke email Anda</p>
                <form class="newsletter-form">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <input type="email" 
                               placeholder="Email Anda" 
                               class="newsletter-input">
                        <button type="submit" class="newsletter-btn">
                            <i class="fas fa-paper-plane mr-2"></i>Berlangganan
                        </button>
                    </div>
                </form>
                <p class="text-gray-300 text-sm mt-4">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Privasi Anda terjamin. Kami tidak akan mengirim spam.
                </p>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
// Share Button Functionality
const shareBtns = document.querySelectorAll('.share-btn');

shareBtns.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const type = Array.from(this.classList).find(cls => cls !== 'share-btn');
        
        // Simulate share functionality
        const shareUrl = window.location.href;
        const shareTitle = document.title;
        
        switch(type) {
            case 'facebook':
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}`, '_blank');
                break;
            case 'twitter':
                window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(shareUrl)}&text=${encodeURIComponent(shareTitle)}`, '_blank');
                break;
            case 'whatsapp':
                window.open(`https://wa.me/?text=${encodeURIComponent(shareTitle + ' ' + shareUrl)}`, '_blank');
                break;
            case 'link':
                navigator.clipboard.writeText(shareUrl).then(() => {
                    alert('Link berhasil disalin ke clipboard!');
                });
                break;
            case 'instagram':
                alert('Bagikan melalui Instagram story atau feed');
                break;
        }
    });
});

// Newsletter Form
const newsletterForm = document.querySelector('.newsletter-form');
if (newsletterForm) {
    newsletterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const emailInput = this.querySelector('input[type="email"]');
        const submitBtn = this.querySelector('button[type="submit"]');
        
        if (emailInput.value) {
            // Show loading state
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = `
                <div class="flex items-center justify-center">
                    <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin mr-2"></div>
                    <span>Memproses...</span>
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

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 100,
                behavior: 'smooth'
            });
        }
    });
});

// Category item hover effect
const categoryItems = document.querySelectorAll('.category-sidebar-item');

categoryItems.forEach(item => {
    item.addEventListener('mouseenter', function() {
        this.style.transform = 'translateX(5px)';
    });
    
    item.addEventListener('mouseleave', function() {
        this.style.transform = 'translateX(0)';
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
.animation-delay-400 { transition-delay: 0.4s; }

/* Breadcrumb */
.breadcrumb {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 14px;
}

.breadcrumb-item {
    display: inline-flex;
    align-items: center;
    color: #E5E7EB;
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-item:hover {
    color: white;
    text-decoration: underline;
}

.breadcrumb-separator {
    margin: 0 8px;
    color: #9CA3AF;
    font-size: 10px;
}

.breadcrumb-current {
    color: white;
    font-weight: 500;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Category Display */
.category-display {
    display: inline-block;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: bold;
    color: white;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
}

/* Meta Items */
.meta-item {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.meta-item:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

.meta-item i {
    font-size: 12px;
}

/* Article Card */
.hover-card {
    transition: all 0.4s ease;
    border-bottom: 3px solid transparent;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    border-bottom: 3px solid #001F3F;
}

.featured-display {
    background: linear-gradient(135deg, #FFD700, #FFA500);
    color: #000;
    font-size: 12px;
    font-weight: bold;
    padding: 8px 16px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
    display: inline-flex;
    align-items: center;
}

/* Author Card */
.author-card {
    display: flex;
    align-items: center;
    padding: 20px;
    background: linear-gradient(to right, #F8FAFC, #F1F5F9);
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.author-photo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    margin-right: 20px;
}

.author-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #001F3F, #0a2f5a);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    margin-right: 20px;
    border: 4px solid white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.author-info {
    flex: 1;
}

.author-name {
    font-size: 20px;
    font-weight: bold;
    color: #1F2937;
    margin-bottom: 4px;
}

.author-role {
    color: #6B7280;
    font-size: 14px;
    margin-bottom: 8px;
}

.author-date {
    color: #9CA3AF;
    font-size: 13px;
    display: flex;
    align-items: center;
}

/* Excerpt Box */
.excerpt-box {
    position: relative;
    font-size: 18px;
    line-height: 1.7;
    color: #4B5563;
    background: linear-gradient(to right, #F0F9FF, #E0F2FE);
    padding: 30px 40px;
    border-radius: 16px;
    margin: 30px 0;
    border-left: 4px solid #001F3F;
    font-style: italic;
}

.excerpt-icon {
    position: absolute;
    top: 15px;
    left: 15px;
    font-size: 24px;
    color: #001F3F;
    opacity: 0.3;
}

/* Article Content */
.article-content {
    font-size: 16px;
    line-height: 1.8;
    color: #374151;
}

.article-content p {
    margin-bottom: 1.5em;
}

.article-content h2 {
    color: #1F2937;
    font-weight: 700;
    font-size: 1.875em;
    margin-top: 2em;
    margin-bottom: 1em;
    padding-bottom: 0.5em;
    border-bottom: 2px solid #001F3F;
}

.article-content h3 {
    color: #1F2937;
    font-weight: 600;
    font-size: 1.5em;
    margin-top: 1.75em;
    margin-bottom: 1em;
}

.article-content ul, .article-content ol {
    margin-bottom: 1.5em;
    padding-left: 1.5em;
}

.article-content li {
    margin-bottom: 0.75em;
}

.article-content img {
    border-radius: 1rem;
    margin: 2em 0;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    max-width: 100%;
    height: auto;
}

.article-content blockquote {
    border-left: 4px solid #001F3F;
    padding-left: 1.5em;
    font-style: italic;
    color: #6B7280;
    margin: 2em 0;
    background-color: #F9FAFB;
    padding: 1.5em;
    border-radius: 0 0.5rem 0.5rem 0;
}

.article-content a {
    color: #001F3F;
    text-decoration: underline;
    font-weight: 500;
}

.article-content a:hover {
    color: #0a2f5a;
}

.article-content table {
    width: 100%;
    margin: 2em 0;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.article-content th, .article-content td {
    padding: 0.75em 1em;
    border: 1px solid #E5E7EB;
}

.article-content th {
    background-color: #F3F4F6;
    font-weight: 600;
    color: #374151;
}

/* Section Titles */
.section-title {
    font-size: 1.5em;
    font-weight: 600;
    color: #1F2937;
    margin-bottom: 1em;
    display: flex;
    align-items: center;
}

.section-title-large {
    font-size: 2em;
    font-weight: 700;
    color: #1F2937;
    margin-bottom: 1em;
    display: flex;
    align-items: center;
}

/* Tags */
.tags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.tag-item {
    display: inline-block;
    padding: 8px 16px;
    background: #F3F4F6;
    color: #4B5563;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid #E5E7EB;
}

.tag-item:hover {
    background: #001F3F;
    color: white;
    border-color: #001F3F;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 31, 63, 0.2);
}

/* Share Section */
.share-section {
    background: linear-gradient(to right, #F8FAFC, #F1F5F9);
    padding: 30px;
    border-radius: 16px;
    margin-top: 40px;
}

.share-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 20px;
}

.share-btn {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.share-btn:hover {
    transform: translateY(-4px) scale(1.1);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.share-btn.facebook { background: #1877F2; }
.share-btn.twitter { background: #1DA1F2; }
.share-btn.whatsapp { background: #25D366; }
.share-btn.link { background: #6B7280; }
.share-btn.instagram { background: linear-gradient(45deg, #405DE6, #5851DB, #833AB4, #C13584, #E1306C, #FD1D1D); }

/* Info Box */
.info-box {
    display: flex;
    align-items: flex-start;
    background: #FFF3CD;
    border-left: 4px solid #FFC107;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}

.info-icon {
    font-size: 24px;
    color: #FFC107;
    margin-right: 15px;
    margin-top: 2px;
}

.info-title {
    font-size: 18px;
    font-weight: 600;
    color: #856404;
    margin-bottom: 5px;
}

.info-text {
    color: #856404;
    line-height: 1.6;
}

/* Comment Form */
.comment-form-container {
    background: #F9FAFB;
    padding: 30px;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
}

.form-title {
    font-size: 20px;
    font-weight: 600;
    color: #1F2937;
    margin-bottom: 10px;
}

.form-description {
    color: #6B7280;
    margin-bottom: 25px;
}

.form-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.form-btn {
    display: inline-flex;
    align-items: center;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.form-btn.primary {
    background: #001F3F;
    color: white;
}

.form-btn.primary:hover {
    background: #0a2f5a;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 31, 63, 0.2);
}

.form-btn.secondary {
    background: white;
    color: #001F3F;
    border: 2px solid #001F3F;
}

.form-btn.secondary:hover {
    background: #F3F4F6;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 31, 63, 0.1);
}

/* Sidebar */
.sidebar-header {
    display: flex;
    align-items: center;
    margin-bottom: 25px;
}

.sidebar-icon {
    width: 4px;
    height: 24px;
    background: #001F3F;
    border-radius: 2px;
    margin-right: 12px;
}

.sidebar-title {
    font-size: 1.5em;
    font-weight: 700;
    color: #1F2937;
}

/* Sidebar List */
.sidebar-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.sidebar-item {
    display: flex;
    align-items: flex-start;
    padding-bottom: 20px;
    border-bottom: 1px solid #E5E7EB;
    transition: all 0.3s ease;
}

.sidebar-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.sidebar-item:hover {
    transform: translateX(5px);
}

.sidebar-image {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    overflow: hidden;
    margin-right: 15px;
    flex-shrink: 0;
}

.sidebar-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.sidebar-image-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    background: #F3F4F6;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
    color: #9CA3AF;
    font-size: 20px;
}

.sidebar-content {
    flex: 1;
    min-width: 0;
}

.sidebar-item-title {
    font-size: 15px;
    font-weight: 600;
    color: #1F2937;
    margin-bottom: 8px;
    line-height: 1.4;
}

.sidebar-item-title a {
    color: inherit;
    text-decoration: none;
}

.sidebar-item-title a:hover {
    color: #001F3F;
    text-decoration: underline;
}

.sidebar-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    font-size: 12px;
    color: #6B7280;
}

.meta-stat {
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Related News */
.related-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.related-item {
    background: #F9FAFB;
    padding: 20px;
    border-radius: 12px;
    border: 1px solid #E5E7EB;
    transition: all 0.3s ease;
}

.related-item:hover {
    background: #F3F4F6;
    border-color: #D1D5DB;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

.related-image {
    width: 100%;
    height: 160px;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 15px;
}

.related-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-meta {
    font-size: 12px;
    color: #6B7280;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.related-title {
    font-size: 16px;
    font-weight: 600;
    color: #1F2937;
    margin-bottom: 15px;
    line-height: 1.4;
}

.related-title a {
    color: inherit;
    text-decoration: none;
}

.related-title a:hover {
    color: #001F3F;
    text-decoration: underline;
}

.related-action {
    text-align: right;
}

.related-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #001F3F;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.related-link:hover {
    color: #0a2f5a;
    transform: translateX(3px);
}

/* Categories Sidebar */
.categories-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.category-sidebar-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    background: #F9FAFB;
    border-radius: 10px;
    border: 1px solid #E5E7EB;
    text-decoration: none;
    transition: all 0.3s ease;
}

.category-sidebar-item:hover {
    background: #F3F4F6;
    border-color: #D1D5DB;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transform: translateX(5px);
}

.category-sidebar-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.category-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.category-name {
    font-size: 15px;
    font-weight: 500;
    color: #374151;
}

.category-sidebar-meta {
    display: flex;
    align-items: center;
    gap: 8px;
}

.category-count {
    font-size: 13px;
    font-weight: 600;
    color: #6B7280;
    background: white;
    padding: 2px 8px;
    border-radius: 10px;
    border: 1px solid #E5E7EB;
}

.category-arrow {
    font-size: 12px;
    color: #9CA3AF;
    transition: transform 0.3s ease;
}

.category-sidebar-item:hover .category-arrow {
    color: #001F3F;
    transform: translateX(3px);
}

/* Newsletter Form */
.newsletter-form {
    margin-top: 20px;
}

.newsletter-input {
    flex: 1;
    padding: 16px 20px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    background: white;
    color: #1F2937;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    outline: none;
    transition: all 0.3s ease;
}

.newsletter-input:focus {
    box-shadow: 0 4px 20px rgba(0, 31, 63, 0.2);
}

.newsletter-btn {
    padding: 16px 30px;
    background: white;
    color: #001F3F;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    white-space: nowrap;
}

.newsletter-btn:hover {
    background: #F3F4F6;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.newsletter-btn:active {
    transform: translateY(-1px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .breadcrumb {
        font-size: 12px;
    }
    
    .category-display {
        font-size: 12px;
        padding: 6px 16px;
    }
    
    .meta-item {
        font-size: 11px;
        padding: 4px 8px;
    }
    
    .excerpt-box {
        font-size: 16px;
        padding: 20px 30px;
    }
    
    .article-content {
        font-size: 15px;
    }
    
    .sidebar-image,
    .sidebar-image-placeholder {
        width: 60px;
        height: 60px;
    }
    
    .sidebar-item-title {
        font-size: 14px;
    }
    
    .related-image {
        height: 120px;
    }
    
    .form-buttons {
        flex-direction: column;
    }
    
    .form-btn {
        width: 100%;
        justify-content: center;
    }
    
    .newsletter-form {
        flex-direction: column;
    }
    
    .newsletter-input,
    .newsletter-btn {
        width: 100%;
    }
}

@media (max-width: 640px) {
    .author-card {
        flex-direction: column;
        text-align: center;
    }
    
    .author-photo,
    .author-avatar {
        margin-right: 0;
        margin-bottom: 15px;
    }
    
    .share-buttons {
        justify-content: center;
    }
}
</style>
@endpush