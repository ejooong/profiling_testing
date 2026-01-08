@extends('layouts.front')

@section('title', 'Cek Status Pendaftaran - NasDem Bojonegoro')

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // NIK Input Formatter
    const nikInput = document.getElementById('nik');
    const nikCount = document.getElementById('nik-count');

    if (nikInput && nikCount) {
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
    }

    // Form submission with AJAX
    const checkStatusForm = document.getElementById('checkStatusForm');
    const checkBtn = document.getElementById('checkBtn');

    if (checkStatusForm && checkBtn) {
        checkStatusForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const nikInput = document.getElementById('nik');
            if (!nikInput) return;

            // Validasi NIK
            if (nikInput.value.length !== 16) {
                Swal.fire({
                    icon: 'error',
                    title: 'NIK Tidak Valid',
                    text: 'NIK harus terdiri dari 16 digit angka',
                    confirmButtonColor: '#e31b23'
                });
                nikInput.focus();
                return;
            }

            // Show loading state
            const loader = checkBtn.querySelector('.loader');
            const btnText = checkBtn.querySelector('.relative.z-10');
            
            if (btnText) btnText.classList.add('opacity-0');
            if (loader) loader.classList.remove('hidden');
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
                    // Show result in modal
                    showStatusResultModal(data);
                } else {
                    throw new Error(data.message || 'Data tidak ditemukan');
                }

            } catch (error) {
                // Hide loader
                if (btnText) btnText.classList.remove('opacity-0');
                if (loader) loader.classList.add('hidden');
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

    // Function to show status result in modal
    function showStatusResultModal(data) {
        if (!data.kader) return;

        const kader = data.kader;
        const statusInfo = data.status_info;
        
        // Format status color
        const statusColors = {
            'pending': 'yellow',
            'active': 'green',
            'rejected': 'red',
            'inactive': 'gray'
        };
        
        const statusColor = statusColors[kader.status] || 'yellow';
        const verificationColor = kader.is_verified ? 'green' : 'yellow';
        const verificationText = kader.is_verified ? 'Terverifikasi' : 'Belum Terverifikasi';

        Swal.fire({
            title: 'Status Pendaftaran',
            html: `
                <div class="text-left">
                    <!-- Status Badges -->
                    <div class="mb-6 text-center">
                        <div class="inline-flex flex-wrap items-center justify-center gap-3 mb-4">
                            <span class="px-4 py-2 rounded-full bg-${statusColor}-100 text-${statusColor}-800 font-semibold">
                                <i class="fas fa-circle mr-2 text-xs"></i>${statusInfo.title}
                            </span>
                            <span class="px-4 py-2 rounded-full bg-${verificationColor}-100 text-${verificationColor}-800 font-semibold">
                                <i class="fas fa-${kader.is_verified ? 'check' : 'clock'}-circle mr-2"></i>${verificationText}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">${kader.name}</h3>
                        <p class="text-gray-600 text-sm">NIK: ${kader.nik}</p>
                    </div>
                    
                    <!-- Status Description -->
                    <div class="bg-${statusColor}-50 border border-${statusColor}-200 rounded-lg p-4 mb-4">
                        <p class="text-${statusColor}-800 font-medium">${statusInfo.description}</p>
                    </div>
                    
                    <!-- Personal Information -->
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-xs text-gray-500">Tanggal Daftar</div>
                            <div class="font-semibold">${data.formatted_data.join_date}</div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-xs text-gray-500">Email</div>
                            <div class="font-semibold truncate">${kader.email}</div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-xs text-gray-500">Telepon</div>
                            <div class="font-semibold">${kader.phone}</div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="text-xs text-gray-500">DPC</div>
                            <div class="font-semibold truncate">${kader.dpc ? kader.dpc.kecamatan_name : 'N/A'}</div>
                        </div>
                    </div>
                    
                    <!-- Next Steps -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                        <p class="text-sm font-semibold text-blue-800 mb-2">Proses Selanjutnya:</p>
                        <ol class="list-decimal pl-5 space-y-1 text-blue-700 text-sm">
                            ${statusInfo.steps.map(step => `<li>${step}</li>`).join('')}
                        </ol>
                    </div>
                    
                    ${data.verification_date ? `
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4">
                            <p class="text-sm text-green-800">
                                <i class="fas fa-calendar-check mr-2"></i>
                                Terverifikasi pada: ${data.verification_date}
                            </p>
                        </div>
                    ` : ''}
                </div>
            `,
            width: 500,
            showCancelButton: false,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#001F3F',
            showCloseButton: true,
            didClose: () => {
                // Reset button state
                const checkBtn = document.getElementById('checkBtn');
                if (!checkBtn) return;
                
                const loader = checkBtn.querySelector('.loader');
                const btnText = checkBtn.querySelector('.relative.z-10');
                if (btnText) btnText.classList.remove('opacity-0');
                if (loader) loader.classList.add('hidden');
                checkBtn.disabled = false;
            }
        });
    }

    // Animation on scroll
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
    
// Function untuk check status dari homepage
function checkFromHome() {
    const form = document.getElementById('homeCheckForm');
    const nikInput = document.getElementById('homeNik');
    
    if (!form || !nikInput) {
        console.error('Form or input not found');
        return;
    }
    
    // Validasi NIK
    if (nikInput.value.length !== 16) {
        Swal.fire({
            icon: 'error',
            title: 'NIK Tidak Valid',
            text: 'Masukkan 16 digit NIK yang valid',
            confirmButtonColor: '#e31b23'
        });
        nikInput.focus();
        return;
    }
    
    // Show loading state
    const submitBtn = form.querySelector('button[type="button"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
    }
    
    // Kirim request AJAX
    fetch(form.action, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                           document.querySelector('input[name="_token"]')?.value || ''
        },
        body: new FormData(form)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Reset button
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-search mr-3"></i>Cek Status';
        }
        
        if (data.success) {
            // Tampilkan hasil dalam modal
            showHomeStatusResultModal(data);
        } else {
            throw new Error(data.message || 'Data tidak ditemukan');
        }
    })
    .catch(error => {
        // Reset button
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-search mr-3"></i>Cek Status';
        }
        
        Swal.fire({
            icon: 'error',
            title: 'Pencarian Gagal',
            text: error.message || 'Terjadi kesalahan saat memproses permintaan',
            confirmButtonColor: '#e31b23'
        });
    });
}

// Function to show status result in modal (for homepage)
function showHomeStatusResultModal(data) {
    if (!data.kader) {
        Swal.fire({
            icon: 'error',
            title: 'Data Tidak Ditemukan',
            text: 'Data kader dengan NIK tersebut tidak ditemukan',
            confirmButtonColor: '#e31b23'
        });
        return;
    }

    const kader = data.kader;
    const statusInfo = data.status_info;
    
    // Format status color
    const statusColors = {
        'pending': 'yellow',
        'active': 'green',
        'rejected': 'red',
        'inactive': 'gray'
    };
    
    const statusColor = statusColors[kader.status] || 'yellow';
    const verificationColor = kader.is_verified ? 'green' : 'yellow';
    const verificationText = kader.is_verified ? 'Terverifikasi' : 'Belum Terverifikasi';

    Swal.fire({
        title: 'Status Pendaftaran',
        html: `
            <div class="text-left">
                <!-- Status Badges -->
                <div class="mb-6 text-center">
                    <div class="inline-flex flex-wrap items-center justify-center gap-3 mb-4">
                        <span class="px-4 py-2 rounded-full bg-${statusColor}-100 text-${statusColor}-800 font-semibold">
                            <i class="fas fa-circle mr-2 text-xs"></i>${statusInfo.title}
                        </span>
                        <span class="px-4 py-2 rounded-full bg-${verificationColor}-100 text-${verificationColor}-800 font-semibold">
                            <i class="fas fa-${kader.is_verified ? 'check' : 'clock'}-circle mr-2"></i>${verificationText}
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">${kader.name}</h3>
                    <p class="text-gray-600 text-sm">NIK: ${kader.nik}</p>
                </div>
                
                <!-- Status Description -->
                <div class="bg-${statusColor}-50 border border-${statusColor}-200 rounded-lg p-4 mb-4">
                    <p class="text-${statusColor}-800 font-medium">${statusInfo.description}</p>
                </div>
                
                <!-- Personal Information -->
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-500">Tanggal Daftar</div>
                        <div class="font-semibold">${data.formatted_data.join_date}</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-500">Email</div>
                        <div class="font-semibold truncate">${kader.email}</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-500">Telepon</div>
                        <div class="font-semibold">${kader.phone}</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-500">DPC</div>
                        <div class="font-semibold truncate">${kader.dpc ? kader.dpc.kecamatan_name : 'N/A'}</div>
                    </div>
                </div>
                
                <!-- Next Steps -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <p class="text-sm font-semibold text-blue-800 mb-2">Proses Selanjutnya:</p>
                    <ol class="list-decimal pl-5 space-y-1 text-blue-700 text-sm">
                        ${statusInfo.steps.map(step => `<li>${step}</li>`).join('')}
                    </ol>
                </div>
                
                ${data.verification_date ? `
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4">
                        <p class="text-sm text-green-800">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Terverifikasi pada: ${data.verification_date}
                        </p>
                    </div>
                ` : ''}
                
                <!-- Action Buttons -->
                <div class="flex justify-center gap-3 mt-6">
                    <a href="/kader/check" class="px-4 py-2 bg-[#001F3F] text-white rounded-lg text-sm hover:bg-[#0a2f5a] transition">
                        <i class="fas fa-external-link-alt mr-2"></i>Halaman Detail
                    </a>
                    <a href="/kader/register" class="px-4 py-2 bg-[#e31b23] text-white rounded-lg text-sm hover:bg-red-700 transition">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Kader Baru
                    </a>
                </div>
            </div>
        `,
        width: 500,
        showCancelButton: false,
        confirmButtonText: 'Tutup',
        confirmButtonColor: '#001F3F',
        showCloseButton: true
    });
}

// NIK validation di homepage
const homeNikInput = document.getElementById('homeNik');
if (homeNikInput) {
    homeNikInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 16);
    });
    
    // Enter key support
    homeNikInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            checkFromHome();
        }
    });
}

// Membership form validation (old version)
const membershipForm = document.querySelector('form[action*="membership.check"]');
if (membershipForm) {
    const nikInput = membershipForm.querySelector('input[name="nik"]');
    
    if (nikInput) {
        nikInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });
        
        membershipForm.addEventListener('submit', function(e) {
            if (nikInput.value.length !== 16) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'NIK Tidak Valid',
                    text: 'Masukkan 16 digit NIK yang valid',
                    confirmButtonColor: '#e31b23'
                });
                nikInput.focus();
            }
        });
    }
}
</script>
@endpush

@section('content')
<!-- Hero Section -->
<section class="nasdem-gradient py-12 md:py-16 full-width relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-1/3 h-1/3 bg-gradient-to-br from-white/10 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-1/3 h-1/3 bg-gradient-to-tr from-red-500/10 to-transparent rounded-full blur-3xl"></div>
    </div>

    <div class="px-4 sm:px-6 lg:px-8 mx-auto relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 fade-in-up">Cek Status Pendaftaran Kader</h1>
            <p class="text-lg md:text-xl text-gray-200 mb-8 fade-in-up animation-delay-100">Periksa status pendaftaran Anda dengan memasukkan NIK</p>
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
                        <h2 class="text-2xl md:text-3xl font-bold">Cek Status Pendaftaran</h2>
                        <p class="text-blue-200 mt-1">Masukkan 16 digit NIK yang digunakan saat pendaftaran</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('kader.check.status') }}" method="POST" id="checkStatusForm" class="p-8 md:p-10">
                @csrf
                
                <div class="space-y-6">
                    <!-- NIK Input -->
                    <div class="form-group">
                        <label for="nik" class="form-label">NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text"
                                name="nik"
                                id="nik"
                                required
                                maxlength="16"
                                pattern="[0-9]{16}"
                                title="Masukkan 16 digit NIK"
                                class="form-input"
                                placeholder="Contoh: 1234567890123456"
                                value="{{ old('nik') }}">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <div class="text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Gunakan NIK yang sama dengan saat pendaftaran
                            </div>
                            <div class="text-xs text-gray-400" id="nik-count">0/16</div>
                        </div>
                        @error('nik')
                        <p class="error-message"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Security Notice -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                        <div class="flex items-start">
                            <i class="fas fa-shield-alt text-yellow-500 text-lg mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-yellow-800 mb-1">Keamanan Data</h4>
                                <p class="text-yellow-700 text-sm">
                                    Data Anda dilindungi dan hanya digunakan untuk verifikasi status pendaftaran.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit"
                            id="checkBtn"
                            class="w-full py-4 bg-gradient-to-r from-[#001F3F] to-[#0a2f5a] text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
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

        <!-- Information Section -->
        <div class="bg-gradient-to-r from-[#001F3F] to-[#0a2f5a] rounded-2xl shadow-xl p-8 md:p-10 text-white fade-in-up">
            <h2 class="text-2xl md:text-3xl font-bold mb-6 text-center">Status Pendaftaran</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Pending Status -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-yellow-500/20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-yellow-300 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Menunggu Verifikasi</h3>
                    <p class="text-gray-300 text-sm">Data sedang diverifikasi oleh admin</p>
                </div>
                
                <!-- Active Status -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-green-500/20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-circle text-green-300 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Aktif</h3>
                    <p class="text-gray-300 text-sm">Kader aktif & terverifikasi</p>
                </div>
                
                <!-- Rejected Status -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-red-500/20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-times-circle text-red-300 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Ditolak</h3>
                    <p class="text-gray-300 text-sm">Pendaftaran tidak dapat diproses</p>
                </div>
                
                <!-- Inactive Status -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-gray-500/20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-slash text-gray-300 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Non-Aktif</h3>
                    <p class="text-gray-300 text-sm">Keanggotaan tidak aktif</p>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mt-8 pt-8 border-t border-blue-700/30 text-center">
                <p class="text-gray-300 mb-4">Butuh bantuan? Hubungi tim kader kami:</p>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="tel:+62353123456" class="inline-flex items-center px-5 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition duration-300">
                        <i class="fas fa-phone mr-3 text-green-300"></i>
                        <span>(0353) 123456</span>
                    </a>
                    <a href="mailto:kader@nasdem-bojonegoro.id" class="inline-flex items-center px-5 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition duration-300">
                        <i class="fas fa-envelope mr-3 text-yellow-300"></i>
                        <span>kader@nasdem-bojonegoro.id</span>
                    </a>
                    <a href="{{ route('kader.register') }}" class="inline-flex items-center px-5 py-2 bg-[#e31b23] rounded-lg hover:bg-red-700 transition duration-300">
                        <i class="fas fa-user-plus mr-3"></i>
                        <span>Daftar Kader Baru</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    /* Custom styles for check status page */
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

    @media (max-width: 640px) {
        .grid-cols-4 {
            grid-template-columns: 1fr 1fr;
        }
        
        .form-input {
            padding: 12px;
        }
    }
</style>
@endpush