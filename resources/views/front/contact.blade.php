@extends('layouts.front')

@section('title', 'Kontak - NasDem Bojonegoro')

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
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 fade-in-up">Hubungi Kami</h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-8 fade-in-up animation-delay-100">Silakan hubungi kami untuk informasi lebih lanjut tentang Partai NasDem Kabupaten Bojonegoro</p>
            
            <!-- Animated CTA Button -->
            <div class="fade-in-up animation-delay-200">
                <a href="#contact-form" class="inline-flex items-center bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-xl font-bold hover:bg-white/20 transition duration-300 shadow-lg hover:shadow-xl border border-white/20">
                    <i class="fas fa-paper-plane mr-3"></i>Kirim Pesan Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="full-width bg-gradient-to-r from-[#E69D00] to-[#E69D00] py-12 md:py-16">
    <div class="px-4 sm:px-6 lg:px-8 mx-auto">
        <!-- Flash Message with Animation -->
        @if(session('success'))
        <div class="mb-10 bg-white border border-green-200 rounded-2xl shadow-lg p-6 md:p-8 text-center max-w-2xl mx-auto bounce-in">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-green-800 mb-2">Pesan Terkirim!</h3>
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 xl:gap-12">
            <!-- Contact Information -->
            <div>
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10 hover-card fade-in-up">
                    <div class="flex items-center mb-8">
                        <div class="w-2 h-10 bg-[#06284f] rounded-full mr-4"></div>
                        <h2 class="text-2xl md:text-3xl font-bold text-[#001F3F]">Informasi Kontak</h2>
                    </div>
                    
                    <!-- Contact List -->
                    <div class="space-y-8">
                        <!-- Address with Hover Effect -->
                        <div class="contact-item group">
                            <div class="flex items-start p-4 rounded-xl transition-all duration-300 group-hover:bg-gradient-to-r group-hover:from-red-50 group-hover:to-white">
                                <div class="flex-shrink-0 icon-container">
                                    <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center group-hover:bg-red-200 transition duration-300 shadow-md group-hover:scale-110">
                                        <i class="fas fa-map-marker-alt text-[#06284f] text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-[#06284f] transition duration-300">Alamat Kantor DPD</h3>
                                    <p class="text-gray-600">
                                        Jl. Raya Bojonegoro No. 123<br>
                                        Kabupaten Bojonegoro, Jawa Timur<br>
                                        Kode Pos: 62114
                                    </p>
                                    <a href="https://maps.google.com/?q=Jl+Raya+Bojonegoro+No.+123+Bojonegoro" 
                                       target="_blank"
                                       class="inline-flex items-center text-[#06284f] text-sm font-medium mt-3 opacity-0 group-hover:opacity-100 transition duration-300">
                                        <i class="fas fa-directions mr-2"></i>Dapatkan Petunjuk Arah
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Phone with Click-to-Call -->
                        <div class="contact-item group">
                            <div class="flex items-start p-4 rounded-xl transition-all duration-300 group-hover:bg-gradient-to-r group-hover:from-blue-50 group-hover:to-white">
                                <div class="flex-shrink-0 icon-container">
                                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition duration-300 shadow-md group-hover:scale-110">
                                        <i class="fas fa-phone text-blue-600 text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-[#06284f] transition duration-300">Telepon & WhatsApp</h3>
                                    <div class="flex flex-wrap gap-3 items-center">
                                        <a href="tel:+62353123456" class="text-gray-600 text-lg font-medium hover:text-[#06284f] transition duration-300">
                                            (0353) 123456
                                        </a>
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">WhatsApp Tersedia</span>
                                    </div>
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        <a href="tel:+62353123456" 
                                           class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 transition duration-300">
                                            <i class="fas fa-phone mr-2"></i>Telepon Sekarang
                                        </a>
                                        <a href="https://wa.me/6281234567890" 
                                           target="_blank"
                                           class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium hover:bg-green-200 transition duration-300">
                                            <i class="fab fa-whatsapp mr-2"></i>Chat WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email with Quick Copy -->
                        <div class="contact-item group">
                            <div class="flex items-start p-4 rounded-xl transition-all duration-300 group-hover:bg-gradient-to-r group-hover:from-green-50 group-hover:to-white">
                                <div class="flex-shrink-0 icon-container">
                                    <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center group-hover:bg-green-200 transition duration-300 shadow-md group-hover:scale-110">
                                        <i class="fas fa-envelope text-green-600 text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-[#06284f] transition duration-300">Email Resmi</h3>
                                    <div class="flex items-center justify-between">
                                        <a href="mailto:info@nasdem-bojonegoro.id" 
                                           class="text-gray-600 text-lg font-medium hover:text-[#06284f] transition duration-300 break-all">
                                            info@nasdem-bojonegoro.id
                                        </a>
                                        <button onclick="copyEmail()" 
                                                class="copy-btn ml-3 text-gray-400 hover:text-[#06284f] transition duration-300"
                                                title="Salin email">
                                            <i class="far fa-copy"></i>
                                        </button>
                                    </div>
                                    <div class="text-sm text-green-600 mt-2 hidden" id="copy-success">
                                        <i class="fas fa-check-circle mr-1"></i>Email berhasil disalin!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media with Hover Effects -->
                    <div class="mt-12 pt-10 border-t border-gray-100">
                        <h3 class="text-xl font-bold text-[#001F3F] mb-6">Ikuti Media Sosial Kami</h3>
                        <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                            <a href="#" class="social-media-card facebook">
                                <i class="fab fa-facebook-f text-lg"></i>
                                <span class="social-text">Facebook</span>
                            </a>
                            <a href="#" class="social-media-card instagram">
                                <i class="fab fa-instagram text-lg"></i>
                                <span class="social-text">Instagram</span>
                            </a>
                            <a href="#" class="social-media-card twitter">
                                <i class="fab fa-twitter text-lg"></i>
                                <span class="social-text">Twitter</span>
                            </a>
                            <a href="#" class="social-media-card whatsapp">
                                <i class="fab fa-whatsapp text-lg"></i>
                                <span class="social-text">WhatsApp</span>
                            </a>
                            <a href="#" class="social-media-card youtube">
                                <i class="fab fa-youtube text-lg"></i>
                                <span class="social-text">YouTube</span>
                            </a>
                            <a href="#" class="social-media-card tiktok">
                                <i class="fab fa-tiktok text-lg"></i>
                                <span class="social-text">TikTok</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact with Animation -->
                <div class="mt-8 emergency-contact fade-in-up animation-delay-100">
                    <div class="bg-gradient-to-r from-[#06284f] to-red-600 rounded-2xl shadow-xl p-8 md:p-10 text-white relative overflow-hidden">
                        <!-- Pulsing Animation -->
                        <div class="absolute top-4 right-4">
                            <div class="pulse-dot"></div>
                        </div>
                        
                        <div class="flex items-center mb-6">
                            <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center mr-4">
                                <i class="fas fa-exclamation-triangle text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Kontak Darurat 24/7</h3>
                                <p class="text-red-100 text-sm">Untuk kebutuhan mendesak di luar jam kerja</p>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center justify-between bg-white/10 p-5 rounded-xl gap-4">
                            <div class="flex-1">
                                <p class="text-lg font-semibold">Hotline Darurat</p>
                                <p class="text-2xl font-bold tracking-wide">0800-1234-5678</p>
                            </div>
                            <div class="flex gap-3">
                                <a href="tel:080012345678" 
                                   class="bg-white text-[#06284f] px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition duration-300 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-phone mr-2"></i>Telepon
                                </a>
                                <a href="sms:080012345678" 
                                   class="bg-[#001F3F] text-white px-6 py-3 rounded-lg font-bold hover:bg-[#0a2f5a] transition duration-300 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-sms mr-2"></i>SMS
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div id="contact-form">
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10 hover-card  fade-in-up animation-delay-100">
                    <div class="flex items-center mb-8">
                        <div class="w-2 h-10 bg-[#06284f] rounded-full mr-4"></div>
                        <h2 class="text-2xl md:text-3xl font-bold text-[#001F3F]">Kirim Pesan</h2>
                    </div>
                    
                    <!-- Form Progress Indicator -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Langkah 1 dari 2</span>
                            <span class="text-sm font-medium text-[#06284f]">66%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-[#06284f] h-2 rounded-full transition-all duration-500" style="width: 66%"></div>
                        </div>
                    </div>
                    
                    <form action="{{ route('contact.store') }}" method="POST" id="contactForm">
                        @csrf
                        
                        <div class="space-y-6">
                            <!-- Name with Floating Label -->
                            <div class="form-group">
                                <div class="relative">
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           required
                                           value="{{ old('name') }}"
                                           class="form-input peer">
                                    <label for="name" class="form-label floating">Nama Lengkap <span class="text-red-500">*</span></label>
                                </div>
                                @error('name')
                                <p class="error-message">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                                @enderror
                            </div>

                            <!-- Email & Phone Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Email -->
                                <div class="form-group">
                                    <div class="relative">
                                        <input type="email" 
                                               name="email" 
                                               id="email" 
                                               required
                                               value="{{ old('email') }}"
                                               class="form-input peer">
                                        <label for="email" class="form-label floating">Email <span class="text-red-500">*</span></label>
                                    </div>
                                    @error('email')
                                    <p class="error-message">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="form-group">
                                    <div class="relative">
                                        <input type="text" 
                                               name="phone" 
                                               id="phone" 
                                               required
                                               value="{{ old('phone') }}"
                                               class="form-input peer">
                                        <label for="phone" class="form-label floating">Telepon <span class="text-red-500">*</span></label>
                                    </div>
                                    @error('phone')
                                    <p class="error-message">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Subject with Modern Select -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Subjek <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    <label class="subject-option">
                                        <input type="radio" name="subject" value="Informasi Umum" {{ old('subject') == 'Informasi Umum' ? 'checked' : '' }} class="hidden peer">
                                        <div class="subject-card peer-checked:border-[#06284f] peer-checked:bg-red-50">
                                            <i class="fas fa-info-circle text-blue-500 mb-2"></i>
                                            <span>Informasi</span>
                                        </div>
                                    </label>
                                    <label class="subject-option">
                                        <input type="radio" name="subject" value="Pendaftaran Kader" {{ old('subject') == 'Pendaftaran Kader' ? 'checked' : '' }} class="hidden peer">
                                        <div class="subject-card peer-checked:border-[#06284f] peer-checked:bg-red-50">
                                            <i class="fas fa-user-plus text-green-500 mb-2"></i>
                                            <span>Pendaftaran</span>
                                        </div>
                                    </label>
                                    <label class="subject-option">
                                        <input type="radio" name="subject" value="Kegiatan Partai" {{ old('subject') == 'Kegiatan Partai' ? 'checked' : '' }} class="hidden peer">
                                        <div class="subject-card peer-checked:border-[#06284f] peer-checked:bg-red-50">
                                            <i class="fas fa-calendar-alt text-purple-500 mb-2"></i>
                                            <span>Kegiatan</span>
                                        </div>
                                    </label>
                                    <label class="subject-option">
                                        <input type="radio" name="subject" value="Pengaduan" {{ old('subject') == 'Pengaduan' ? 'checked' : '' }} class="hidden peer">
                                        <div class="subject-card peer-checked:border-[#06284f] peer-checked:bg-red-50">
                                            <i class="fas fa-exclamation-triangle text-yellow-500 mb-2"></i>
                                            <span>Pengaduan</span>
                                        </div>
                                    </label>
                                    <label class="subject-option">
                                        <input type="radio" name="subject" value="Kerjasama" {{ old('subject') == 'Kerjasama' ? 'checked' : '' }} class="hidden peer">
                                        <div class="subject-card peer-checked:border-[#06284f] peer-checked:bg-red-50">
                                            <i class="fas fa-handshake text-indigo-500 mb-2"></i>
                                            <span>Kerjasama</span>
                                        </div>
                                    </label>
                                    <label class="subject-option">
                                        <input type="radio" name="subject" value="Lainnya" {{ old('subject') == 'Lainnya' ? 'checked' : '' }} class="hidden peer">
                                        <div class="subject-card peer-checked:border-[#06284f] peer-checked:bg-red-50">
                                            <i class="fas fa-ellipsis-h text-gray-500 mb-2"></i>
                                            <span>Lainnya</span>
                                        </div>
                                    </label>
                                </div>
                                @error('subject')
                                <p class="error-message">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                                @enderror
                            </div>

                            <!-- Message with Character Counter -->
                            <div class="form-group">
                                <div class="relative">
                                    <textarea name="message" 
                                              id="message" 
                                              rows="5" 
                                              required
                                              class="form-input peer resize-none"
                                              maxlength="1000">{{ old('message') }}</textarea>
                                    <label for="message" class="form-label floating">Pesan Anda <span class="text-red-500">*</span></label>
                                    <div class="absolute bottom-3 right-3">
                                        <span id="char-count" class="text-xs text-gray-400">0/1000</span>
                                    </div>
                                </div>
                                @error('message')
                                <p class="error-message">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                                @enderror
                            </div>

                            <!-- Submit Button with Loading Animation -->
                            <div class="pt-4">
                                <button type="submit" 
                                        id="submitBtn"
                                        class="submit-btn w-full relative overflow-hidden">
                                    <span class="relative z-10">
                                        <i class="fas fa-paper-plane mr-3"></i>Kirim Pesan Sekarang
                                    </span>
                                    <div class="absolute inset-0 bg-gradient-to-r from-red-700 to-red-800 opacity-0 hover:opacity-100 transition duration-300"></div>
                                    <div class="loader hidden absolute inset-0 flex items-center justify-center bg-[#06284f]">
                                        <div class="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                    </div>
                                </button>
                                <p class="text-center text-gray-500 text-sm mt-4">
                                    <i class="fas fa-shield-alt text-green-500 mr-1"></i>
                                    Data Anda aman dan tidak akan dibagikan
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Map Section with Interactive Features -->
        <div class="mt-12 md:mt-16 fade-in-up">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover-card">
                <div class="p-8 md:p-10 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-10 bg-[#06284f] rounded-full mr-4"></div>
                            <h2 class="text-2xl md:text-3xl font-bold text-[#001F3F]">Lokasi Kantor DPD</h2>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="map-control-btn active" data-view="street">
                                <i class="fas fa-road"></i>
                            </button>
                            <button class="map-control-btn" data-view="satellite">
                                <i class="fas fa-satellite"></i>
                            </button>
                        </div>
                    </div>
                    <p class="text-gray-600 mt-4">Kantor Dewan Pimpinan Daerah Partai NasDem Kabupaten Bojonegoro</p>
                </div>
                
                <div class="relative h-96 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                    <!-- Interactive Map Container -->
                    <div class="absolute inset-0 map-container" id="map-view">
                        <!-- Map Layers -->
                        <div class="map-layer street active">
                            <div class="map-grid">
                                @for ($i = 0; $i < 16; $i++)
                                <div class="map-tile"></div>
                                @endfor
                            </div>
                            <!-- Map Marker -->
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                <div class="map-marker animate-bounce">
                                    <div class="w-12 h-12 rounded-full bg-[#06284f] flex items-center justify-center text-white shadow-lg">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-8 border-r-8 border-t-8 border-l-transparent border-r-transparent border-t-[#06284f]"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="map-layer satellite">
                            <div class="satellite-view">
                                <div class="satellite-image"></div>
                                <div class="satellite-grid"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Map Info Panel -->
                    <div class="absolute bottom-6 left-6 right-6 bg-white/90 backdrop-blur-sm rounded-xl p-4 shadow-lg">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-[#06284f]/10 flex items-center justify-center mr-3">
                                    <i class="fas fa-map-marked-alt text-[#06284f]"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-[#001F3F]">Jl. Raya Bojonegoro No. 123</h3>
                                    <p class="text-sm text-gray-600">Koordinat: -7.150975, 111.881832</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <a href="https://www.google.com/maps?q=Jl+Raya+Bojonegoro+No.+123+Bojonegoro" 
                                   target="_blank"
                                   class="inline-flex items-center bg-[#001F3F] text-white px-5 py-2.5 rounded-lg font-medium hover:bg-[#0a2f5a] transition duration-300 shadow-md hover:shadow-lg">
                                    <i class="fas fa-directions mr-2"></i>Navigasi
                                </a>
                                <button onclick="shareLocation()"
                                        class="inline-flex items-center bg-white text-gray-700 px-5 py-2.5 rounded-lg font-medium hover:bg-gray-50 transition duration-300 shadow-md hover:shadow-lg border border-gray-200">
                                    <i class="fas fa-share-alt mr-2"></i>Bagikan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Hours with Animation -->
        <div class="mt-12 md:mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="stats-card fade-in-up animation-delay-100">
                <div class="icon-wrapper bg-blue-100">
                    <i class="fas fa-clock text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-[#001F3F] mb-2">Jam Operasional</h3>
                <p class="text-gray-600 mb-1">Senin - Jumat</p>
                <p class="text-gray-800 font-semibold text-lg">08:00 - 16:00 WIB</p>
                <div class="mt-4 text-sm text-gray-500">
                    <i class="fas fa-calendar-times text-red-500 mr-1"></i>
                    Tutup pada hari libur nasional
                </div>
            </div>
            
            <div class="stats-card fade-in-up animation-delay-200">
                <div class="icon-wrapper bg-green-100">
                    <i class="fas fa-headset text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold text-[#001F3F] mb-2">Respon Cepat</h3>
                <p class="text-gray-600 mb-1">Waktu respon rata-rata</p>
                <p class="text-gray-800 font-semibold text-lg">1x24 Jam Kerja</p>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mr-2">
                            <div class="bg-green-500 h-1.5 rounded-full" style="width: 95%"></div>
                        </div>
                        <span>95%</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Tingkat kepuasan pelanggan</p>
                </div>
            </div>
            
            <div class="stats-card fade-in-up animation-delay-300">
                <div class="icon-wrapper bg-red-100">
                    <i class="fas fa-users text-[#06284f]"></i>
                </div>
                <h3 class="text-xl font-bold text-[#001F3F] mb-2">Tim Support</h3>
                <p class="text-gray-600 mb-1">Tim khusus pelayanan</p>
                <p class="text-gray-800 font-semibold text-lg">Siap Membantu Anda</p>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <div class="flex -space-x-2 mr-3">
                        <div class="w-8 h-8 rounded-full bg-blue-500 border-2 border-white"></div>
                        <div class="w-8 h-8 rounded-full bg-green-500 border-2 border-white"></div>
                        <div class="w-8 h-8 rounded-full bg-yellow-500 border-2 border-white"></div>
                        <div class="w-8 h-8 rounded-full bg-purple-500 border-2 border-white">+2</div>
                    </div>
                    <span>5 anggota tim</span>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-12 md:mt-16 fade-in-up">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10">
                <div class="flex items-center mb-8">
                    <div class="w-2 h-10 bg-[#06284f] rounded-full mr-4"></div>
                    <h2 class="text-2xl md:text-3xl font-bold text-[#001F3F]">Pertanyaan Umum</h2>
                </div>
                
                <div class="space-y-4">
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Berapa lama waktu respon untuk email?</span>
                            <i class="fas fa-chevron-down transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer">
                            <p>Kami akan membalas email dalam waktu 1x24 jam kerja. Untuk pertanyaan mendesak, silakan hubungi hotline telepon kami.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Apakah ada biaya untuk konsultasi?</span>
                            <i class="fas fa-chevron-down transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer">
                            <p>Konsultasi informasi umum tidak dikenakan biaya. Untuk layanan khusus akan diberitahukan terlebih dahulu.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Bagaimana cara mendaftar menjadi kader?</span>
                            <i class="fas fa-chevron-down transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer">
                            <p>Silakan pilih subjek "Pendaftaran Kader" pada form kontak atau kunjungi langsung kantor DPD untuk informasi lengkap.</p>
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
// Email Copy Function
function copyEmail() {
    const email = 'info@nasdem-bojonegoro.id';
    navigator.clipboard.writeText(email).then(() => {
        const successMsg = document.getElementById('copy-success');
        successMsg.classList.remove('hidden');
        setTimeout(() => {
            successMsg.classList.add('hidden');
        }, 2000);
    });
}

// Character Counter for Message
const messageTextarea = document.getElementById('message');
const charCount = document.getElementById('char-count');

messageTextarea.addEventListener('input', function() {
    const length = this.value.length;
    charCount.textContent = `${length}/1000`;
    
    if (length > 900) {
        charCount.classList.add('text-red-500');
    } else {
        charCount.classList.remove('text-red-500');
    }
});

// Form Submission with Loading Animation
const contactForm = document.getElementById('contactForm');
const submitBtn = document.getElementById('submitBtn');

if (contactForm) {
    contactForm.addEventListener('submit', function() {
        const loader = submitBtn.querySelector('.loader');
        const btnText = submitBtn.querySelector('.relative.z-10');
        
        btnText.classList.add('opacity-0');
        loader.classList.remove('hidden');
        
        // Simulate form validation before submission
        setTimeout(() => {
            btnText.classList.remove('opacity-0');
            loader.classList.add('hidden');
        }, 3000);
    });
}

// Map View Toggle
const mapControlBtns = document.querySelectorAll('.map-control-btn');
const mapLayers = document.querySelectorAll('.map-layer');

mapControlBtns.forEach(btn => {
    btn.addEventListener('click', function() {
        const view = this.dataset.view;
        
        // Update active button
        mapControlBtns.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        // Update active map layer
        mapLayers.forEach(layer => {
            layer.classList.remove('active');
            if (layer.classList.contains(view)) {
                layer.classList.add('active');
            }
        });
    });
});

// FAQ Accordion
const faqQuestions = document.querySelectorAll('.faq-question');

faqQuestions.forEach(question => {
    question.addEventListener('click', function() {
        const answer = this.nextElementSibling;
        const icon = this.querySelector('i');
        
        // Toggle current answer
        if (answer.style.maxHeight) {
            answer.style.maxHeight = null;
            icon.style.transform = 'rotate(0deg)';
        } else {
            answer.style.maxHeight = answer.scrollHeight + 'px';
            icon.style.transform = 'rotate(180deg)';
        }
        
        // Close other answers
        faqQuestions.forEach(q => {
            if (q !== this) {
                const otherAnswer = q.nextElementSibling;
                const otherIcon = q.querySelector('i');
                otherAnswer.style.maxHeight = null;
                otherIcon.style.transform = 'rotate(0deg)';
            }
        });
    });
});

// Share Location Function
function shareLocation() {
    if (navigator.share) {
        navigator.share({
            title: 'Lokasi Kantor DPD NasDem Bojonegoro',
            text: 'Jl. Raya Bojonegoro No. 123, Bojonegoro',
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        navigator.clipboard.writeText(window.location.href);
        alert('Link berhasil disalin ke clipboard!');
    }
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

// Form validation enhancement
const formInputs = document.querySelectorAll('.form-input');

formInputs.forEach(input => {
    // Add floating label effect
    input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
        if (!this.value) {
            this.parentElement.classList.remove('focused');
        }
    });
    
    // Initialize labels for pre-filled values
    if (input.value) {
        input.parentElement.classList.add('focused');
    }
});
</script>
@endpush

@push('styles')
<style>
/* Custom colors for this page */
.nasdem-navy-color { color: #001F3F; }
.nasdem-red-color { color: #06284f; }
.nasdem-navy-bg { background-color: #001F3F; }
.nasdem-red-bg { background-color: #06284f; }

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

/* Contact Items */
.contact-item {
    cursor: pointer;
    transition: all 0.3s ease;
}

.contact-item:hover {
    transform: translateY(-2px);
}

.icon-container {
    transition: all 0.3s ease;
}

/* Social Media Cards */
.social-media-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 80px;
    border-radius: 12px;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.social-media-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.social-media-card:hover::before {
    left: 100%;
}

.social-media-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.social-text {
    font-size: 11px;
    margin-top: 4px;
    opacity: 0.9;
}

.facebook { background: linear-gradient(135deg, #1877F2 0%, #0d5bb5 100%); }
.instagram { background: linear-gradient(135deg, #E4405F 0%, #833AB4 100%); }
.twitter { background: linear-gradient(135deg, #1DA1F2 0%, #0d8bdb 100%); }
.whatsapp { background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); }
.youtube { background: linear-gradient(135deg, #FF0000 0%, #CC0000 100%); }
.tiktok { background: linear-gradient(135deg, #000000 0%, #333333 100%); }

/* Emergency Contact Animation */
.emergency-contact {
    position: relative;
}

.pulse-dot {
    width: 12px;
    height: 12px;
    background-color: white;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
    }
}

/* Form Styles */
.form-container {
    position: relative;
}

.form-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #06284f, #001F3F);
    border-radius: 2px 2px 0 0;
}

/* Form Group and Labels */
.form-group {
    position: relative;
    margin-bottom: 1.5rem;
}

.form-input {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: white;
    outline: none;
}

.form-input:focus {
    border-color: #06284f;
    box-shadow: 0 0 0 3px rgba(227, 27, 35, 0.1);
}

.form-input::placeholder {
    color: #9ca3af;
}

.form-label.floating {
    position: absolute;
    top: 50%;
    left: 16px;
    transform: translateY(-50%);
    background: white;
    padding: 0 4px;
    color: #6b7280;
    font-size: 16px;
    pointer-events: none;
    transition: all 0.3s ease;
}

.form-input:focus + .form-label.floating,
.form-input:not(:placeholder-shown) + .form-label.floating {
    top: 0;
    font-size: 12px;
    color: #06284f;
    transform: translateY(-50%);
}

/* Subject Options */
.subject-option {
    cursor: pointer;
}

.subject-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 80px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 12px;
    transition: all 0.3s ease;
    background: white;
}

.subject-card:hover {
    border-color: #06284f;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.subject-card i {
    font-size: 24px;
}

/* Submit Button */
.submit-btn {
    background: linear-gradient(135deg, #06284f 0%, #d01820 100%);
    color: white;
    padding: 18px;
    border-radius: 12px;
    font-weight: bold;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(227, 27, 35, 0.3);
}

.loader {
    background: linear-gradient(135deg, #06284f 0%, #d01820 100%);
}

.loader div {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Error Messages */
.error-message {
    color: #06284f;
    font-size: 14px;
    margin-top: 4px;
    display: flex;
    align-items: center;
}

/* Hover Card Effect */
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

/* Map Styles */
.map-container {
    position: relative;
}

.map-layer {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.5s ease;
    pointer-events: none;
}

.map-layer.active {
    opacity: 1;
    pointer-events: all;
}

.map-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: repeat(4, 1fr);
    height: 100%;
}

.map-tile {
    background: #f0f0f0;
    border: 1px solid #ddd;
}

.street .map-tile:nth-child(odd) {
    background: #e8e8e8;
}

.satellite-view {
    position: relative;
    height: 100%;
    background: linear-gradient(135deg, #1a3a5f 0%, #0a2f5a 100%);
}

.satellite-image {
    position: absolute;
    inset: 20px;
    background: linear-gradient(45deg, #2d5a8a 25%, transparent 25%),
                linear-gradient(-45deg, #2d5a8a 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #2d5a8a 75%),
                linear-gradient(-45deg, transparent 75%, #2d5a8a 75%);
    background-size: 40px 40px;
    background-position: 0 0, 0 20px, 20px -20px, -20px 0px;
}

.map-control-btn {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: white;
    border: 2px solid #e5e7eb;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.map-control-btn:hover,
.map-control-btn.active {
    border-color: #06284f;
    color: #06284f;
    background: #fef2f2;
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
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
}

.icon-wrapper {
    width: 70px;
    height: 70px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.icon-wrapper i {
    font-size: 30px;
}

/* FAQ Styles */
.faq-item {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.faq-item:hover {
    border-color: #1e40af;
}

.faq-question {
    width: 100%;
    padding: 20px;
    text-align: left;
    background: white;
    border: none;
    font-size: 16px;
    font-weight: 600;
    color: #001F3F;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background 0.3s ease;
}

.faq-question:hover {
    background: #f9fafb;
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    background: #f9fafb;
}

.faq-answer p {
    padding: 20px;
    margin: 0;
    color: #4b5563;
    line-height: 1.6;
}

/* Responsive Design */
@media (max-width: 768px) {
    .social-media-card {
        height: 60px;
        font-size: 14px;
    }
    
    .subject-card {
        height: 70px;
        padding: 8px;
    }
    
    .stats-card {
        padding: 20px;
    }
    
    .icon-wrapper {
        width: 60px;
        height: 60px;
    }
    
    .icon-wrapper i {
        font-size: 24px;
    }
}

@media (max-width: 640px) {
    .grid-cols-2 {
        grid-template-columns: 1fr;
    }
    
    .subject-option {
        grid-column: span 1;
    }
}
</style>
@endpush