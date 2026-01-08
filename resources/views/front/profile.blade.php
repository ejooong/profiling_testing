@extends('layouts.front')

@section('title', 'Profil - NasDem Bojonegoro')

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
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 fade-in-up">Profil Partai NasDem Bojonegoro</h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-8 fade-in-up animation-delay-100">Bersama Rakyat, Membangun Bojonegoro yang Maju, Adil, dan Sejahtera</p>

            <!-- Animated CTA Button -->
            <div class="fade-in-up animation-delay-200">
                <a href="#dpd-info" class="inline-flex items-center bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-xl font-bold hover:bg-white/20 transition duration-300 shadow-lg hover:shadow-xl border border-white/20">
                    <i class="fas fa-info-circle mr-3"></i>Pelajari Selengkapnya
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="full-width bg-gray-50">
    @if($dpd)
    <!-- DPD Info -->
    <section id="dpd-info" class="py-16 bg-white full-width fade-in-up">
        <div class="px-4 sm:px-6 lg:px-8 mx-auto">
            <div class="bg-gray-50 rounded-2xl shadow-xl p-8 md:p-12 full-width">
                <div class="flex flex-col lg:flex-row items-center gap-8 mb-10">
                    <div class="lg:w-1/3">
                        <div class="dpd-logo bounce-in">
                            <span class="logo-text">NasDem</span>
                            <div class="logo-glow"></div>
                        </div>
                    </div>
                    <div class="lg:w-2/3">
                        <h2 class="text-3xl md:text-4xl font-bold text-[#001F3F] mb-4">{{ $dpd->name }}</h2>
                        <p class="text-gray-600 text-lg mb-6">
                            <i class="fas fa-map-marker-alt text-[#001F3F] mr-2"></i>{{ $dpd->address }}
                        </p>
                        <p class="text-gray-700 text-lg leading-relaxed">{{ $dpd->description }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 fade-in-up animation-delay-100">
                    <div class="leadership-card">
                        <div class="leadership-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h3 class="leadership-title">Ketua</h3>
                        <p class="leadership-name">{{ $dpd->ketua }}</p>
                    </div>
                    <div class="leadership-card">
                        <div class="leadership-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h3 class="leadership-title">Sekretaris</h3>
                        <p class="leadership-name">{{ $dpd->sekretaris }}</p>
                    </div>
                    <div class="leadership-card">
                        <div class="leadership-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <h3 class="leadership-title">Bendahara</h3>
                        <p class="leadership-name">{{ $dpd->bendahara }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Visi & Misi -->
    <section class="py-16 bg-gray-100 full-width fade-in-up animation-delay-100">
        <div class="px-4 sm:px-6 lg:px-8 mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Visi -->
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 fade-in-up">
                    <div class="flex items-center mb-8">
                        <div class="vision-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h2 class="section-title">Visi</h2>
                    </div>
                    <div class="vision-content">
                        <i class="fas fa-quote-left vision-quote"></i>
                        <p class="vision-text">{{ $visiMisi['visi']['content'] }}</p>
                        <i class="fas fa-quote-right vision-quote"></i>
                    </div>
                </div>

                <!-- Misi -->
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 fade-in-up animation-delay-100">
                    <div class="flex items-center mb-8">
                        <div class="mission-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h2 class="section-title">Misi</h2>
                    </div>
                    <ul class="space-y-6">
                        @foreach($visiMisi['misi']['items'] as $index => $item)
                        <li class="mission-item fade-in-up animation-delay-{{ ($index + 1) * 50 }}">
                            <div class="mission-number">{{ $index + 1 }}</div>
                            <div class="mission-content">
                                <h4 class="mission-title">Misi {{ $index + 1 }}</h4>
                                <p class="mission-text">{{ $item }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Sejarah -->
    <section class="py-16 bg-white full-width fade-in-up animation-delay-200">
        <div class="px-4 sm:px-6 lg:px-8 mx-auto">
            <div class="bg-gray-50 rounded-2xl shadow-xl p-8 md:p-12">
                <div class="section-header">
                    <div class="history-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <div>
                        <h2 class="section-title">Sejarah</h2>
                        <p class="section-subtitle">Perjalanan Partai NasDem Bojonegoro</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="prose prose-lg max-w-none fade-in-up">
                        <p class="history-text">{{ $visiMisi['sejarah']['content'] }}</p>
                        <a href="{{ route('news.index') }}" class="history-cta-btn">
                            <i class="fas fa-newspaper mr-3"></i>Lihat Berita Sejarah Lengkap
                        </a>
                    </div>

                    <div class="facts-card fade-in-up animation-delay-100">
                        <h3 class="facts-title">Fakta & Angka</h3>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="fact-item">
                                <div class="fact-number">2012</div>
                                <div class="fact-label">Tahun Berdiri</div>
                            </div>
                            <div class="fact-item">
                                <div class="fact-number">28</div>
                                <div class="fact-label">DPC Kecamatan</div>
                            </div>
                            <div class="fact-item">
                                <div class="fact-number">400+</div>
                                <div class="fact-label">DPRT Desa/Kelurahan</div>
                            </div>
                            <div class="fact-item">
                                <div class="fact-number">4.8K+</div>
                                <div class="fact-label">Kader Terdaftar</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Kerja -->
    <section class="py-16 bg-gray-100 full-width fade-in-up animation-delay-300">
        <div class="px-4 sm:px-6 lg:px-8 mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                <div class="section-header">
                    <div class="program-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <div>
                        <h2 class="section-title">Program Kerja</h2>
                        <p class="section-subtitle">Rencana aksi untuk mewujudkan visi dan misi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($visiMisi['program']['items'] as $index => $program)
                    <div class="program-card fade-in-up animation-delay-{{ $index * 100 }}">
                        <div class="program-number">{{ $index + 1 }}</div>
                        <h3 class="program-title">Program {{ $index + 1 }}</h3>
                        <p class="program-text">{{ $program }}</p>
                        <div class="program-action">
                            <span>Pelajari Detail</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-12 pt-10 border-t border-gray-200 text-center fade-in-up">
                    <p class="contact-invite">Ingin tahu lebih detail tentang program kerja kami?</p>
                    <a href="{{ route('contact') }}" class="contact-cta-btn">
                        <i class="fas fa-envelope mr-4"></i>Hubungi Kami untuk Konsultasi
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 bg-gradient-to-r from-[#001F3F] via-blue-800 to-blue-900 full-width fade-in-up animation-delay-400">
        <div class="px-4 sm:px-6 lg:px-8 mx-auto text-center">
            <div class="cta-icon">
                <i class="fas fa-users"></i>
            </div>
            <h2 class="cta-title">Bergabung Menjadi Kader NasDem</h2>
            <p class="cta-subtitle">Jadilah bagian dari perubahan untuk Bojonegoro yang lebih baik bersama Partai NasDem.</p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('kader.register') }}" class="cta-btn-primary">
                    <i class="fas fa-user-plus mr-4"></i>Daftar Sekarang
                </a>
                <a href="{{ route('structure') }}" class="cta-btn-secondary">
                    <i class="fas fa-sitemap mr-4"></i>Lihat Struktur Organisasi
                </a>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
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

    // Program card hover effect
    const programCards = document.querySelectorAll('.program-card');
    programCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Leadership card hover effect
    const leadershipCards = document.querySelectorAll('.leadership-card');
    leadershipCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
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

    /* DPD Logo */
    .dpd-logo {
        position: relative;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        background: linear-gradient(135deg, #001F3F, #0a2f5a);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 20px 50px rgba(0, 31, 63, 0.3);
        overflow: hidden;
    }

    .logo-text {
        font-size: 48px;
        font-weight: bold;
        color: white;
        z-index: 2;
        position: relative;
    }

    .logo-glow {
        position: absolute;
        inset: -50%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0) 70%);
        animation: rotate 10s linear infinite;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Leadership Cards */
    .leadership-card {
        background: white;
        border-radius: 20px;
        padding: 32px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        border: 2px solid transparent;
    }

    .leadership-card:hover {
        border-color: #001F3F;
        box-shadow: 0 20px 50px rgba(0, 31, 63, 0.15);
        transform: translateY(-5px);
    }

    .leadership-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #001F3F, #0a2f5a);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        color: white;
        font-size: 24px;
    }

    .leadership-title {
        font-size: 24px;
        font-weight: bold;
        color: #001F3F;
        margin-bottom: 16px;
    }

    .leadership-name {
        font-size: 20px;
        font-weight: 600;
        color: #374151;
    }

    /* Section Titles */
    .section-title {
        font-size: 32px;
        font-weight: bold;
        color: #001F3F;
    }

    .section-subtitle {
        font-size: 18px;
        color: #6B7280;
        margin-top: 8px;
    }

    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 40px;
    }

    /* Vision Section */
    .vision-icon,
    .mission-icon,
    .history-icon,
    .program-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 24px;
        font-size: 24px;
        color: white;
    }

    .vision-icon {
        background: linear-gradient(135deg, #3B82F6, #2563EB);
    }

    .mission-icon {
        background: linear-gradient(135deg, #001F3F, #0a2f5a);
    }

    .history-icon {
        background: linear-gradient(135deg, #F59E0B, #D97706);
    }

    .program-icon {
        background: linear-gradient(135deg, #10B981, #059669);
    }

    .vision-content {
        position: relative;
        background: #EFF6FF;
        padding: 40px;
        border-radius: 16px;
        border-left: 4px solid #3B82F6;
    }

    .vision-quote {
        position: absolute;
        color: #3B82F6;
        opacity: 0.2;
        font-size: 48px;
    }

    .vision-quote:first-child {
        top: 20px;
        left: 20px;
    }

    .vision-quote:last-child {
        bottom: 20px;
        right: 20px;
    }

    .vision-text {
        font-size: 20px;
        line-height: 1.7;
        color: #374151;
        font-style: italic;
        position: relative;
        z-index: 1;
    }

    /* Mission Section */
    .mission-item {
        display: flex;
        align-items: flex-start;
        background: white;
        padding: 24px;
        border-radius: 12px;
        border: 2px solid #F3F4F6;
        transition: all 0.3s ease;
    }

    .mission-item:hover {
        border-color: #001F3F;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        transform: translateX(5px);
    }

    .mission-number {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #001F3F, #0a2f5a);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 16px;
        margin-top: 4px;
    }

    .mission-content {
        flex: 1;
    }

    .mission-title {
        font-size: 18px;
        font-weight: 600;
        color: #001F3F;
        margin-bottom: 8px;
    }

    .mission-text {
        color: #4B5563;
        line-height: 1.6;
    }

    /* History Section */
    .history-text {
        font-size: 18px;
        line-height: 1.8;
        color: #374151;
        margin-bottom: 32px;
    }

    .history-cta-btn {
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

    .history-cta-btn:hover {
        background: #0a2f5a;
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0, 31, 63, 0.3);
    }

    /* Facts Card */
    .facts-card {
        background: linear-gradient(135deg, #001F3F, #1E40AF);
        border-radius: 16px;
        padding: 32px;
        color: white;
    }

    .facts-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 32px;
        text-align: center;
        color: white;
    }

    .fact-item {
        text-align: center;
        padding: 20px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .fact-item:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-3px);
    }

    .fact-number {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 8px;
        color: white;
    }

    .fact-label {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
    }

    /* Program Cards */
    .program-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .program-card:hover {
        border-color: #001F3F;
        box-shadow: 0 20px 50px rgba(0, 31, 63, 0.15);
        transform: translateY(-10px);
    }

    .program-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #001F3F, #0a2f5a);
    }

    .program-number {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #001F3F, #0a2f5a);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 20px;
        margin: 0 auto 20px;
    }

    .program-title {
        font-size: 20px;
        font-weight: bold;
        color: #001F3F;
        margin-bottom: 16px;
    }

    .program-text {
        color: #4B5563;
        line-height: 1.6;
        margin-bottom: 24px;
    }

    .program-action {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #001F3F;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .program-card:hover .program-action {
        transform: translateX(5px);
    }

    .program-action i {
        margin-left: 8px;
        transition: transform 0.3s ease;
    }

    .program-card:hover .program-action i {
        transform: translateX(5px);
    }

    /* Contact CTA */
    .contact-invite {
        font-size: 20px;
        color: #4B5563;
        margin-bottom: 24px;
    }

    .contact-cta-btn {
        display: inline-flex;
        align-items: center;
        padding: 16px 32px;
        background: #001F3F;
        color: white;
        border-radius: 12px;
        font-weight: bold;
        font-size: 18px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 31, 63, 0.2);
    }

    .contact-cta-btn:hover {
        background: #0a2f5a;
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 31, 63, 0.3);
    }

    /* Call to Action */
    .cta-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        color: white;
        font-size: 32px;
    }

    .cta-title {
        font-size: 48px;
        font-weight: bold;
        color: white;
        margin-bottom: 16px;
        line-height: 1.2;
    }

    .cta-subtitle {
        font-size: 24px;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 40px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .cta-btn-primary {
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

    .cta-btn-primary:hover {
        background: #F3F4F6;
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
    }

    .cta-btn-secondary {
        display: inline-flex;
        align-items: center;
        padding: 16px 32px;
        background: #001F3F;
        color: white;
        border: 2px solid white;
        border-radius: 12px;
        font-weight: bold;
        font-size: 18px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .cta-btn-secondary:hover {
        background: #0a2f5a;
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dpd-logo {
            width: 120px;
            height: 120px;
        }

        .logo-text {
            font-size: 36px;
        }

        .section-title {
            font-size: 28px;
        }

        .vision-icon,
        .mission-icon,
        .history-icon,
        .program-icon {
            width: 48px;
            height: 48px;
            font-size: 20px;
            margin-right: 16px;
        }

        .vision-content {
            padding: 24px;
        }

        .vision-quote {
            font-size: 32px;
        }

        .cta-title {
            font-size: 36px;
        }

        .cta-subtitle {
            font-size: 18px;
        }

        .cta-btn-primary,
        .cta-btn-secondary {
            padding: 12px 24px;
            font-size: 16px;
        }
    }

    @media (max-width: 640px) {
        .grid-cols-3 {
            grid-template-columns: 1fr;
        }

        .grid-cols-2 {
            grid-template-columns: 1fr;
        }

        .section-header {
            flex-direction: column;
            text-align: center;
        }

        .vision-icon,
        .mission-icon,
        .history-icon,
        .program-icon {
            margin-right: 0;
            margin-bottom: 16px;
        }

        .mission-item {
            flex-direction: column;
            text-align: center;
        }

        .mission-number {
            margin-right: 0;
            margin-bottom: 12px;
        }
    }
</style>
@endpush