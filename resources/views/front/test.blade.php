<!-- Cek Keanggotaan -->
<div class="bg-gradient-to-br from-[#001F3F] to-blue-900 rounded-2xl p-6 shadow-xl">
    <div class="text-center mb-6">
        <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-id-card text-white text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Cek Status Pendaftaran</h3>
        <p class="text-gray-300 text-sm">Masukkan NIK untuk mengecek status pendaftaran kader</p>
    </div>
    
    <form action="{{ route('kader.check.status') }}" method="POST" class="space-y-4" id="homeCheckForm">
        @csrf
        <div class="relative">
            <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input type="text" 
                   name="nik" 
                   id="homeNik"
                   placeholder="16 digit NIK" 
                   maxlength="16"
                   pattern="[0-9]{16}"
                   title="Masukkan 16 digit NIK"
                   class="membership-input"
                   required>
        </div>
        <button type="button" onclick="checkFromHome()" class="membership-submit-btn">
            <i class="fas fa-search mr-3"></i>Cek Status
        </button>
    </form>
    
    <div class="text-center mt-4">
        <a href="{{ route('kader.check.form') }}" class="text-blue-300 text-sm hover:text-white transition">
            <i class="fas fa-external-link-alt mr-1"></i>Halaman cek status lengkap
        </a>
    </div>
</div>