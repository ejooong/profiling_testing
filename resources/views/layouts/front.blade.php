<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? 'Website Resmi Partai NasDem Kabupaten Bojonegoro' }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'NasDem Bojonegoro' }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        :root {
            --nasdem-navy: #001F3F;
            --nasdem-navy-light: #0a2f5a;
            --nasdem-red: #e31b23;
            --nasdem-gold: #FFD700;
        }

        .nasdem-navy-bg {
            background-color: var(--nasdem-navy);
        }

        .nasdem-navy-text {
            color: var(--nasdem-navy);
        }

        .nasdem-red-bg {
            background-color: var(--nasdem-red);
        }

        .nasdem-red-text {
            color: var(--nasdem-red);
        }

        .nasdem-gold-text {
            color: var(--nasdem-gold);
        }

        /* Animasi untuk card berita */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Hover effect untuk card berita */
        .news-card {
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-bottom: 3px solid var(--nasdem-red);
        }

        /* Gradient untuk hero section */
        .nasdem-gradient {
            background: linear-gradient(135deg, var(--nasdem-navy) 0%, #0a2f5a 100%);
        }

        /* Styling untuk slider */
        .swiper-slide {
            height: 500px;
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .swiper-slide {
                height: 400px;
            }
        }

        /* Animation untuk badge trending */
        @keyframes pulse-gold {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .animate-pulse-gold {
            animation: pulse-gold 2s infinite;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--nasdem-navy);
            border-radius: 4px;
        }

        /* Full width container */
        .full-width {
            width: 100%;
            max-width: 100%;
        }

        /* Navbar aktif state */
        .nav-active {
            color: white;
            border-bottom: 2px solid var(--nasdem-red);
        }

        /* Mobile menu modern dengan animasi slide */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 85%;
            max-width: 320px;
            height: 100vh;
            background: linear-gradient(135deg, var(--nasdem-navy) 0%, #0a2f5a 100%);
            z-index: 9999;
            transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.15);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .mobile-menu.active {
            right: 0;
        }

        /* Overlay untuk mobile menu */
        .menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Style untuk mobile menu header */
        .mobile-menu-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(0, 0, 0, 0.2);
        }

        .mobile-menu-content {
            padding: 20px;
            flex: 1;
        }

        /* Style untuk link di mobile menu */
        .mobile-menu-link {
            display: block;
            padding: 16px 20px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            font-weight: 500;
            border-radius: 10px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            transform: translateX(20px);
            opacity: 0;
            animation: slideInRight 0.5s forwards;
        }

        .mobile-menu.active .mobile-menu-link {
            animation: slideInRight 0.5s forwards;
        }

        .mobile-menu-link:nth-child(1) { animation-delay: 0.1s; }
        .mobile-menu-link:nth-child(2) { animation-delay: 0.15s; }
        .mobile-menu-link:nth-child(3) { animation-delay: 0.2s; }
        .mobile-menu-link:nth-child(4) { animation-delay: 0.25s; }
        .mobile-menu-link:nth-child(5) { animation-delay: 0.3s; }
        .mobile-menu-link:nth-child(6) { animation-delay: 0.35s; }

        @keyframes slideInRight {
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .mobile-menu-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .mobile-menu-link.active {
            background: rgba(227, 27, 35, 0.2);
            color: white;
            border-left: 4px solid var(--nasdem-red);
        }

        /* Close button style */
        .close-menu-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .close-menu-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Mobile menu footer */
        .mobile-menu-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.2);
        }

        /* Logo di mobile menu */
        .mobile-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mobile-logo-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            color: var(--nasdem-red);
        }

        .mobile-logo-text {
            display: flex;
            flex-direction: column;
        }

        .mobile-logo-text .main {
            font-size: 18px;
            font-weight: bold;
            color: white;
        }

        .mobile-logo-text .sub {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            margin-top: -2px;
        }

        /* Tombol aksi di mobile */
        .mobile-action-btns {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .mobile-action-btn {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .mobile-action-btn.primary {
            background: var(--nasdem-red);
            color: white;
        }

        .mobile-action-btn.secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .mobile-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Hamburger icon animation */
        #mobile-menu-button i {
            transition: transform 0.3s ease;
        }

        #mobile-menu-button.active i {
            transform: rotate(90deg);
        }
    </style>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Session Status -->
    @if (session('status'))
    <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-4 py-2 rounded shadow-lg" id="session-alert">
        {{ session('status') }}
        <button onclick="document.getElementById('session-alert').remove()" class="ml-4">×</button>
    </div>
    @endif

    <!-- Navbar -->
    <nav class="nasdem-navy-bg text-white shadow-lg sticky top-0 z-50 full-width">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center space-x-2">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                                <span class="font-bold text-xl nasdem-red-text">N</span>
                            </div>
                            <div>
                                <span class="text-xl font-bold text-white">NasDem</span>
                                <span class="text-gray-300 block text-sm -mt-1">Bojonegoro</span>
                            </div>
                        </a>
                    </div>
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'nav-active' : 'text-gray-300 hover:text-white' }} px-3 py-2 text-sm font-medium">Beranda</a>
                        <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'nav-active' : 'text-gray-300 hover:text-white' }} px-3 py-2 text-sm font-medium">Profil</a>
                        <a href="{{ route('structure') }}" class="{{ request()->routeIs('structure') ? 'nav-active' : 'text-gray-300 hover:text-white' }} px-3 py-2 text-sm font-medium">Struktur</a>
                        <a href="{{ route('news.index') }}" class="{{ request()->routeIs('news.*') ? 'nav-active' : 'text-gray-300 hover:text-white' }} px-3 py-2 text-sm font-medium">Berita</a>
                        <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'nav-active' : 'text-gray-300 hover:text-white' }} px-3 py-2 text-sm font-medium">Galeri</a>
                        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'nav-active' : 'text-gray-300 hover:text-white' }} px-3 py-2 text-sm font-medium">Kontak</a>
                    </div>
                </div>
<div class="flex items-center">
    <!-- Desktop & Tablet Landscape: Tombol muncul -->
    <div class="hidden lg:flex items-center">asdsa
        <a href="{{ route('kader.register') }}" class="px-4 py-2 bg-red-600 hover:bg-blue-700 rounded-md text-white font-medium text-sm transition duration-300">
            <i class="fas fa-user-plus mr-2"></i>Daftar Kader
        </a>
        @auth
        <a href="{{ route('admin.dashboard') }}" class="ml-4 px-4 py-2 bg-white text-nasdem-navy rounded-md font-medium text-sm hover:bg-gray-100">
            Dashboard
        </a>
        @else
        <a href="{{ route('login') }}" class="ml-4 px-4 py-2 bg-white text-nasdem-navy rounded-md font-medium text-sm hover:bg-blue-100">
            Login
        </a>
        @endauth
    </div>
    
    <!-- Mobile & Tablet Portrait: Hanya tombol hamburger -->
    <button id="mobile-menu-button" class="lg:hidden text-white">
        <i class="fas fa-bars text-xl"></i>
    </button>
</div>

            <!-- Mobile Menu Overlay -->
            <div id="menu-overlay" class="menu-overlay"></div>

            <!-- Mobile Menu Modern -->
            <div id="mobile-menu" class="mobile-menu">
                <div class="mobile-menu-header">
                    <div class="mobile-logo">
                        <div class="mobile-logo-icon">N</div>
                        <div class="mobile-logo-text">
                            <div class="main">NasDem</div>
                            <div class="sub">Bojonegoro</div>
                        </div>
                    </div>
                    <button id="close-mobile-menu" class="close-menu-btn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="mobile-menu-content">
                    <a href="{{ route('home') }}" 
                       class="mobile-menu-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fas fa-home mr-3"></i>Beranda
                    </a>
                    <a href="{{ route('profile') }}" 
                       class="mobile-menu-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                        <i class="fas fa-user mr-3"></i>Profil
                    </a>
                    <a href="{{ route('structure') }}" 
                       class="mobile-menu-link {{ request()->routeIs('structure') ? 'active' : '' }}">
                        <i class="fas fa-sitemap mr-3"></i>Struktur
                    </a>
                    <a href="{{ route('news.index') }}" 
                       class="mobile-menu-link {{ request()->routeIs('news.*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper mr-3"></i>Berita
                    </a>
                    <a href="{{ route('gallery') }}" 
                       class="mobile-menu-link {{ request()->routeIs('gallery') ? 'active' : '' }}">
                        <i class="fas fa-images mr-3"></i>Galeri
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="mobile-menu-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                        <i class="fas fa-address-book mr-3"></i>Kontak
                    </a>
                </div>

                <div class="mobile-menu-footer">
                    <div class="mobile-action-btns">
                        <a href="{{ route('kader.register') }}" class="mobile-action-btn primary">
                            <i class="fas fa-user-plus mr-2"></i>Daftar Kader
                        </a>
                        @auth
                        <a href="{{ route('admin.dashboard') }}" class="mobile-action-btn secondary">
                            Dashboard
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="mobile-action-btn secondary">
                            Login
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="full-width">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="nasdem-navy-bg text-white pt-10 pb-6 full-width">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center mr-3">
                            <span class="font-bold text-xl text-red-600">N</span>
                        </div>
                        <div>
                            <span class="text-xl font-bold">NasDem</span>
                            <span class="text-gray-300 block text-sm -mt-1">Bojonegoro</span>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm mb-4">Partai Nasional Demokrat (NasDem) Kabupaten Bojonegoro, berkomitmen membangun daerah yang maju, adil, dan sejahtera.</p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-8 h-8 bg-blue-800 rounded-full flex items-center justify-center hover:bg-blue-700">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-blue-400 rounded-full flex items-center justify-center hover:bg-blue-500">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#" class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center hover:bg-green-700">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-4">Menu Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('profile') }}" class="text-gray-300 hover:text-white text-sm">Profil Partai</a></li>
                        <li><a href="{{ route('structure') }}" class="text-gray-300 hover:text-white text-sm">Struktur Organisasi</a></li>
                        <li><a href="{{ route('news.index') }}" class="text-gray-300 hover:text-white text-sm">Berita</a></li>
                        <li><a href="{{ route('gallery') }}" class="text-gray-300 hover:text-white text-sm">Galeri Kegiatan</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-4">Layanan</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('kader.register') }}" class="text-gray-300 hover:text-white text-sm">Pendaftaran Kader</a></li>
                        <li><a href="{{ route('membership.check') }}" class="text-gray-300 hover:text-white text-sm">Cek Keanggotaan</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white text-sm">Hubungi Kami</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-4">Kantor DPC</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-red-500"></i>
                            <span>Jl. Raya Bojonegoro No. 123, Kabupaten Bojonegoro, Jawa Timur</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3 text-red-500"></i>
                            <span>(0353) 123456</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-red-500"></i>
                            <span>info@nasdem-bojonegoro.id</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-3 text-red-500"></i>
                            <span>Senin - Jumat: 08:00 - 16:00</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-700 text-center">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Partai NasDem Kabupaten Bojonegoro. Semua hak dilindungi.</p>
                <p class="text-gray-400 text-sm mt-1">Website Resmi DPC Partai Nasional Demokrat Kabupaten Bojonegoro</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Inisialisasi Swiper untuk slider (satu slider saja)
        @if(request()->routeIs('home'))
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.mySwiper', {
                // Konfigurasi untuk auto slide setiap 3 detik
                autoplay: {
                    delay: 3000, // 3 detik
                    disableOnInteraction: false,
                },
                loop: true,
                speed: 800,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
        @endif

        // Mobile menu toggle dengan animasi smooth
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuOverlay = document.getElementById('menu-overlay');
        const closeMobileMenuBtn = document.getElementById('close-mobile-menu');
        const body = document.body;

        function openMobileMenu() {
            mobileMenu.classList.add('active');
            menuOverlay.classList.add('active');
            mobileMenuButton.classList.add('active');
            body.style.overflow = 'hidden'; // Mencegah scroll di background
        }

        function closeMobileMenu() {
            mobileMenu.classList.remove('active');
            menuOverlay.classList.remove('active');
            mobileMenuButton.classList.remove('active');
            body.style.overflow = ''; // Kembalikan scroll
        }

        // Event listeners
        mobileMenuButton.addEventListener('click', openMobileMenu);
        closeMobileMenuBtn.addEventListener('click', closeMobileMenu);
        menuOverlay.addEventListener('click', closeMobileMenu);

        // Close menu dengan escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeMobileMenu();
            }
        });

        // Close menu ketika klik link di mobile menu
        document.querySelectorAll('.mobile-menu-link').forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });

        // Tambahkan animasi pada card berita saat scroll
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fadeInUp');
                    }
                });
            }, observerOptions);

            // Observasi semua card berita
            document.querySelectorAll('.news-card').forEach(card => {
                observer.observe(card);
            });
        });
    </script>

    @stack('scripts')
</body>

</html>