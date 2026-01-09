@extends('layouts.front')

@section('title', 'Profil - NasDem Bojonegoro')

@section('content')
<!-- Hero Section with Particles Animation -->
<section class="nasdem-gradient py-16 md:py-20 full-width relative overflow-hidden" style="background: linear-gradient(135deg, #001F3F 0%, #0a2f5a 100%);">
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
<main class="full-width bg-gradient-to-r from-[#E69D00] to-[#E69D00]">
@if($dpd)
<!-- DPD Info -->
<section id="dpd-info" class="py-16  full-width fade-in-up">
    <div class="px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="bg-gray-50 rounded-2xl shadow-xl p-8 md:p-12 full-width">
            <!-- Main Title -->
            <div class="text-center mb-16 fade-in-up">
                <h2 class="text-3xl md:text-4xl font-bold text-[#001F3F] mb-4">Struktur Pimpinan</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Pimpinan Partai NasDem di Tingkat Pusat dan Daerah</p>
            </div>

            <!-- Ketua Umum (Tengah) -->
            <div class="fade-in-up animation-delay-100 mb-20">
                <div class="text-center">
                    <!-- Foto Ketua Umum - Kotak Besar -->
<div class="max-w-3xl mx-auto">
    <div class="aspect-square rounded-lg overflow-hidden border-4 border-white shadow-2xl mb-8">
        @if(file_exists(public_path('images/ketum.png')))
        <img src="{{ asset('images/ketum.png') }}" 
             alt="Ketua Umum Partai NasDem"
             class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        @else
        <div class="w-full h-full bg-gradient-to-r from-[#001F3F] to-blue-800 flex items-center justify-center">
            <i class="fas fa-user text-white text-12xl"></i>
        </div>
        @endif
    </div>
</div>
                    
                    <!-- Info Ketua Umum - Sederhana di Tengah -->
                    <div>
                        <h3 class="text-4xl md:text-5xl font-bold text-[#001F3F] mb-4">H. Surya Paloh</h3>
                        <div class="inline-block bg-gradient-to-r from-[#001F3F] to-blue-700 text-white px-8 py-3 rounded-lg font-bold text-xl md:text-2xl shadow-xl mb-6">
                            Ketua Umum Partai NasDem
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ketua DPW dan Ketua DPD (Sejajar) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 fade-in-up animation-delay-200">
                <!-- Ketua DPW (Kiri) -->
                <div class="leader-card">
                    <!-- Foto Ketua DPW - Kotak -->
                    <div class="w-64 h-64 rounded-lg overflow-hidden border-4 border-white shadow-xl mx-auto mb-8">
                        @if(file_exists(public_path('images/dpw.png')))
                        <img src="{{ asset('images/dpw.png') }}" 
                             alt="Ketua DPW Jawa Timur"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-gradient-to-r from-[#001F3F] to-blue-800 flex items-center justify-center">
                            <i class="fas fa-user text-white text-7xl"></i>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Info Ketua DPW - Sederhana -->
                    <div class="text-center">
                        <h3 class="text-3xl md:text-4xl font-bold text-[#001F3F] mb-4">{{ $dpd->ketua_dpw ?? 'Keling' }}</h3>
                        <div class="inline-block bg-gradient-to-r from-[#001F3F] to-blue-700 text-white px-6 py-2 rounded-lg font-bold text-lg md:text-xl shadow-lg">
                            Ketua Dewan Pimpinan Wilayah Jawa Timur
                        </div>
                    </div>
                </div>

                <!-- Ketua DPD (Kanan) -->
                <div class="leader-card">
                    <!-- Foto Ketua DPD - Kotak -->
                    <div class="w-64 h-64 rounded-lg overflow-hidden border-4 border-white shadow-xl mx-auto mb-8">
                        @if(file_exists(public_path('images/dpd.png')))
                        <img src="{{ asset('images/dpd.png') }}" 
                             alt="Ketua DPD Bojonegoro"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-gradient-to-r from-[#001F3F] to-blue-800 flex items-center justify-center">
                            <i class="fas fa-user text-white text-7xl"></i>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Info Ketua DPD - Sederhana -->
                    <div class="text-center">
                        <h3 class="text-3xl md:text-4xl font-bold text-[#001F3F] mb-4">{{ $dpd->ketua }}</h3>
                        <div class="inline-block bg-gradient-to-r from-[#001F3F] to-blue-700 text-white px-6 py-2 rounded-lg font-bold text-lg md:text-xl shadow-lg">
                            Ketua Dewan Pimpinan Daerah Bojonegoro
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi DPD Bojonegoro -->
            <!-- <div class="mt-20 pt-12 border-t border-gray-200 fade-in-up animation-delay-300"> -->
                <!-- Alamat DPD -->
                <!-- <div class="bg-white rounded-xl p-8 border border-[#001F3F]/20 shadow-lg mb-10">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                        <div class="w-16 h-16 rounded-lg bg-gradient-to-r from-[#001F3F] to-blue-700 flex items-center justify-center flex-shrink: 0 mx-auto md:mx-0">
                            <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                        </div>
                        <div class="text-center md:text-left">
                            <h3 class="text-2xl font-bold text-[#001F3F] mb-3">Alamat Kantor DPD</h3>
                            <p class="text-gray-700 text-lg">{{ $dpd->address }}</p>
                        </div>
                    </div>
                </div> -->

                <!-- Sekretaris & Bendahara -->
                <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10"> -->
                    <!-- Sekretaris -->
                    <!-- <div class="bg-white rounded-xl p-8 border border-[#001F3F]/20 shadow-lg">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 rounded-lg bg-gradient-to-r from-[#001F3F] to-blue-700 flex items-center justify-center">
                                <i class="fas fa-file-alt text-white text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-[#001F3F]">Sekretaris</h3>
                        </div>
                        <p class="text-gray-700 text-2xl font-semibold text-center md:text-left">{{ $dpd->sekretaris }}</p>
                    </div> -->

                    <!-- Bendahara -->
                    <!-- <div class="bg-white rounded-xl p-8 border border-[#001F3F]/20 shadow-lg">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 rounded-lg bg-gradient-to-r from-[#001F3F] to-blue-700 flex items-center justify-center">
                                <i class="fas fa-chart-pie text-white text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-[#001F3F]">Bendahara</h3>
                        </div>
                        <p class="text-gray-700 text-2xl font-semibold text-center md:text-left">{{ $dpd->bendahara }}</p>
                    </div>
                </div> -->
                
                <!-- Deskripsi DPD -->
                <!-- <div class="bg-white rounded-xl p-8 border border-[#001F3F]/20 shadow-lg">
                    <h3 class="text-2xl font-bold text-[#001F3F] mb-6">Tentang {{ $dpd->name }}</h3>
                    <p class="text-gray-700 text-lg leading-relaxed">{{ $dpd->description }}</p>
                </div>
            </div> -->

            
        </div>
    </div>
</section>
@endif

    <!-- Mars & Hymne NasDem -->
    <section class="py-16  full-width fade-in-up animation-delay-100">
        <div class="px-4 sm:px-6 lg:px-8 mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
<div class="section-header mb-10 flex flex-col items-center justify-center text-center">
    <div class="music-icon mb-4">
        <i class="fas fa-music"></i>
    </div>
    <div>
        <h2 class="section-title">Mars & Hymne Partai NasDem</h2>
        <p class="section-subtitle">Dengarkan dan pelajari lagu kebanggaan Partai NasDem</p>
    </div>
</div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Mars NasDem -->
                    <div class="video-card fade-in-up">
                        <div class="video-header">
                            <div class="video-icon">
                                <i class="fas fa-play-circle"></i>
                            </div>
                            <h3 class="video-title">Mars Partai NasDem</h3>
                        </div>
                        <div class="video-container">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/VeZMin-ESLE?si=7tT_Su5FlOf0oznp" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="video-info">
                            <p><i class="fas fa-clock mr-2"></i> Durasi: 3:45</p>
                            <p><i class="fas fa-eye mr-2"></i> Lirik tersedia</p>
                        </div>
                    </div>

                    <!-- Hymne NasDem -->
                    <div class="video-card fade-in-up animation-delay-100">
                        <div class="video-header">
                            <div class="video-icon">
                                <i class="fas fa-volume-up"></i>
                            </div>
                            <h3 class="video-title">Hymne Partai NasDem</h3>
                        </div>
                        <div class="video-container">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/pzGGa1isCbs?si=IHNz4HVC6pAcDRHe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="video-info">
                            <p><i class="fas fa-clock mr-2"></i> Durasi: 4:20</p>
                            <p><i class="fas fa-file-alt mr-2"></i> Teks tersedia</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-200 fade-in-up animation-delay-200">
                    <div class="music-note">
                        <i class="fas fa-music"></i>
                        <p class="music-text">Lagu-lagu ini mencerminkan semangat dan perjuangan Partai NasDem dalam membangun Indonesia yang lebih baik.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Anggota Dewan Kabupaten -->
    <section class="py-16 bg-gray-50 full-width fade-in-up animation-delay-100">
        <div class="px-4 sm:px-6 lg:px-8 mx-auto">
            <div class="bg-gray-50 rounded-2xl shadow-xl p-8 md:p-12">
                <div class="section-header mb-10 flex flex-col items-center justify-center text-center">
                    <div class="members-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h2 class="section-title">Anggota Dewan Perwakilan</h2>
                        <p class="section-subtitle">Perwakilan Partai NasDem di Kabupaten Bojonegoro</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($anggotaDewan ?? [] as $anggota)
                    <div class="member-card fade-in-up animation-delay-{{ $loop->index * 50 }}">
                        <div class="member-photo">
                            @if($anggota->photo && file_exists(public_path('storage/' . $anggota->photo)))
                            <img src="{{ asset('storage/' . $anggota->photo) }}" 
                                 alt="{{ $anggota->name }}"
                                 class="group-hover:scale-110">
                            @else
                            <div class="photo-placeholder bg-gradient-to-r from-[#001F3F] to-blue-700">
                                <i class="fas fa-user text-white text-3xl"></i>
                            </div>
                            @endif
                            <div class="member-badge">{{ $anggota->jabatan }}</div>
                        </div>
                        
                        <div class="member-info">
                            <h3 class="member-name">{{ $anggota->name }}</h3>
                            <p class="member-position">{{ $anggota->jabatan_detail }}</p>
                            <div class="member-commission">
                                <i class="fas fa-sitemap mr-2"></i>
                                {{ $anggota->komisi ?? 'Komisi' }}
                            </div>
                            <div class="member-contact">
                                @if($anggota->email)
                                <a href="mailto:{{ $anggota->email }}" class="contact-link">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                @endif
                                @if($anggota->phone)
                                <a href="tel:{{ $anggota->phone }}" class="contact-link">
                                    <i class="fas fa-phone"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Fallback jika tidak ada data -->
                    @if(empty($anggotaDewan) || count($anggotaDewan) === 0)
                    <div class="col-span-full text-center py-12">
                        <div class="no-data-icon">
                            <i class="fas fa-users-slash text-6xl text-gray-400 mb-6"></i>
                            <h3 class="text-2xl font-bold text-gray-600 mb-4">Data Sedang Disiapkan</h3>
                            <p class="text-gray-500 max-w-md mx-auto">Informasi mengenai anggota dewan perwakilan sedang dalam proses pengumpulan data. Silakan cek kembali beberapa waktu mendatang.</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-12 pt-8 border-t border-gray-200 fade-in-up">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="stats-card">
                            <div class="stats-number">{{ count($anggotaDewan ?? []) }}</div>
                            <div class="stats-label">Total Anggota</div>
                        </div>
                        <div class="stats-card">
                            <div class="stats-number">{{ $dapilCount ?? '8' }}</div>
                            <div class="stats-label">Daerah Pemilihan</div>
                        </div>
                        <div class="stats-card">
                            <div class="stats-number">{{ $komisiCount ?? '4' }}</div>
                            <div class="stats-label">Komisi</div>
                        </div>
                        <a href="{{ route('structure') }}" class="members-cta-btn">
                            <i class="fas fa-sitemap mr-3"></i>Lihat Struktur Lengkap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi & Misi -->
    <section class="py-16  full-width fade-in-up animation-delay-300">
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
    <section class="py-16  full-width fade-in-up animation-delay-400">
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
    <section class="py-16 bg-gray-100 full-width fade-in-up animation-delay-500">
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
    <section class="py-20 bg-gradient-to-r from-[#001F3F] via-blue-700 to-blue-800 full-width fade-in-up animation-delay-600">
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

    // Member card hover effect
    const memberCards = document.querySelectorAll('.member-card');
    memberCards.forEach(card => {
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

    // YouTube iframe lazy loading
    document.addEventListener('DOMContentLoaded', function() {
        const videoContainers = document.querySelectorAll('.video-container');
        
        videoContainers.forEach(container => {
            const iframe = container.querySelector('iframe');
            if (iframe) {
                // Add loading attribute for better performance
                iframe.setAttribute('loading', 'lazy');
                
                // Handle YouTube iframe API if needed
                iframe.setAttribute('src', iframe.getAttribute('src') + '&enablejsapi=1');
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
    /* Leader Cards */
.leader-card {
    background: white;
    border-radius: 20px;
    padding: 40px 32px;
    text-align: center;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    border: 2px solid transparent;
    position: relative;
    overflow: hidden;
}

.leader-card:hover {
    border-color: #001F3F;
    box-shadow: 0 25px 60px rgba(0, 31, 63, 0.15);
    transform: translateY(-8px);
}

.leader-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: linear-gradient(90deg, #001F3F, #0a2f5a);
}

/* Responsive Design for DPD Section */
@media (max-width: 768px) {
    .leader-card {
        padding: 32px 24px;
    }
    
    .w-80, .w-96 {
        width: 280px;
        height: 280px;
    }
    
    .w-64 {
        width: 200px;
        height: 200px;
    }
}

@media (max-width: 640px) {
    .grid-cols-2 {
        grid-template-columns: 1fr;
    }
    
    .leader-card {
        margin-bottom: 40px;
    }
    
    .leader-card:last-child {
        margin-bottom: 0;
    }
    
    .w-80, .w-96 {
        width: 240px;
        height: 240px;
    }
    
    .w-64 {
        width: 180px;
        height: 180px;
    }
}

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

    /* Video Section */
    .music-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 24px;
        font-size: 24px;
        color: white;
        background: linear-gradient(135deg, #001F3F, #0a2f5a);
    }

    .video-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        border: 2px solid transparent;
    }

    .video-card:hover {
        border-color: #001F3F;
        box-shadow: 0 20px 50px rgba(0, 31, 63, 0.15);
        transform: translateY(-5px);
    }

    .video-header {
        padding: 24px 24px 0;
        display: flex;
        align-items: center;
    }

    .video-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #001F3F, #0a2f5a);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        color: white;
        font-size: 18px;
    }

    .video-title {
        font-size: 20px;
        font-weight: bold;
        color: #374151;
    }

    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        height: 0;
        overflow: hidden;
        margin: 16px;
        border-radius: 12px;
        background: #000;
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    .video-info {
        padding: 16px 24px 24px;
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: #6B7280;
        border-top: 1px solid #F3F4F6;
    }

    .music-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        padding: 20px;
        background: linear-gradient(135deg, rgba(0, 31, 63, 0.1), rgba(10, 47, 90, 0.05));
        border-radius: 12px;
        border-left: 4px solid #001F3F;
    }

    .music-note i {
        color: #001F3F;
        font-size: 24px;
    }

    .music-text {
        flex: 1;
        color: #374151;
        font-size: 16px;
        font-style: italic;
    }

    /* Member Cards */
    .members-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 24px;
        font-size: 24px;
        color: white;
        background: linear-gradient(135deg, #001F3F, #0a2f5a);
    }

    .member-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        border: 2px solid transparent;
    }

    .member-card:hover {
        border-color: #001F3F;
        box-shadow: 0 20px 50px rgba(0, 31, 63, 0.15);
        transform: translateY(-5px);
    }

    .member-photo {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .member-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .photo-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .member-badge {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(135deg, #001F3F, #0a2f5a);
        color: white;
        padding: 8px 16px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        backdrop-filter: blur(10px);
    }

    .member-info {
        padding: 24px;
    }

    .member-name {
        font-size: 18px;
        font-weight: bold;
        color: #374151;
        margin-bottom: 4px;
    }

    .member-position {
        font-size: 14px;
        color: #001F3F;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .member-commission {
        font-size: 13px;
        color: #6B7280;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
    }

    .member-contact {
        display: flex;
        gap: 12px;
        border-top: 1px solid #F3F4F6;
        padding-top: 16px;
    }

    .contact-link {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #F3F4F6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6B7280;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .contact-link:hover {
        background: #001F3F;
        color: white;
        transform: translateY(-2px);
    }

    .no-data-icon {
        padding: 40px 20px;
    }

    .stats-card {
        text-align: center;
        padding: 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        min-width: 120px;
    }

    .stats-number {
        font-size: 32px;
        font-weight: bold;
        color: #001F3F;
        margin-bottom: 8px;
    }

    .stats-label {
        font-size: 14px;
        color: #6B7280;
    }

    .members-cta-btn {
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

    .members-cta-btn:hover {
        background: #0a2f5a;
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0, 31, 63, 0.3);
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
        background: linear-gradient(135deg, #001F3F, #0a2f5a);
    }

    .mission-icon {
        background: linear-gradient(135deg, #0a2f5a, #001F3F);
    }

    .history-icon {
        background: linear-gradient(135deg, #001F3F, #0a2f5a);
    }

    .program-icon {
        background: linear-gradient(135deg, #0a2f5a, #001F3F);
    }

    .vision-content {
        position: relative;
        background: #f0f8ff;
        padding: 40px;
        border-radius: 16px;
        border-left: 4px solid #001F3F;
    }

    .vision-quote {
        position: absolute;
        color: #001F3F;
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
        box-shadow: 0 10px 25px rgba(0, 31, 63, 0.08);
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
        background: linear-gradient(135deg, #001F3F, #0a2f5a);
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
        background: #f8fafc;
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
        .program-icon,
        .music-icon,
        .members-icon {
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

        .video-container {
            margin: 12px;
        }

        .video-info {
            padding: 12px 16px 16px;
            flex-direction: column;
            gap: 8px;
        }

        .member-photo {
            height: 180px;
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

        .stats-card {
            min-width: 100px;
            padding: 16px;
        }

        .stats-number {
            font-size: 28px;
        }
    }

    @media (max-width: 640px) {
        .grid-cols-3,
        .grid-cols-4 {
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
        .program-icon,
        .music-icon,
        .members-icon {
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

        .music-note {
            flex-direction: column;
            text-align: center;
        }

        .stats-card {
            width: 100%;
            margin-bottom: 12px;
        }

        .members-cta-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush