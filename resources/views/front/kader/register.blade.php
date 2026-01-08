@extends('layouts.front')

@section('title', 'Pendaftaran Kader - NasDem Bojonegoro')

@section('content')
<!-- Hero Section with Gradient -->
<section class="nasdem-gradient py-16 md:py-20 full-width relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-1/3 h-1/3 bg-gradient-to-br from-white/10 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-1/3 h-1/3 bg-gradient-to-tr from-red-500/10 to-transparent rounded-full blur-3xl"></div>
    </div>

    <div class="px-4 sm:px-6 lg:px-8 mx-auto relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 fade-in-up">Bergabung Menjadi Kader</h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-8 fade-in-up animation-delay-100">Bersama Partai NasDem Kabupaten Bojonegoro untuk Kemajuan Daerah</p>

            <!-- Registration Stats -->
            <div class="inline-flex flex-wrap justify-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 fade-in-up animation-delay-200">
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">4.8K+</div>
                    <div class="text-sm text-gray-300">Kader Terdaftar</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">28</div>
                    <div class="text-sm text-gray-300">DPC Aktif</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">400+</div>
                    <div class="text-sm text-gray-300">DPRT Aktif</div>
                </div>
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
            <h3 class="text-xl font-bold text-green-800 mb-2">Pendaftaran Berhasil!</h3>
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
        @endif

        <!-- Registration Progress -->
        <div class="max-w-4xl mx-auto mb-10 fade-in-up">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-[#001F3F] mb-4 text-center">Proses Pendaftaran</h2>
                <div class="flex items-center justify-between mb-6">
                    @foreach(['Data Diri', 'Alamat', 'Profesi', 'Keanggotaan'] as $step)
                    <div class="text-center">
                        <div class="w-12 h-12 rounded-full bg-[#001F3F] text-white flex items-center justify-center mx-auto mb-2 font-bold fade-in-up animation-delay-{{ $loop->index * 100 }}">
                            {{ $loop->iteration }}
                        </div>
                        <div class="text-sm font-medium text-[#001F3F]">{{ $step }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="relative">
                    <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 transform -translate-y-1/2"></div>
                    <div class="absolute top-1/2 left-0 h-1 bg-[#e31b23] transform -translate-y-1/2 w-1/4 progress-bar-animation"></div>
                </div>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-4xl mx-auto fade-in-up">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-[#001F3F] to-[#0a2f5a] text-white p-8 md:p-10">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mr-4">
                        <i class="fas fa-user-plus text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold">Formulir Pendaftaran Kader</h2>
                        <p class="text-blue-200 mt-1">Isi data dengan lengkap dan benar</p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('kader.store') }}" method="POST" id="registrationForm" class="p-8 md:p-10">
                @csrf

                <!-- Personal Information Section -->
                <section class="mb-12 fade-in-up" data-step="1">
                    <div class="flex items-center mb-8">
                        <div class="w-2 h-10 bg-[#e31b23] rounded-full mr-4"></div>
                        <h3 class="text-xl md:text-2xl font-bold text-[#001F3F]">Informasi Pribadi</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NIK -->
                        <div class="form-group">
                            <label class="form-label">NIK <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="text"
                                    name="nik"
                                    id="nik"
                                    required
                                    maxlength="16"
                                    class="form-input"
                                    placeholder="16 digit NIK">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <span class="text-gray-400 text-sm" id="nik-count">0/16</span>
                                </div>
                            </div>
                            @error('nik')
                            <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text"
                                name="name"
                                id="name"
                                required
                                class="form-input">
                            @error('name')
                            <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-label">Email <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="email"
                                    name="email"
                                    id="email"
                                    required
                                    class="form-input">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                            </div>
                            @error('email')
                            <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="form-group">
                            <label class="form-label">No. Telepon <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="text"
                                    name="phone"
                                    id="phone"
                                    required
                                    class="form-input">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                            </div>
                            @error('phone')
                            <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="gender-option">
                                    <input type="radio" name="gender" value="L" class="hidden peer" required>
                                    <div class="gender-card peer-checked:border-[#e31b23] peer-checked:bg-red-50">
                                        <i class="fas fa-male text-blue-500 text-2xl mb-2"></i>
                                        <span>Laki-laki</span>
                                    </div>
                                </label>
                                <label class="gender-option">
                                    <input type="radio" name="gender" value="P" class="hidden peer">
                                    <div class="gender-card peer-checked:border-[#e31b23] peer-checked:bg-red-50">
                                        <i class="fas fa-female text-pink-500 text-2xl mb-2"></i>
                                        <span>Perempuan</span>
                                    </div>
                                </label>
                            </div>
                            @error('gender')
                            <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Birth Place & Date -->
                        <div class="form-group md:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">Tempat Lahir <span class="text-red-500">*</span></label>
                                    <input type="text"
                                        name="birth_place"
                                        id="birth_place"
                                        required
                                        class="form-input">
                                    @error('birth_place')
                                    <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="form-label">Tanggal Lahir <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="date"
                                            name="birth_date"
                                            id="birth_date"
                                            required
                                            class="form-input">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <i class="fas fa-calendar text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('birth_date')
                                    <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Address Information Section -->
                <section class="mb-12 fade-in-up" data-step="2">
                    <div class="flex items-center mb-8">
                        <div class="w-2 h-10 bg-[#e31b23] rounded-full mr-4"></div>
                        <h3 class="text-xl md:text-2xl font-bold text-[#001F3F]">Informasi Alamat</h3>
                    </div>

                    <div class="space-y-6">
                        <!-- Full Address -->
                        <div class="form-group">
                            <label class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <textarea name="address"
                                    id="address"
                                    rows="3"
                                    required
                                    class="form-input resize-none"></textarea>
                                <div class="absolute bottom-3 right-3">
                                    <i class="fas fa-home text-gray-400"></i>
                                </div>
                            </div>
                            @error('address')
                            <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <!-- RT -->
                            <div class="form-group">
                                <label class="form-label">RT <span class="text-red-500">*</span></label>
                                <input type="text"
                                    name="rt"
                                    id="rt"
                                    required
                                    class="form-input">
                                @error('rt')
                                <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- RW -->
                            <div class="form-group">
                                <label class="form-label">RW <span class="text-red-500">*</span></label>
                                <input type="text"
                                    name="rw"
                                    id="rw"
                                    required
                                    class="form-input">
                                @error('rw')
                                <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kelurahan -->
                            <div class="form-group md:col-span-2">
                                <label class="form-label">Kelurahan/Desa <span class="text-red-500">*</span></label>
                                <input type="text"
                                    name="kelurahan"
                                    id="kelurahan"
                                    required
                                    class="form-input">
                                @error('kelurahan')
                                <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kecamatan -->
                            <div class="form-group md:col-span-2">
                                <label class="form-label">Kecamatan <span class="text-red-500">*</span></label>
                                <input type="text"
                                    name="kecamatan"
                                    id="kecamatan"
                                    required
                                    class="form-input">
                                @error('kecamatan')
                                <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Professional Information Section -->
                <section class="mb-12 fade-in-up" data-step="3">
                    <div class="flex items-center mb-8">
                        <div class="w-2 h-10 bg-[#e31b23] rounded-full mr-4"></div>
                        <h3 class="text-xl md:text-2xl font-bold text-[#001F3F]">Informasi Profesional</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Profession -->
                        <div class="form-group">
                            <label class="form-label">Pekerjaan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="text"
                                    name="profession"
                                    id="profession"
                                    required
                                    class="form-input">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-briefcase text-gray-400"></i>
                                </div>
                            </div>
                            @error('profession')
                            <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Education -->
                        <div class="form-group">
                            <label class="form-label">Pendidikan Terakhir <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="education"
                                    id="education"
                                    required
                                    class="form-input appearance-none">
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA/SMK</option>
                                    <option value="D1/D2/D3">D1/D2/D3</option>
                                    <option value="S1">S1/D4</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-graduation-cap text-gray-400"></i>
                                </div>
                            </div>
                            @error('education')
                            <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                <!-- Party Information Section -->
                <section class="mb-12 fade-in-up" data-step="4">
                    <div class="flex items-center mb-8">
                        <div class="w-2 h-10 bg-[#e31b23] rounded-full mr-4"></div>
                        <h3 class="text-xl md:text-2xl font-bold text-[#001F3F]">Informasi Keanggotaan</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- DPC -->
                        <div class="form-group">
                            <label class="form-label">DPC Kecamatan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="dpc_id"
                                    id="dpc_id"
                                    required
                                    class="form-input appearance-none">
                                    <option value="">Pilih DPC Kecamatan</option>
                                    @foreach($dpcs as $dpc)
                                    <option value="{{ $dpc->id }}">{{ $dpc->kecamatan_name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-building text-gray-400"></i>
                                </div>
                            </div>
                            @error('dpc_id')
                            <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- DPRT -->
                        <div class="form-group">
                            <label class="form-label">DPRT Desa/Kelurahan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="dprt_id"
                                    id="dprt_id"
                                    required
                                    class="form-input appearance-none">
                                    <option value="">Pilih DPC terlebih dahulu</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-house-user text-gray-400"></i>
                                </div>
                            </div>
                            @error('dprt_id')
                            <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Join Date -->
                        <div class="form-group">
                            <label class="form-label">Tanggal Bergabung <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="date"
                                    name="join_date"
                                    id="join_date"
                                    required
                                    class="form-input">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                            </div>
                            @error('join_date')
                            <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                <!-- Terms & Conditions -->
                <div class="mb-10 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-100 fade-in-up">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox"
                                name="terms"
                                id="terms"
                                required
                                class="terms-checkbox">
                        </div>
                        <label for="terms" class="ml-4 text-gray-700">
                            <span class="text-lg font-semibold text-[#001F3F] mb-2 block">Persetujuan Keanggotaan</span>
                            <p class="text-gray-600">
                                Dengan mencentang kotak ini, saya menyatakan bahwa:
                            </p>
                            <ul class="list-disc pl-5 mt-3 space-y-2 text-gray-600">
                                <li>Data yang saya berikan adalah benar dan dapat dipertanggungjawabkan</li>
                                <li>Siap menjadi kader Partai NasDem Kabupaten Bojonegoro</li>
                                <li>Bersedia mengikuti kegiatan dan program partai</li>
                                <li>Data akan digunakan untuk keperluan administrasi keanggotaan</li>
                            </ul>
                        </label>
                    </div>
                    @error('terms')
                    <p class="error-message mt-3"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-8 border-t border-gray-200 fade-in-up">
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-shield-alt text-green-500 mr-2"></i>
                        Data Anda aman dan terlindungi
                    </div>

                    <div class="flex gap-4">
                        <button type="button"
                            onclick="resetForm()"
                            class="px-8 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition duration-300 shadow-md hover:shadow-lg">
                            <i class="fas fa-redo mr-2"></i>Reset Form
                        </button>

                        <button type="submit"
                            id="submitBtn"
                            class="submit-btn px-10 py-3 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl relative overflow-hidden">
                            <span class="relative z-10">
                                <i class="fas fa-user-plus mr-3"></i>Daftar sebagai Kader
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-red-700 to-red-800 opacity-0 hover:opacity-100 transition duration-300"></div>
                            <div class="loader hidden absolute inset-0 flex items-center justify-center bg-[#e31b23]">
                                <div class="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Benefits Section -->
        <div class="mt-12 md:mt-16 fade-in-up">
            <div class="bg-gradient-to-r from-[#001F3F] to-[#0a2f5a] rounded-2xl shadow-xl p-8 md:p-10 text-white">
                <div class="flex items-center mb-8">
                    <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center mr-4">
                        <i class="fas fa-star text-2xl text-yellow-300"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold">Manfaat Menjadi Kader NasDem</h2>
                        <p class="text-blue-200 mt-1">Bergabung bersama kami untuk kemajuan bersama</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-[#001F3F]/90 backdrop-blur-sm rounded-xl p-6 hover:bg-[#001F3F] transition duration-300 border border-blue-700/30 hover:border-blue-500/50 shadow-lg hover:shadow-xl hover:-translate-y-1 fade-in-up animation-delay-100">
                        <div class="w-14 h-14 rounded-full bg-[#0a2f5a] flex items-center justify-center mb-4">
                            <i class="fas fa-graduation-cap text-2xl text-yellow-300"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-white">Pelatihan & Pengembangan</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Akses ke program pelatihan dan pengembangan kapasitas kader
                        </p>
                    </div>

                    <div class="bg-[#001F3F]/90 backdrop-blur-sm rounded-xl p-6 hover:bg-[#001F3F] transition duration-300 border border-blue-700/30 hover:border-blue-500/50 shadow-lg hover:shadow-xl hover:-translate-y-1 fade-in-up animation-delay-200">
                        <div class="w-14 h-14 rounded-full bg-[#0a2f5a] flex items-center justify-center mb-4">
                            <i class="fas fa-handshake text-2xl text-yellow-300"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-white">Jaringan Nasional</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Bergabung dengan jaringan nasional kader NasDem seluruh Indonesia
                        </p>
                    </div>

                    <div class="bg-[#001F3F]/90 backdrop-blur-sm rounded-xl p-6 hover:bg-[#001F3F] transition duration-300 border border-blue-700/30 hover:border-blue-500/50 shadow-lg hover:shadow-xl hover:-translate-y-1 fade-in-up animation-delay-300">
                        <div class="w-14 h-14 rounded-full bg-[#0a2f5a] flex items-center justify-center mb-4">
                            <i class="fas fa-chart-line text-2xl text-yellow-300"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-white">Kesempatan Karir</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Peluang pengembangan karir politik dan kepemimpinan
                        </p>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="mt-10 pt-8 border-t border-blue-700/30 text-center">
                    <p class="text-gray-300 text-sm md:text-base">
                        Butuh bantuan? Hubungi kami di
                        <a href="tel:+62353123456" class="text-yellow-300 font-semibold hover:text-yellow-200 hover:underline transition">(0353) 123456</a>
                        atau
                        <a href="mailto:kader@nasdem-bojonegoro.id" class="text-yellow-300 font-semibold hover:text-yellow-200 hover:underline transition">kader@nasdem-bojonegoro.id</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // NIK Input Formatter
    const nikInput = document.getElementById('nik');
    const nikCount = document.getElementById('nik-count');

    nikInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 16);
        nikCount.textContent = `${this.value.length}/16`;

        if (this.value.length === 16) {
            nikCount.classList.remove('text-gray-400');
            nikCount.classList.add('text-green-500');
        } else {
            nikCount.classList.remove('text-green-500');
            nikCount.classList.add('text-gray-400');
        }
    });

    // Set max date for birth date (minimum 17 years old)
    const birthDateInput = document.getElementById('birth_date');
    const today = new Date();
    const minDate = new Date(today.getFullYear() - 17, today.getMonth(), today.getDate());
    birthDateInput.max = minDate.toISOString().split('T')[0];
    birthDateInput.min = '1950-01-01';

    // Set max date for join date (today)
    const joinDateInput = document.getElementById('join_date');
    joinDateInput.max = today.toISOString().split('T')[0];
    joinDateInput.min = '2012-01-01'; // NasDem founded year

    // Dynamic DPRT based on DPC selection
    const dpcSelect = document.getElementById('dpc_id');
    const dprtSelect = document.getElementById('dprt_id');

    dpcSelect.addEventListener('change', function() {
        const dpcId = this.value;

        // Add loading state
        dprtSelect.innerHTML = '<option value="">Loading...</option>';
        dprtSelect.disabled = true;

        if (dpcId) {
            // Simulate API call with sample data (in production, use real API)
            setTimeout(() => {
                const sampleDPRTs = [{
                        id: 1,
                        desa_name: 'Desa A - ' + dpcSelect.options[dpcSelect.selectedIndex].text
                    },
                    {
                        id: 2,
                        desa_name: 'Desa B - ' + dpcSelect.options[dpcSelect.selectedIndex].text
                    },
                    {
                        id: 3,
                        desa_name: 'Desa C - ' + dpcSelect.options[dpcSelect.selectedIndex].text
                    },
                    {
                        id: 4,
                        desa_name: 'Desa D - ' + dpcSelect.options[dpcSelect.selectedIndex].text
                    },
                ];

                dprtSelect.innerHTML = '<option value="">Pilih DPRT Desa/Kelurahan</option>';

                sampleDPRTs.forEach(dprt => {
                    const option = document.createElement('option');
                    option.value = dprt.id;
                    option.textContent = dprt.desa_name;
                    dprtSelect.appendChild(option);
                });

                dprtSelect.disabled = false;

                // Show success notification
                Swal.fire({
                    icon: 'success',
                    title: 'DPRT Loaded',
                    text: 'Silakan pilih DPRT dari kecamatan yang dipilih',
                    timer: 1500,
                    showConfirmButton: false
                });
            }, 800);
        } else {
            dprtSelect.innerHTML = '<option value="">Pilih DPC terlebih dahulu</option>';
            dprtSelect.disabled = true;
        }
    });

    // Form Validation and Submission - SIMPLE WORKING VERSION
    const registrationForm = document.getElementById('registrationForm');
    const submitBtn = document.getElementById('submitBtn');

    registrationForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validate terms
        const termsCheckbox = document.getElementById('terms');
        if (!termsCheckbox.checked) {
            Swal.fire({
                icon: 'error',
                title: 'Persetujuan Diperlukan',
                text: 'Anda harus menyetujui syarat dan ketentuan untuk melanjutkan',
                confirmButtonColor: '#e31b23'
            });
            return;
        }

        // Show confirmation modal
        const result = await Swal.fire({
            title: 'Konfirmasi Pendaftaran',
            html: `
        <div class="text-left">
            <p>Apakah data yang Anda isi sudah benar?</p>
            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                <p class="font-semibold">Data yang akan dikirim:</p>
                <ul class="mt-2 space-y-1 text-sm">
                    <li>Nama: ${document.getElementById('name').value}</li>
                    <li>Email: ${document.getElementById('email').value}</li>
                    <li>DPC: ${dpcSelect.options[dpcSelect.selectedIndex].text}</li>
                </ul>
            </div>
        </div>
    `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1e3a8a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Kirim Pendaftaran',
            cancelButtonText: 'Periksa Kembali'
        });

        if (result.isConfirmed) {
            // Show loading state
            const loader = submitBtn.querySelector('.loader');
            const btnText = submitBtn.querySelector('.relative.z-10');

            btnText.classList.add('opacity-0');
            loader.classList.remove('hidden');

            try {
                // Kirim request AJAX
                const response = await fetch(registrationForm.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                            document.querySelector('input[name="_token"]')?.value || ''
                    },
                    body: new FormData(registrationForm)
                });

                // Get response data
                const data = await response.json();

                if (response.ok && data.success) {
                    // Success - Show SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Pendaftaran Berhasil!',
                        html: `
                        <div class="text-center">
                            <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-user-clock text-green-600 text-3xl"></i>
                            </div>
                            <p class="text-gray-700 mb-4">${data.message}</p>
                            <div class="bg-blue-50 p-4 rounded-lg text-sm text-left">
                                <p class="font-semibold text-blue-800">Proses Selanjutnya:</p>
                                <ol class="list-decimal pl-5 mt-2 space-y-1 text-blue-700">
                                    <li>Tim kami akan menghubungi Anda untuk jadwal interview</li>
                                    <li>Persiapkan dokumen pendukung (KTP asli, Foto 3x4)</li>
                                    <li>Hadiri sesi wawancara sesuai jadwal yang diberikan</li>
                                    <li>Status akan diaktifkan setelah interview dan verifikasi admin</li>
                                </ol>
                            </div>
                        </div>
                    `,
                        confirmButtonColor: '#1e3a8a',
                        confirmButtonText: 'Mengerti'
                    }).then(() => {
                        // Reset form setelah sukses
                        registrationForm.reset();
                        dprtSelect.innerHTML = '<option value="">Pilih DPC terlebih dahulu</option>';
                        dprtSelect.disabled = true;

                        // Show confetti animation
                        showConfetti();

                        // Reload page to show flash message
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    });
                } else {
                    // Error dari server
                    throw new Error(data.message || 'Terjadi kesalahan pada server');
                }

            } catch (error) {
                // Hide loader
                btnText.classList.remove('opacity-0');
                loader.classList.add('hidden');

                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Pendaftaran Gagal',
                    text: error.message,
                    confirmButtonColor: '#e31b23'
                });
            }
        }
    });

    // Reset Form Function
    function resetForm() {
        Swal.fire({
            title: 'Reset Formulir?',
            text: 'Semua data yang telah diisi akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e31b23',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Reset',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                registrationForm.reset();
                dprtSelect.innerHTML = '<option value="">Pilih DPC terlebih dahulu</option>';
                dprtSelect.disabled = true;

                Swal.fire({
                    icon: 'success',
                    title: 'Formulir Direset',
                    text: 'Semua data telah dihapus',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }

    // Confetti Animation
    function showConfetti() {
        const confettiCount = 150;
        const confettiColors = ['#e31b23', '#001F3F', '#ffffff', '#ffd700'];

        for (let i = 0; i < confettiCount; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti-piece';
            confetti.style.cssText = `
            position: fixed;
            width: ${Math.random() * 10 + 5}px;
            height: ${Math.random() * 10 + 5}px;
            background: ${confettiColors[Math.floor(Math.random() * confettiColors.length)]};
            top: -20px;
            left: ${Math.random() * 100}vw;
            border-radius: ${Math.random() > 0.5 ? '50%' : '0'};
            z-index: 9999;
            animation: confetti-fall ${Math.random() * 3 + 2}s linear forwards;
        `;

            document.body.appendChild(confetti);

            // Remove confetti after animation
            setTimeout(() => {
                confetti.remove();
            }, 5000);
        }
    }

    // Animation on scroll
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

        fadeElements.forEach(element => observer.observe(element));
    });
</script>
@endpush

@push('styles')
<style>
    /* Custom colors for this page */
    .nasdem-navy-color {
        color: #001F3F;
    }

    .nasdem-red-color {
        color: #e31b23;
    }

    .nasdem-navy-bg {
        background-color: #001F3F;
    }

    .nasdem-red-bg {
        background-color: #e31b23;
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

    @keyframes progress-bar {
        from {
            width: 0%;
        }

        to {
            width: 25%;
        }
    }

    @keyframes confetti-fall {
        to {
            transform: translateY(100vh) rotate(360deg);
            opacity: 0;
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

    .bounce-in {
        animation: bounce-in 0.6s ease-out forwards;
    }

    .progress-bar-animation {
        animation: progress-bar 1s ease-out forwards;
    }

    /* Form Styles */
    .form-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 8px;
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
        border-color: #e31b23;
        box-shadow: 0 0 0 3px rgba(227, 27, 35, 0.1);
    }

    .form-input::placeholder {
        color: #9ca3af;
    }

    /* Gender Options */
    .gender-option {
        cursor: pointer;
    }

    .gender-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 120px;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s ease;
        background: white;
    }

    .gender-card:hover {
        border-color: #e31b23;
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .gender-card span {
        font-weight: 500;
        color: #374151;
        margin-top: 8px;
    }

    /* Terms Checkbox */
    .terms-checkbox {
        width: 24px;
        height: 24px;
        border: 2px solid #d1d5db;
        border-radius: 6px;
        appearance: none;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .terms-checkbox:checked {
        background-color: #e31b23;
        border-color: #e31b23;
    }

    .terms-checkbox:checked::after {
        content: '✓';
        position: absolute;
        color: white;
        font-size: 16px;
        font-weight: bold;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .terms-checkbox:hover {
        border-color: #e31b23;
    }

    /* Submit Button */
    .submit-btn {
        background: linear-gradient(135deg, #e31b23 0%, #d01820 100%);
        color: white;
        font-weight: bold;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(227, 27, 35, 0.3);
    }

    .loader {
        background: linear-gradient(135deg, #e31b23 0%, #d01820 100%);
    }

    .loader div {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Error Messages */
    .error-message {
        color: #e31b23;
        font-size: 14px;
        margin-top: 6px;
        display: flex;
        align-items: center;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .gender-card {
            height: 100px;
            padding: 16px;
        }

        .gender-card i {
            font-size: 24px;
        }

        .submit-btn {
            width: 100%;
        }
    }

    @media (max-width: 640px) {

        .grid-cols-2,
        .grid-cols-4 {
            grid-template-columns: 1fr;
        }

        .form-input {
            padding: 12px;
        }
    }

    /* Custom Select Arrow */
    select.form-input {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }

    select.form-input:focus {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23e31b23' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    }
</style>
@endpush