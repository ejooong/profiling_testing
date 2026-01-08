<!-- DPRT Detail Modal -->
<div id="dprtDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto transition-all duration-300">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="dprtModalContent">
            <!-- Modal Header -->
            <div class="px-8 py-6 bg-gradient-to-r from-green-600 to-green-700 text-white">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-map-pin text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold" id="modalDesaName">Loading...</h2>
                            <div class="flex items-center space-x-3 mt-1">
                                <span class="text-sm bg-white/20 px-3 py-1 rounded-full" id="modalStatus"></span>
                                <span class="text-sm text-green-100" id="modalDpc"></span>
                            </div>
                        </div>
                    </div>
                    <button onclick="closeDprtDetail()" 
                            class="text-white hover:text-green-100 text-2xl transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-8 overflow-y-auto max-h-[calc(90vh-200px)]">
                <!-- Loading State -->
                <div id="dprtModalLoading" class="text-center py-12">
                    <div class="w-16 h-16 border-4 border-green-200 border-t-green-600 rounded-full animate-spin mx-auto"></div>
                    <p class="mt-4 text-gray-600">Memuat data DPRT...</p>
                </div>
                
                <!-- Content -->
                <div id="dprtModalContentArea" class="hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Basic Info -->
                            <div class="bg-green-50 rounded-xl p-6 border border-green-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-info-circle text-green-600 mr-3"></i>
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
                                    <div class="flex">
                                        <div class="w-1/3 text-sm text-gray-600">Terakhir Update</div>
                                        <div class="w-2/3 text-gray-800" id="modalUpdatedAt"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Leadership -->
                            <div class="bg-gradient-to-br from-green-50 to-white rounded-xl p-6 border border-green-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-crown text-green-600 mr-3"></i>
                                    Pimpinan DPRT
                                </h3>
                                <div class="space-y-4">
                                    <div class="flex items-center p-4 bg-white rounded-lg border border-green-200">
                                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                            <i class="fas fa-user-tie text-green-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm text-green-600">Ketua DPRT</div>
                                            <div class="font-bold text-lg" id="modalKetua"></div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="p-4 bg-white rounded-lg border border-green-200">
                                            <div class="text-sm text-green-600 mb-1">Total Pengurus</div>
                                            <div class="font-bold text-xl" id="modalTotalPengurus"></div>
                                        </div>
                                        <div class="p-4 bg-white rounded-lg border border-green-200">
                                            <div class="text-sm text-green-600 mb-1">Total Anggota</div>
                                            <div class="font-bold text-xl" id="modalTotalAnggota"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Statistics -->
                            <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-6 border border-blue-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-chart-bar text-blue-600 mr-3"></i>
                                    Statistik
                                </h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center p-4 bg-white rounded-lg border border-blue-200">
                                        <div class="text-3xl font-bold text-blue-600" id="modalTotalKader"></div>
                                        <div class="text-sm text-gray-600 mt-1">Total Kader</div>
                                    </div>
                                    <div class="text-center p-4 bg-white rounded-lg border border-blue-200">
                                        <div class="text-3xl font-bold text-blue-600" id="modalTotalStructures"></div>
                                        <div class="text-sm text-gray-600 mt-1">Total Pengurus</div>
                                    </div>
                                    <div class="text-center p-4 bg-white rounded-lg border border-blue-200">
                                        <div class="text-3xl font-bold text-blue-600" id="modalActiveStructures"></div>
                                        <div class="text-sm text-gray-600 mt-1">Pengurus Aktif</div>
                                    </div>
                                    <div class="text-center p-4 bg-white rounded-lg border border-blue-200">
                                        <div class="text-3xl font-bold text-blue-600" id="modalStructurePengurus"></div>
                                        <div class="text-sm text-gray-600 mt-1">Pengurus Inti</div>
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
                    <button onclick="closeDprtDetail()" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Tutup
                    </button>
                    <a href="#" id="modalFullLink"
                       class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors flex items-center">
                        <i class="fas fa-external-link-alt mr-2"></i>Halaman Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#dprtDetailModal {
    backdrop-filter: blur(4px);
}

#dprtModalContent {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

#dprtDetailModal:not(.hidden) #dprtModalContent {
    transform: scale(1);
    opacity: 1;
}
</style>

<script>
// Global variable to store current dprt data
let currentDprtData = null;

function showDprtDetail(dprtId) {
    const modal = document.getElementById('dprtDetailModal');
    const content = document.getElementById('dprtModalContent');
    const loading = document.getElementById('dprtModalLoading');
    const contentArea = document.getElementById('dprtModalContentArea');
    
    // Show modal with animation
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
    }, 50);
    
    // Show loading, hide content
    loading.classList.remove('hidden');
    contentArea.classList.add('hidden');
    
    // Fetch DPRT data
    fetch(`/admin/dprt/${dprtId}/data`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            currentDprtData = data;
            
            // Populate modal with data
            document.getElementById('modalDesaName').textContent = data.desa_name;
            document.getElementById('modalStatus').textContent = data.is_active ? 'Aktif' : 'Non-Aktif';
            document.getElementById('modalStatus').className = data.is_active 
                ? 'text-sm bg-green-500/20 text-green-800 px-3 py-1 rounded-full' 
                : 'text-sm bg-red-500/20 text-red-800 px-3 py-1 rounded-full';
            document.getElementById('modalDpc').textContent = data.dpc?.kecamatan_name || 'Tidak ada DPC';
            document.getElementById('modalAddress').textContent = data.address;
            document.getElementById('modalPhone').textContent = data.phone || '-';
            document.getElementById('modalEmail').textContent = data.email || '-';
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
            document.getElementById('modalUpdatedAt').textContent = 
                new Date(data.updated_at).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            document.getElementById('modalKetua').textContent = data.ketua || '-';
            document.getElementById('modalTotalKader').textContent = data.total_kader || 0;
            document.getElementById('modalTotalStructures').textContent = data.total_structures || 0;
            document.getElementById('modalActiveStructures').textContent = data.active_structures || 0;
            document.getElementById('modalStructurePengurus').textContent = data.structure_pengurus || 0;
            document.getElementById('modalTotalPengurus').textContent = data.structure_pengurus || 0;
            document.getElementById('modalTotalAnggota').textContent = (data.total_structures || 0) - (data.structure_pengurus || 0);
            document.getElementById('modalDescription').innerHTML = 
                data.description 
                    ? `<p>${data.description}</p>`
                    : '<p class="text-gray-500 italic">Tidak ada deskripsi</p>';
            document.getElementById('modalId').textContent = `DPRT-${data.id}`;
            
            // Set action links
            document.getElementById('modalEditLink').href = `/admin/dprt/${data.id}/edit`;
            document.getElementById('modalStructureLink').href = `/admin/dprt/${data.id}/structure`;
            document.getElementById('modalKaderLink').href = `/admin/kader?dprt_id=${data.id}`;
            document.getElementById('modalDeleteLink').href = `/admin/dprt/${data.id}`;
            document.getElementById('modalFullLink').href = `/admin/dprt/${data.id}`;
            
            // Add delete confirmation
            document.getElementById('modalDeleteLink').onclick = function(e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin menghapus DPRT ini?')) {
                    fetch(`/admin/dprt/${data.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            showNotification('success', 'DPRT berhasil dihapus');
                            closeDprtDetail();
                            // Reload page or remove row from table
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            throw new Error('Gagal menghapus DPRT');
                        }
                    })
                    .catch(error => {
                        showNotification('error', 'Gagal menghapus DPRT');
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
            console.error('Error fetching DPRT data:', error);
            loading.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-exclamation-triangle text-red-400 text-5xl mb-4"></i>
                    <p class="text-red-600 font-medium">Gagal memuat data DPRT</p>
                    <p class="text-gray-600 text-sm mt-1">${error.message}</p>
                    <button onclick="closeDprtDetail()" 
                            class="mt-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Tutup
                    </button>
                </div>
            `;
        });
}

function closeDprtDetail() {
    const modal = document.getElementById('dprtDetailModal');
    const content = document.getElementById('dprtModalContent');
    
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        currentDprtData = null;
    }, 300);
}

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('dprtDetailModal').classList.contains('hidden')) {
        closeDprtDetail();
    }
});

// Close modal when clicking outside
document.getElementById('dprtDetailModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDprtDetail();
    }
});
</script>