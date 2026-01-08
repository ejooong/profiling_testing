<!-- DPC Detail Modal -->
<div id="dpcDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto transition-all duration-300">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <!-- Modal Header -->
            <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-building text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold" id="modalDpcName">Loading...</h2>
                            <div class="flex items-center space-x-3 mt-1">
                                <span class="text-sm bg-white/20 px-3 py-1 rounded-full" id="modalStatus"></span>
                                <span class="text-sm text-blue-100" id="modalDpd"></span>
                            </div>
                        </div>
                    </div>
                    <button onclick="closeDpcDetail()" 
                            class="text-white hover:text-blue-100 text-2xl transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-8 overflow-y-auto max-h-[calc(90vh-200px)]">
                <!-- Loading State -->
                <div id="modalLoading" class="text-center py-12">
                    <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mx-auto"></div>
                    <p class="mt-4 text-gray-600">Memuat data DPC...</p>
                </div>
                
                <!-- Content -->
                <div id="modalContentArea" class="hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Basic Info -->
                            <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                                    Informasi Dasar
                                </h3>
                                <div class="space-y-4">
                                    <div class="flex">
                                        <div class="w-1/3 text-sm text-gray-600">Alamat</div>
                                        <div class="w-2/3 text-gray-800 font-medium" id="modalAddress"></div>
                                    </div>
                                    <div class="flex">
                                        <div class="w-1/3 text-sm text-gray-600">Telepon</div>
                                        <div class="w-2/3 text-gray-800 font-medium" id="modalPhone"></div>
                                    </div>
                                    <div class="flex">
                                        <div class="w-1/3 text-sm text-gray-600">Email</div>
                                        <div class="w-2/3 text-gray-800 font-medium" id="modalEmail"></div>
                                    </div>
                                    <div class="flex">
                                        <div class="w-1/3 text-sm text-gray-600">Koordinat</div>
                                        <div class="w-2/3 text-gray-800" id="modalCoordinates"></div>
                                    </div>
                                    <div class="flex">
                                        <div class="w-1/3 text-sm text-gray-600">Dibuat</div>
                                        <div class="w-2/3 text-gray-800" id="modalCreatedAt"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Leadership -->
                            <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-6 border border-blue-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-users text-blue-600 mr-3"></i>
                                    Pimpinan DPC
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="text-center p-4 bg-white rounded-lg border border-blue-200">
                                        <div class="text-sm text-blue-600 mb-2">Ketua</div>
                                        <div class="font-bold text-lg" id="modalKetua"></div>
                                    </div>
                                    <div class="text-center p-4 bg-white rounded-lg border border-blue-200">
                                        <div class="text-sm text-blue-600 mb-2">Sekretaris</div>
                                        <div class="font-bold text-lg" id="modalSekretaris"></div>
                                    </div>
                                    <div class="text-center p-4 bg-white rounded-lg border border-blue-200">
                                        <div class="text-sm text-blue-600 mb-2">Bendahara</div>
                                        <div class="font-bold text-lg" id="modalBendahara"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Statistics -->
                            <div class="bg-gradient-to-br from-emerald-50 to-white rounded-xl p-6 border border-emerald-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-chart-bar text-emerald-600 mr-3"></i>
                                    Statistik
                                </h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center p-4 bg-white rounded-lg border border-emerald-200">
                                        <div class="text-3xl font-bold text-emerald-600" id="modalTotalKader"></div>
                                        <div class="text-sm text-gray-600 mt-1">Total Kader</div>
                                    </div>
                                    <div class="text-center p-4 bg-white rounded-lg border border-emerald-200">
                                        <div class="text-3xl font-bold text-emerald-600" id="modalTotalDprt"></div>
                                        <div class="text-sm text-gray-600 mt-1">Total DPRT</div>
                                    </div>
                                    <div class="text-center p-4 bg-white rounded-lg border border-emerald-200">
                                        <div class="text-3xl font-bold text-emerald-600" id="modalActiveDprt"></div>
                                        <div class="text-sm text-gray-600 mt-1">DPRT Aktif</div>
                                    </div>
                                    <div class="text-center p-4 bg-white rounded-lg border border-emerald-200">
                                        <div class="text-3xl font-bold text-emerald-600" id="modalTotalKaderDprt"></div>
                                        <div class="text-sm text-gray-600 mt-1">Total Kader DPRT</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="bg-gradient-to-br from-purple-50 to-white rounded-xl p-6 border border-purple-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-bolt text-purple-600 mr-3"></i>
                                    Aksi Cepat
                                </h3>
                                <div class="grid grid-cols-2 gap-3">
                                    <a href="#" id="modalEditLink"
                                       class="p-3 bg-white border border-yellow-200 rounded-lg text-center hover:bg-yellow-50 transition-colors group">
                                        <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-2 group-hover:bg-yellow-200">
                                            <i class="fas fa-edit text-yellow-600"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">Edit</span>
                                    </a>
                                    <a href="#" id="modalStructureLink"
                                       class="p-3 bg-white border border-purple-200 rounded-lg text-center hover:bg-purple-50 transition-colors group">
                                        <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-2 group-hover:bg-purple-200">
                                            <i class="fas fa-sitemap text-purple-600"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">Struktur</span>
                                    </a>
                                    <a href="#" id="modalKaderLink"
                                       class="p-3 bg-white border border-blue-200 rounded-lg text-center hover:bg-blue-50 transition-colors group">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-2 group-hover:bg-blue-200">
                                            <i class="fas fa-users text-blue-600"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">Kader</span>
                                    </a>
                                    <a href="#" id="modalDeleteLink"
                                       class="p-3 bg-white border border-red-200 rounded-lg text-center hover:bg-red-50 transition-colors group">
                                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-2 group-hover:bg-red-200">
                                            <i class="fas fa-trash text-red-600"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">Hapus</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 border border-gray-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-file-alt text-gray-600 mr-3"></i>
                                    Deskripsi
                                </h3>
                                <div class="text-gray-700" id="modalDescription">
                                    <p class="text-gray-500 italic">Tidak ada deskripsi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-8 py-6 bg-gray-50 border-t flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    ID: <span class="font-medium" id="modalId"></span>
                </div>
                <div class="flex space-x-3">
                    <button onclick="closeDpcDetail()" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Tutup
                    </button>
                    <a href="#" id="modalFullLink"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors flex items-center">
                        <i class="fas fa-external-link-alt mr-2"></i>Halaman Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#dpcDetailModal {
    backdrop-filter: blur(4px);
}

#modalContent {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

#dpcDetailModal:not(.hidden) #modalContent {
    transform: scale(1);
    opacity: 1;
}
</style>

<script>
// Global variable to store current dpc data
let currentDpcData = null;

function showDpcDetail(dpcId) {
    const modal = document.getElementById('dpcDetailModal');
    const content = document.getElementById('modalContent');
    const loading = document.getElementById('modalLoading');
    const contentArea = document.getElementById('modalContentArea');
    
    // Show modal with animation
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
    }, 50);
    
    // Show loading, hide content
    loading.classList.remove('hidden');
    contentArea.classList.add('hidden');
    
    // Fetch DPC data
    fetch(`/admin/dpc/${dpcId}/data`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            currentDpcData = data;
            
            // Populate modal with data
            document.getElementById('modalDpcName').textContent = data.kecamatan_name;
            document.getElementById('modalStatus').textContent = data.is_active ? 'Aktif' : 'Non-Aktif';
            document.getElementById('modalStatus').className = data.is_active 
                ? 'text-sm bg-green-500/20 text-green-800 px-3 py-1 rounded-full' 
                : 'text-sm bg-red-500/20 text-red-800 px-3 py-1 rounded-full';
            document.getElementById('modalDpd').textContent = data.dpd?.name || 'Tidak ada DPD';
            document.getElementById('modalAddress').textContent = data.address;
            document.getElementById('modalPhone').textContent = data.phone;
            document.getElementById('modalEmail').textContent = data.email;
            document.getElementById('modalCoordinates').textContent = 
                data.latitude && data.longitude 
                    ? `${data.latitude}, ${data.longitude}`
                    : 'Belum ditentukan';
            document.getElementById('modalCreatedAt').textContent = 
                new Date(data.created_at).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            document.getElementById('modalKetua').textContent = data.ketua || '-';
            document.getElementById('modalSekretaris').textContent = data.sekretaris || '-';
            document.getElementById('modalBendahara').textContent = data.bendahara || '-';
            document.getElementById('modalTotalKader').textContent = data.total_kader;
            document.getElementById('modalTotalDprt').textContent = data.total_dprt;
            document.getElementById('modalActiveDprt').textContent = data.dprt_count || 0;
            document.getElementById('modalTotalKaderDprt').textContent = data.total_dprt_kader || 0;
            document.getElementById('modalDescription').innerHTML = 
                data.description 
                    ? `<p>${data.description}</p>`
                    : '<p class="text-gray-500 italic">Tidak ada deskripsi</p>';
            document.getElementById('modalId').textContent = `DPC-${data.id}`;
            
            // Set action links
            document.getElementById('modalEditLink').href = `/admin/dpc/${data.id}/edit`;
            document.getElementById('modalStructureLink').href = `/admin/dpc/${data.id}/structure`;
            document.getElementById('modalKaderLink').href = `/admin/kader?dpc_id=${data.id}`;
            document.getElementById('modalDeleteLink').href = `/admin/dpc/${data.id}`;
            document.getElementById('modalFullLink').href = `/admin/dpc/${data.id}`;
            
            // Add delete confirmation
            document.getElementById('modalDeleteLink').onclick = function(e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin menghapus DPC ini?')) {
                    fetch(`/admin/dpc/${data.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            showNotification('success', 'DPC berhasil dihapus');
                            closeDpcDetail();
                            // Reload page or remove row from table
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            throw new Error('Gagal menghapus DPC');
                        }
                    })
                    .catch(error => {
                        showNotification('error', 'Gagal menghapus DPC');
                    });
                }
            };
            
            // Hide loading, show content
            setTimeout(() => {
                loading.classList.add('hidden');
                contentArea.classList.remove('hidden');
            }, 300);
        })
        .catch(error => {
            console.error('Error fetching DPC data:', error);
            loading.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-exclamation-triangle text-red-400 text-5xl mb-4"></i>
                    <p class="text-red-600 font-medium">Gagal memuat data DPC</p>
                    <p class="text-gray-600 text-sm mt-1">${error.message}</p>
                    <button onclick="closeDpcDetail()" 
                            class="mt-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Tutup
                    </button>
                </div>
            `;
        });
}

function closeDpcDetail() {
    const modal = document.getElementById('dpcDetailModal');
    const content = document.getElementById('modalContent');
    
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        currentDpcData = null;
    }, 300);
}

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('dpcDetailModal').classList.contains('hidden')) {
        closeDpcDetail();
    }
});

// Close modal when clicking outside
document.getElementById('dpcDetailModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDpcDetail();
    }
});
</script>