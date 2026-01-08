@extends('layouts.front')

@section('title', 'Cek Status Keanggotaan - NasDem Bojonegoro')

@section('content')
<!-- Hero Section -->
<section class="nasdem-gradient py-12 md:py-16 full-width relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-1/3 h-1/3 bg-gradient-to-br from-white/10 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-1/3 h-1/3 bg-gradient-to-tr from-red-500/10 to-transparent rounded-full blur-3xl"></div>
    </div>

    <div class="px-4 sm:px-6 lg:px-8 mx-auto relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 fade-in-up">Cek Status Keanggotaan Kader</h1>
            <p class="text-lg md:text-xl text-gray-200 mb-8 fade-in-up animation-delay-100">Periksa status verifikasi dan informasi keanggotaan Anda</p>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="full-width bg-gray-50 py-12 md:py-16">
    <div class="px-4 sm:px-6 lg:px-8 mx-auto max-w-4xl">
        
        <!-- Search Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 fade-in-up">
            <div class="bg-gradient-to-r from-[#001F3F] to-[#0a2f5a] text-white p-8 md:p-10">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mr-4">
                        <i class="fas fa-search text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold">Cek Status Keanggotaan</h2>
                        <p class="text-blue-200 mt-1">Masukkan NIK atau Email yang digunakan saat pendaftaran</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('membership.check') }}" method="POST" id="checkStatusForm" class="p-8 md:p-10">
                @csrf
                
                <div class="space-y-6">
                    <!-- Identifier Type Selection -->
                    <div class="form-group">
                        <label class="form-label">Cari Berdasarkan <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="search-type-option">
                                <input type="radio" name="type" value="nik" class="hidden peer" required checked>
                                <div class="search-type-card peer-checked:border-[#e31b23] peer-checked:bg-red-50">
                                    <i class="fas fa-id-card text-blue-500 text-2xl mb-2"></i>
                                    <span>NIK</span>
                                </div>
                            </label>
                            <label class="search-type-option">
                                <input type="radio" name="type" value="email" class="hidden peer">
                                <div class="search-type-card peer-checked:border-[#e31b23] peer-checked:bg-red-50">
                                    <i class="fas fa-envelope text-pink-500 text-2xl mb-2"></i>
                                    <span>Email</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Identifier Input -->
                    <div class="form-group">
                        <label for="identifier" class="form-label" id="identifier-label">NIK <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text"
                                name="identifier"
                                id="identifier"
                                required
                                class="form-input"
                                placeholder="Masukkan 16 digit NIK">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-id-card text-gray-400" id="identifier-icon"></i>
                            </div>
                        </div>
                        @error('identifier')
                        <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit"
                            id="checkBtn"
                            class="w-full py-3 bg-gradient-to-r from-[#001F3F] to-[#0a2f5a] text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center">
                                <i class="fas fa-search mr-3"></i>Cek Status Sekarang
                            </span>
                            <div class="loader hidden absolute inset-0 flex items-center justify-center bg-[#001F3F]">
                                <div class="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Section -->
        @if(isset($result) && $searched)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden fade-in-up" id="resultSection">
            <div class="bg-gradient-to-r {{ $result->status == 'active' && $result->is_verified ? 'from-green-500 to-emerald-600' : ($result->status == 'pending' ? 'from-yellow-500 to-amber-600' : 'from-blue-500 to-indigo-600') }} text-white p-8 md:p-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mr-4">
                            @if($result->status == 'active' && $result->is_verified)
                                <i class="fas fa-user-check text-2xl"></i>
                            @elseif($result->status == 'pending')
                                <i class="fas fa-user-clock text-2xl"></i>
                            @else
                                <i class="fas fa-user text-2xl"></i>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-2xl md:text-3xl font-bold">Status Keanggotaan</h2>
                            <p class="text-opacity-90 mt-1">{{ $result->name }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-opacity-90">Terakhir diperbarui</div>
                        <div class="font-semibold">{{ $result->updated_at->format('d F Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="p-8 md:p-10">
                <!-- Status Badge -->
                <div class="mb-8 text-center">
                    @php
                        $statusColor = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'active' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            'inactive' => 'bg-gray-100 text-gray-800'
                        ][$result->status] ?? 'bg-gray-100 text-gray-800';
                        
                        $statusText = [
                            'pending' => 'Menunggu Verifikasi',
                            'active' => 'Aktif',
                            'rejected' => 'Ditolak',
                            'inactive' => 'Non-Aktif'
                        ][$result->status] ?? 'Tidak Diketahui';
                        
                        $verificationColor = $result->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
                        $verificationText = $result->is_verified ? 'Terverifikasi' : 'Belum Terverifikasi';
                    @endphp
                    
                    <div class="inline-flex flex-wrap items-center justify-center gap-4 mb-4">
                        <div class="px-6 py-3 rounded-full {{ $statusColor }} font-semibold text-lg shadow-md">
                            <i class="fas fa-circle mr-2 text-xs"></i>{{ $statusText }}
                        </div>
                        <div class="px-6 py-3 rounded-full {{ $verificationColor }} font-semibold text-lg shadow-md">
                            <i class="fas fa-{{ $result->is_verified ? 'check' : 'clock' }}-circle mr-2"></i>{{ $verificationText }}
                        </div>
                    </div>
                    
                    @if($result->status == 'pending')
                    <p class="text-gray-600 text-sm max-w-2xl mx-auto">
                        <i class="fas fa-info-circle mr-2"></i>
                        Status Anda sedang dalam proses verifikasi. Tim kami akan menghubungi untuk jadwal wawancara dalam 3-7 hari kerja.
                    </p>
                    @elseif($result->status == 'active' && $result->is_verified)
                    <p class="text-green-600 text-sm max-w-2xl mx-auto font-medium">
                        <i class="fas fa-check-circle mr-2"></i>
                        Selamat! Anda adalah kader aktif Partai NasDem Kabupaten Bojonegoro.
                    </p>
                    @endif
                </div>

                <!-- Personal Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Personal Data -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-[#001F3F] mb-4 flex items-center border-b pb-2">
                            <i class="fas fa-id-card mr-3 text-[#e31b23]"></i>Data Pribadi
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-user mr-2 text-sm"></i>Nama Lengkap
                                </span>
                                <span class="font-semibold text-[#001F3F] text-right">{{ $result->name }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-fingerprint mr-2 text-sm"></i>NIK
                                </span>
                                <span class="font-semibold text-[#001F3F]">{{ $result->nik }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-envelope mr-2 text-sm"></i>Email
                                </span>
                                <span class="font-semibold text-[#001F3F] text-right">{{ $result->email }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-phone mr-2 text-sm"></i>Telepon
                                </span>
                                <span class="font-semibold text-[#001F3F]">{{ $result->phone }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-venus-mars mr-2 text-sm"></i>Jenis Kelamin
                                </span>
                                <span class="font-semibold text-[#001F3F]">{{ $result->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Membership Data -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-[#001F3F] mb-4 flex items-center border-b pb-2">
                            <i class="fas fa-users mr-3 text-[#001F3F]"></i>Data Keanggotaan
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-calendar-alt mr-2 text-sm"></i>Tanggal Bergabung
                                </span>
                                <span class="font-semibold text-[#001F3F]">{{ \Carbon\Carbon::parse($result->join_date)->format('d F Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-building mr-2 text-sm"></i>DPC Kecamatan
                                </span>
                                <span class="font-semibold text-[#001F3F] text-right">{{ $result->dpc->kecamatan_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-home mr-2 text-sm"></i>DPRT Desa/Kelurahan
                                </span>
                                <span class="font-semibold text-[#001F3F] text-right">{{ $result->dprt->desa_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-calendar-plus mr-2 text-sm"></i>Tanggal Pendaftaran
                                </span>
                                <span class="font-semibold text-[#001F3F]">{{ $result->created_at->format('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Professional Data -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-[#001F3F] mb-4 flex items-center border-b pb-2">
                            <i class="fas fa-briefcase mr-3 text-green-600"></i>Data Profesional
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-briefcase mr-2 text-sm"></i>Pekerjaan
                                </span>
                                <span class="font-semibold text-[#001F3F] text-right">{{ $result->profession }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-graduation-cap mr-2 text-sm"></i>Pendidikan Terakhir
                                </span>
                                <span class="font-semibold text-[#001F3F]">{{ $result->education }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Birth Data -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-[#001F3F] mb-4 flex items-center border-b pb-2">
                            <i class="fas fa-birthday-cake mr-3 text-purple-600"></i>Data Kelahiran
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2 text-sm"></i>Tempat Lahir
                                </span>
                                <span class="font-semibold text-[#001F3F] text-right">{{ $result->birth_place }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-calendar-day mr-2 text-sm"></i>Tanggal Lahir
                                </span>
                                <span class="font-semibold text-[#001F3F]">{{ \Carbon\Carbon::parse($result->birth_date)->format('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm mb-8">
                    <h3 class="text-lg font-bold text-[#001F3F] mb-4 flex items-center border-b pb-2">
                        <i class="fas fa-map-marked-alt mr-3 text-amber-600"></i>Alamat Lengkap
                    </h3>
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700 leading-relaxed">{{ $result->address }}</p>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-sm text-blue-600 mb-1">RT</div>
                                <div class="text-2xl font-bold text-[#001F3F]">{{ $result->rt }}</div>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-sm text-blue-600 mb-1">RW</div>
                                <div class="text-2xl font-bold text-[#001F3F]">{{ $result->rw }}</div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-4 text-center">
                                <div class="text-sm text-green-600 mb-1">Desa/Kelurahan</div>
                                <div class="text-lg font-bold text-[#001F3F]">{{ $result->kelurahan }}</div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-4 text-center">
                                <div class="text-sm text-green-600 mb-1">Kecamatan</div>
                                <div class="text-lg font-bold text-[#001F3F]">{{ $result->kecamatan }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-200 mb-8">
                    <h3 class="text-xl font-bold text-[#001F3F] mb-6 text-center">Proses Selanjutnya</h3>
                    
                    @if($result->status == 'pending')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300">
                            <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                            </div>
                            <h4 class="font-bold text-lg text-gray-800 mb-2">Proses Verifikasi</h4>
                            <p class="text-gray-600 text-sm">Data Anda sedang diverifikasi oleh tim admin</p>
                        </div>
                        <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300">
                            <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-phone-alt text-blue-600 text-2xl"></i>
                            </div>
                            <h4 class="font-bold text-lg text-gray-800 mb-2">Wawancara</h4>
                            <p class="text-gray-600 text-sm">Tim kami akan menghubungi untuk jadwal wawancara</p>
                        </div>
                        <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300">
                            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-file-signature text-green-600 text-2xl"></i>
                            </div>
                            <h4 class="font-bold text-lg text-gray-800 mb-2">Dokumen</h4>
                            <p class="text-gray-600 text-sm">Siapkan KTP asli dan foto 3x4 untuk verifikasi</p>
                        </div>
                    </div>
                    @elseif($result->status == 'active' && $result->is_verified)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300">
                            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                            </div>
                            <h4 class="font-bold text-lg text-gray-800 mb-2">Kader Aktif</h4>
                            <p class="text-gray-600 text-sm">Selamat! Anda adalah kader aktif Partai NasDem</p>
                        </div>
                        <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300">
                            <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-id-card text-purple-600 text-2xl"></i>
                            </div>
                            <h4 class="font-bold text-lg text-gray-800 mb-2">Kartu Kader</h4>
                            <p class="text-gray-600 text-sm">Ambil kartu kader di sekretariat DPC terdekat</p>
                        </div>
                        <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300">
                            <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-calendar-alt text-indigo-600 text-2xl"></i>
                            </div>
                            <h4 class="font-bold text-lg text-gray-800 mb-2">Aktivitas</h4>
                            <p class="text-gray-600 text-sm">Ikuti kegiatan dan pelatihan yang dijadwalkan</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap justify-center gap-4 mt-8">
                    <button onclick="printStatus()" class="px-6 py-3 bg-[#001F3F] text-white rounded-xl font-medium hover:bg-[#0a2f5a] transition duration-300 shadow-md hover:shadow-lg">
                        <i class="fas fa-print mr-2"></i>Cetak Status
                    </button>
                    <a href="{{ route('kader.register') }}" class="px-6 py-3 bg-[#e31b23] text-white rounded-xl font-medium hover:bg-red-700 transition duration-300 shadow-md hover:shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Kader Baru
                    </a>
                    <button onclick="window.location.reload()" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition duration-300 shadow-md hover:shadow-lg">
                        <i class="fas fa-redo mr-2"></i>Cari Lagi
                    </button>
                </div>
            </div>
        </div>
        @elseif(isset($searched) && $searched === true && !isset($result))
        <!-- Not Found Message -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden fade-in-up">
            <div class="bg-gradient-to-r from-red-500 to-orange-600 text-white p-8 md:p-10">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mr-4">
                        <i class="fas fa-exclamation-triangle text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold">Data Tidak Ditemukan</h2>
                        <p class="text-red-200 mt-1">Silakan periksa kembali NIK atau Email yang dimasukkan</p>
                    </div>
                </div>
            </div>

            <div class="p-10 text-center">
                <div class="w-32 h-32 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-search-minus text-red-600 text-5xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Data Tidak Ditemukan</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Data kader dengan NIK/Email yang Anda masukkan tidak ditemukan dalam sistem kami.
                </p>
                
                <div class="flex flex-wrap justify-center gap-4">
                    <button onclick="window.location.reload()" class="px-6 py-3 bg-[#001F3F] text-white rounded-xl font-medium hover:bg-[#0a2f5a] transition duration-300">
                        <i class="fas fa-redo mr-2"></i>Coba Lagi
                    </button>
                    <a href="{{ route('kader.register') }}" class="px-6 py-3 bg-[#e31b23] text-white rounded-xl font-medium hover:bg-red-700 transition duration-300">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Kader Baru
                    </a>
                    <a href="tel:+62353123456" class="px-6 py-3 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition duration-300">
                        <i class="fas fa-phone mr-2"></i>Hubungi Admin
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- FAQ Section -->
        <div class="mt-12 fade-in-up">
            <div class="bg-gradient-to-r from-[#001F3F] to-[#0a2f5a] rounded-2xl shadow-xl p-8 md:p-10 text-white">
                <h2 class="text-2xl md:text-3xl font-bold mb-6 text-center">Pertanyaan yang Sering Diajukan</h2>
                
                <div class="space-y-4 max-w-3xl mx-auto">
                    @php
                        $faqs = [
                            [
                                'q' => 'Berapa lama proses verifikasi kader?',
                                'a' => 'Proses verifikasi membutuhkan waktu 3-7 hari kerja setelah pendaftaran. Tim kami akan menghubungi Anda untuk jadwal wawancara.'
                            ],
                            [
                                'q' => 'Dokumen apa saja yang perlu disiapkan?',
                                'a' => 'Siapkan KTP asli, foto 3x4 latar merah, dan surat pernyataan kesediaan menjadi kader yang dapat diunduh setelah pendaftaran.'
                            ],
                            [
                                'q' => 'Bagaimana jika status masih "Menunggu Verifikasi"?',
                                'a' => 'Jika status masih pending lebih dari 7 hari, silakan hubungi admin melalui kontak yang tersedia di bawah.'
                            ],
                            [
                                'q' => 'Bagaimana cara mendapatkan kartu kader?',
                                'a' => 'Kartu kader dapat diambil di sekretariat DPC terdekat setelah status menjadi "Aktif" dan "Terverifikasi".'
                            ]
                        ];
                    @endphp
                    
                    @foreach($faqs as $faq)
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 hover:bg-white/15 transition duration-300">
                        <h3 class="text-lg font-bold mb-2 flex items-center">
                            <i class="fas fa-question-circle text-yellow-300 mr-3"></i>
                            {{ $faq['q'] }}
                        </h3>
                        <p class="text-gray-300 pl-8">{{ $faq['a'] }}</p>
                    </div>
                    @endforeach
                </div>

                <!-- Contact Information -->
                <div class="mt-10 pt-8 border-t border-blue-700/30 text-center">
                    <p class="text-gray-300 text-sm md:text-base mb-4">
                        Butuh bantuan lebih lanjut? Hubungi tim admin kami:
                    </p>
                    <div class="flex flex-wrap justify-center gap-6">
                        <a href="tel:+62353123456" class="inline-flex items-center px-5 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition duration-300">
                            <i class="fas fa-phone mr-3 text-green-300"></i>
                            <span>(0353) 123456</span>
                        </a>
                        <a href="mailto:kader@nasdem-bojonegoro.id" class="inline-flex items-center px-5 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition duration-300">
                            <i class="fas fa-envelope mr-3 text-yellow-300"></i>
                            <span>kader@nasdem-bojonegoro.id</span>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center px-5 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition duration-300">
                            <i class="fab fa-whatsapp mr-3 text-green-400"></i>
                            <span>0812-3456-7890</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // Change input placeholder and label based on selection
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const identifierInput = document.getElementById('identifier');
    const identifierLabel = document.getElementById('identifier-label');
    const identifierIcon = document.getElementById('identifier-icon');

    function updateInputUI(type) {
        if (type === 'nik') {
            identifierInput.placeholder = 'Masukkan 16 digit NIK';
            identifierLabel.innerHTML = 'NIK <span class="text-red-500">*</span>';
            identifierIcon.className = 'fas fa-id-card text-gray-400';
            identifierInput.type = 'text';
        } else {
            identifierInput.placeholder = 'Masukkan alamat email';
            identifierLabel.innerHTML = 'Email <span class="text-red-500">*</span>';
            identifierIcon.className = 'fas fa-envelope text-gray-400';
            identifierInput.type = 'email';
        }
    }

    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            updateInputUI(this.value);
            identifierInput.value = ''; // Clear input when changing type
        });
    });

    // Initialize UI
    document.addEventListener('DOMContentLoaded', function() {
        const selectedType = document.querySelector('input[name="type"]:checked').value;
        updateInputUI(selectedType);
    });

    // NIK validation (16 digits only)
    identifierInput.addEventListener('input', function() {
        const type = document.querySelector('input[name="type"]:checked').value;
        
        if (type === 'nik') {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        }
    });

    // Form submission with AJAX
    const checkStatusForm = document.getElementById('checkStatusForm');
    const checkBtn = document.getElementById('checkBtn');

    if (checkStatusForm) {
        checkStatusForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Validate input based on type
            const type = document.querySelector('input[name="type"]:checked').value;
            const identifier = identifierInput.value.trim();
            
            if (type === 'nik' && identifier.length !== 16) {
                Swal.fire({
                    icon: 'error',
                    title: 'NIK Tidak Valid',
                    text: 'NIK harus terdiri dari 16 digit angka',
                    confirmButtonColor: '#e31b23'
                });
                return;
            }
            
            if (type === 'email' && !identifier.includes('@')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Email Tidak Valid',
                    text: 'Masukkan alamat email yang valid',
                    confirmButtonColor: '#e31b23'
                });
                return;
            }

            // Show loading state
            const loader = checkBtn.querySelector('.loader');
            const btnText = checkBtn.querySelector('.relative.z-10');
            
            btnText.classList.add('opacity-0');
            loader.classList.remove('hidden');
            checkBtn.disabled = true;

            try {
                const response = await fetch(checkStatusForm.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                       document.querySelector('input[name="_token"]')?.value || ''
                    },
                    body: new FormData(checkStatusForm)
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // For AJAX requests, show result in modal
                    if (data.data && (window.innerWidth < 768 || data.data.status === 'pending')) {
                        showStatusResultModal(data.data);
                    } else {
                        // For larger screens or active status, reload page
                        window.location.reload();
                    }
                } else {
                    throw new Error(data.message || 'Data tidak ditemukan');
                }

            } catch (error) {
                // Hide loader
                btnText.classList.remove('opacity-0');
                loader.classList.add('hidden');
                checkBtn.disabled = false;

                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Pencarian Gagal',
                    text: error.message,
                    confirmButtonColor: '#e31b23'
                });
            }
        });
    }

    // Function to show status result in modal (for AJAX requests)
    function showStatusResultModal(data) {
        // Format status badge
        const statusColors = {
            'pending': 'yellow',
            'active': 'green',
            'rejected': 'red',
            'inactive': 'gray'
        };
        
        const statusTexts = {
            'pending': 'Menunggu Verifikasi',
            'active': 'Aktif',
            'rejected': 'Ditolak',
            'inactive': 'Non-Aktif'
        };

        Swal.fire({
            title: 'Status Keanggotaan',
            html: `
                <div class="text-left">
                    <div class="mb-6 text-center">
                        <div class="inline-flex flex-wrap items-center justify-center gap-3 mb-4">
                            <span class="px-4 py-2 rounded-full bg-${statusColors[data.status]}-100 text-${statusColors[data.status]}-800 font-semibold">
                                ${statusTexts[data.status]}
                            </span>
                            <span class="px-4 py-2 rounded-full ${data.is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'} font-semibold">
                                ${data.is_verified ? 'Terverifikasi' : 'Belum Terverifikasi'}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">${data.name}</h3>
                    </div>
                    
                    <div class="space-y-4 mb-6">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="text-xs text-gray-500">NIK</div>
                                <div class="font-semibold">${data.nik}</div>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="text-xs text-gray-500">Email</div>
                                <div class="font-semibold truncate">${data.email}</div>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="text-xs text-gray-500">Telepon</div>
                                <div class="font-semibold">${data.phone}</div>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="text-xs text-gray-500">Bergabung</div>
                                <div class="font-semibold">${data.join_date}</div>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm font-semibold text-blue-800 mb-1">${data.dpc_name} - ${data.dprt_name}</p>
                            <p class="text-xs text-blue-700">DPC Kecamatan - DPRT Desa</p>
                        </div>
                    </div>
                    
                    ${data.status === 'pending' ? 
                        `<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                            <p class="text-sm text-yellow-800 font-semibold mb-1">Proses Verifikasi Berlangsung</p>
                            <p class="text-xs text-yellow-700">Tim kami akan menghubungi Anda dalam 3-7 hari kerja untuk jadwal wawancara.</p>
                        </div>` :
                      data.status === 'active' && data.is_verified ?
                        `<div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                            <p class="text-sm text-green-800 font-semibold mb-1">Kader Aktif</p>
                            <p class="text-xs text-green-700">Selamat! Anda adalah kader aktif Partai NasDem Bojonegoro.</p>
                        </div>` :
                      data.status === 'rejected' ?
                        `<div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                            <p class="text-sm text-red-800 font-semibold mb-1">Pendaftaran Ditolak</p>
                            <p class="text-xs text-red-700">Mohon hubungi admin untuk informasi lebih lanjut.</p>
                        </div>` :
                        ''
                    }
                </div>
            `,
            width: 500,
            showCancelButton: false,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#001F3F',
            showCloseButton: true,
            didClose: () => {
                // Reset button state after closing modal
                const loader = checkBtn.querySelector('.loader');
                const btnText = checkBtn.querySelector('.relative.z-10');
                btnText.classList.remove('opacity-0');
                loader.classList.add('hidden');
                checkBtn.disabled = false;
            }
        });
    }

    // Print status function
    function printStatus() {
        const printContent = document.getElementById('resultSection').innerHTML;
        const originalContent = document.body.innerHTML;
        
        document.body.innerHTML = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Status Keanggotaan - NasDem Bojonegoro</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .print-header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #001F3F; padding-bottom: 20px; }
                    .print-header h1 { color: #001F3F; margin: 0; }
                    .print-header p { color: #666; margin: 5px 0; }
                    .info-section { margin: 20px 0; }
                    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin: 20px 0; }
                    .info-item { padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
                    .label { font-weight: bold; color: #001F3F; }
                    .value { margin-top: 5px; }
                    .status-badge { display: inline-block; padding: 5px 15px; border-radius: 20px; font-weight: bold; }
                    .status-pending { background-color: #fef3c7; color: #92400e; }
                    .status-active { background-color: #d1fae5; color: #065f46; }
                    .footer { margin-top: 40px; text-align: center; color: #666; font-size: 12px; border-top: 1px solid #ddd; padding-top: 20px; }
                    @media print {
                        .no-print { display: none; }
                        body { margin: 0; padding: 20px; }
                    }
                </style>
            </head>
            <body>
                <div class="print-header">
                    <h1>STATUS KEANGGOTAAN KADER</h1>
                    <p>Partai NasDem Kabupaten Bojonegoro</p>
                    <p>${new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                </div>
                ${printContent}
                <div class="footer">
                    <p>Dicetak dari sistem informasi kader Partai NasDem Kabupaten Bojonegoro</p>
                    <p>© ${new Date().getFullYear()} - NasDem Bojonegoro</p>
                </div>
            </body>
            </html>
        `;
        
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload();
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
    /* Custom styles for check status page */
    .search-type-option {
        cursor: pointer;
    }

    .search-type-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 140px;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 24px;
        transition: all 0.3s ease;
        background: white;
    }

    .search-type-card:hover {
        border-color: #e31b23;
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .search-type-card span {
        font-weight: 600;
        color: #374151;
        margin-top: 12px;
        font-size: 16px;
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

    .error-message {
        color: #e31b23;
        font-size: 14px;
        margin-top: 6px;
        display: flex;
        align-items: center;
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

    /* Loader */
    .loader {
        background: linear-gradient(135deg, #001F3F 0%, #0a2f5a 100%);
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

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .search-type-card {
            height: 120px;
            padding: 20px;
        }
        
        .search-type-card i {
            font-size: 20px;
        }
        
        .search-type-card span {
            font-size: 14px;
        }
    }

    @media (max-width: 640px) {
        .grid-cols-2, .grid-cols-3, .grid-cols-4 {
            grid-template-columns: 1fr;
        }
        
        .search-type-card {
            height: 100px;
        }
        
        .form-input {
            padding: 12px;
        }
    }
</style>
@endpush