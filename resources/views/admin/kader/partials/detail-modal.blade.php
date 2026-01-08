{{-- resources/views/admin/kader/partials/detail-modal.blade.php --}}
<!-- Kader Detail Modal -->
<div id="kaderDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto transition-all duration-300">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="kaderModalContent">
            <!-- Modal Header -->
            <div class="px-8 py-6 bg-gradient-to-r from-red-600 to-red-700 text-white">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold" id="modalKaderName">Loading...</h2>
                            <div class="flex items-center space-x-3 mt-1">
                                <span class="text-sm bg-white/20 px-3 py-1 rounded-full" id="modalStatus"></span>
                                <span class="text-sm text-red-100" id="modalDpc"></span>
                            </div>
                        </div>
                    </div>
                    <button onclick="closeKaderDetail()"
                        class="text-white hover:text-red-100 text-2xl transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-8 overflow-y-auto max-h-[calc(90vh-200px)]">
                <!-- Loading State -->
                <div id="kaderModalLoading" class="text-center py-12">
                    <div class="w-16 h-16 border-4 border-red-200 border-t-red-600 rounded-full animate-spin mx-auto"></div>
                    <p class="mt-4 text-gray-600">Memuat data kader...</p>
                </div>

                <!-- Content -->
                <div id="kaderModalContentArea" class="hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column - Photo & Basic Info -->
                        <div class="space-y-6">
                            <!-- Photo -->
                            <div class="bg-red-50 rounded-xl p-6 border border-red-100">
                                <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-white shadow-lg">
                                    <img id="modalPhoto" src="" alt="Foto Kader" class="w-full h-full object-cover">
                                </div>
                                <div class="text-center mt-4">
                                    <div class="text-lg font-bold text-gray-900" id="modalName"></div>
                                    <div class="text-sm text-gray-600" id="modalNik"></div>
                                </div>
                            </div>

                            <!-- Quick Info -->
                            <div class="bg-gradient-to-br from-red-50 to-white rounded-xl p-6 border border-red-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-id-card text-red-600 mr-3"></i>
                                    Informasi Singkat
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-venus-mars text-red-500 w-6"></i>
                                        <span class="ml-3 text-gray-700" id="modalGender"></span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-birthday-cake text-red-500 w-6"></i>
                                        <span class="ml-3 text-gray-700" id="modalBirthInfo"></span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-graduation-cap text-red-500 w-6"></i>
                                        <span class="ml-3 text-gray-700" id="modalEducation"></span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-briefcase text-red-500 w-6"></i>
                                        <span class="ml-3 text-gray-700" id="modalProfession"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Middle Column - Personal Info -->
                        <div class="space-y-6">
                            <!-- Contact Info -->
                            <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-address-book text-blue-600 mr-3"></i>
                                    Kontak & Alamat
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <div class="text-sm text-blue-600 mb-1">Alamat</div>
                                        <div class="font-medium text-gray-800" id="modalAddress"></div>
                                        <div class="text-sm text-gray-600 mt-1" id="modalRtRw"></div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-sm text-blue-600 mb-1">Telepon</div>
                                            <div class="font-medium text-gray-800" id="modalPhone"></div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-blue-600 mb-1">Email</div>
                                            <div class="font-medium text-gray-800" id="modalEmail"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Organization Info -->
                            <div class="bg-green-50 rounded-xl p-6 border border-green-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-sitemap text-green-600 mr-3"></i>
                                    Keanggotaan
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex items-center p-3 bg-white rounded-lg">
                                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-building text-green-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm text-green-600">DPC</div>
                                            <div class="font-medium" id="modalDpcFull"></div>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-3 bg-white rounded-lg">
                                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-map-pin text-green-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm text-green-600">DPRT</div>
                                            <div class="font-medium" id="modalDprt"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Additional Info -->
                        <div class="space-y-6">
                            <!-- Status & Timeline -->
                            <div class="bg-purple-50 rounded-xl p-6 border border-purple-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-history text-purple-600 mr-3"></i>
                                    Status & Timeline
                                </h3>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center p-3 bg-white rounded-lg">
                                            <div class="text-2xl font-bold text-purple-600" id="modalJoinYear"></div>
                                            <div class="text-xs text-gray-600">Tahun Bergabung</div>
                                        </div>
                                        <div class="text-center p-3 bg-white rounded-lg">
                                            <div class="text-2xl font-bold text-purple-600" id="modalAge"></div>
                                            <div class="text-xs text-gray-600">Usia</div>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Bergabung</span>
                                            <span class="font-medium" id="modalJoinDate"></span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Diverifikasi</span>
                                            <span class="font-medium" id="modalVerifiedDate"></span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Terakhir Update</span>
                                            <span class="font-medium" id="modalUpdatedDate"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Skills & Position -->
                            <div class="bg-yellow-50 rounded-xl p-6 border border-yellow-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-star text-yellow-600 mr-3"></i>
                                    Keahlian & Jabatan
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <div class="text-sm text-yellow-600 mb-1">Jabatan di Partai</div>
                                        <div class="font-medium text-gray-800" id="modalPosition"></div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-yellow-600 mb-1">Keahlian</div>
                                        <div class="flex flex-wrap gap-2" id="modalSkills"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-bolt text-gray-600 mr-3"></i>
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
                                    <a href="#" id="modalDeleteLink"
                                        class="p-3 bg-white border border-red-200 rounded-lg text-center hover:bg-red-50 transition-colors group">
                                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-2 group-hover:bg-red-200">
                                            <i class="fas fa-trash text-red-600"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">Hapus</span>
                                    </a>
                                    <a href="#" id="modalPrintLink"
                                        class="p-3 bg-white border border-blue-200 rounded-lg text-center hover:bg-blue-50 transition-colors group">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-2 group-hover:bg-blue-200">
                                            <i class="fas fa-print text-blue-600"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">Cetak</span>
                                    </a>
                                    <a href="#" id="modalVerifyLink"
                                        class="p-3 bg-white border border-green-200 rounded-lg text-center hover:bg-green-50 transition-colors group">
                                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-2 group-hover:bg-green-200">
                                            <i class="fas fa-check-circle text-green-600"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">Verifikasi</span>
                                    </a>
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
                    <button onclick="closeKaderDetail()"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Tutup
                    </button>
                    <a href="#" id="modalFullLink"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors flex items-center">
                        <i class="fas fa-external-link-alt mr-2"></i>Halaman Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #kaderDetailModal {
        backdrop-filter: blur(4px);
    }

    #kaderModalContent {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #kaderDetailModal:not(.hidden) #kaderModalContent {
        transform: scale(1);
        opacity: 1;
    }
</style>

<script>
    // Global variable to store current kader data
    let currentKaderData = null;

    function showKaderDetail(kaderId) {
        const modal = document.getElementById('kaderDetailModal');
        const content = document.getElementById('kaderModalContent');
        const loading = document.getElementById('kaderModalLoading');
        const contentArea = document.getElementById('kaderModalContentArea');

        // Show modal with animation
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
        }, 50);

        // Show loading, hide content
        loading.classList.remove('hidden');
        contentArea.classList.add('hidden');

        // Fetch kader data
        fetch(`/admin/kader/${kaderId}/data`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                currentKaderData = data;

                // Populate modal with data
                document.getElementById('modalKaderName').textContent = data.name;
                document.getElementById('modalStatus').textContent = data.is_verified ? 'Terverifikasi' : 'Belum Verifikasi';
                document.getElementById('modalStatus').className = data.is_verified ?
                    'text-sm bg-green-500/20 text-green-800 px-3 py-1 rounded-full' :
                    'text-sm bg-yellow-500/20 text-yellow-800 px-3 py-1 rounded-full';
                document.getElementById('modalDpc').textContent = data.dpc?.kecamatan_name || 'Tidak ada DPC';

                // Photo
                const photoElement = document.getElementById('modalPhoto');
                if (data.photo_path) {
                    photoElement.src = `/storage/${data.photo_path}`;
                } else {
                    photoElement.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.name) + '&background=dc2626&color=fff&size=256';
                }

                // Personal info
                document.getElementById('modalName').textContent = data.name;
                document.getElementById('modalNik').textContent = `NIK: ${data.nik}`;
                document.getElementById('modalGender').textContent = data.gender === 'L' ? 'Laki-laki' : 'Perempuan';

                // Calculate age
                const birthDate = new Date(data.birth_date);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                document.getElementById('modalBirthInfo').textContent =
                    `${data.birth_place}, ${birthDate.toLocaleDateString('id-ID')} (${age} tahun)`;
                document.getElementById('modalAge').textContent = age;
                document.getElementById('modalEducation').textContent = data.education || '-';
                document.getElementById('modalProfession').textContent = data.profession || '-';

                // Contact info
                document.getElementById('modalAddress').textContent = data.address || '-';
                document.getElementById('modalRtRw').textContent = `RT ${data.rt}/RW ${data.rw}, ${data.kelurahan}, ${data.kecamatan}`;
                document.getElementById('modalPhone').textContent = data.phone || '-';
                document.getElementById('modalEmail').textContent = data.email || '-';

                // Organization info
                document.getElementById('modalDpcFull').textContent = data.dpc?.kecamatan_name || '-';
                document.getElementById('modalDprt').textContent = data.dprt?.desa_name || '-';

                // Timeline
                const joinDate = new Date(data.join_date);
                document.getElementById('modalJoinYear').textContent = joinDate.getFullYear();
                document.getElementById('modalJoinDate').textContent = joinDate.toLocaleDateString('id-ID');

                if (data.verified_at) {
                    const verifiedDate = new Date(data.verified_at);
                    document.getElementById('modalVerifiedDate').textContent = verifiedDate.toLocaleDateString('id-ID');
                } else {
                    document.getElementById('modalVerifiedDate').textContent = '-';
                }

                const updatedDate = new Date(data.updated_at);
                document.getElementById('modalUpdatedDate').textContent = updatedDate.toLocaleDateString('id-ID');

                // Skills & Position
                document.getElementById('modalPosition').textContent = data.position_in_party || 'Anggota';

                const skillsElement = document.getElementById('modalSkills');
                if (data.skills && Array.isArray(data.skills) && data.skills.length > 0) {
                    skillsElement.innerHTML = '';
                    data.skills.forEach(skill => {
                        const skillSpan = document.createElement('span');
                        skillSpan.className = 'px-3 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full';
                        skillSpan.textContent = skill;
                        skillsElement.appendChild(skillSpan);
                    });
                } else if (typeof data.skills === 'string' && data.skills.trim()) {
                    // Handle skills as string
                    skillsElement.innerHTML = `<span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">${data.skills}</span>`;
                } else {
                    skillsElement.innerHTML = '<span class="text-gray-500 italic text-sm">Tidak ada keahlian</span>';
                }

                // Set IDs
                document.getElementById('modalId').textContent = `KADER-${data.id}`;

                // Set action links
                document.getElementById('modalEditLink').href = `/admin/kader/${data.id}/edit`;
                document.getElementById('modalDeleteLink').href = `/admin/kader/${data.id}`;
                document.getElementById('modalPrintLink').href = `/admin/kader/${data.id}/print-card`;
                document.getElementById('modalVerifyLink').href = data.is_verified ? '#' : `/admin/kader/${data.id}/verify`;
                document.getElementById('modalFullLink').href = `/admin/kader/${data.id}`;

                // Add delete confirmation
                document.getElementById('modalDeleteLink').onclick = function(e) {
                    e.preventDefault();
                    if (confirm('Apakah Anda yakin ingin menghapus kader ini?')) {
                        fetch(`/admin/kader/${data.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json',
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    showNotification('success', 'Kader berhasil dihapus');
                                    closeKaderDetail();
                                    // Reload page or remove row from table
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    throw new Error('Gagal menghapus kader');
                                }
                            })
                            .catch(error => {
                                showNotification('error', 'Gagal menghapus kader');
                            });
                    }
                };

                // Add verify action
                if (!data.is_verified) {
                    document.getElementById('modalVerifyLink').onclick = function(e) {
                        e.preventDefault();
                        if (confirm('Verifikasi kader ini?')) {
                            fetch(`/admin/kader/${data.id}/verify`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        'Accept': 'application/json',
                                    }
                                })
                                .then(response => {
                                    if (response.ok) {
                                        showNotification('success', 'Kader berhasil diverifikasi');
                                        closeKaderDetail();
                                        setTimeout(() => location.reload(), 1000);
                                    } else {
                                        throw new Error('Gagal memverifikasi kader');
                                    }
                                })
                                .catch(error => {
                                    showNotification('error', 'Gagal memverifikasi kader');
                                });
                        }
                    };
                } else {
                    document.getElementById('modalVerifyLink').onclick = function(e) {
                        e.preventDefault();
                        showNotification('info', 'Kader sudah terverifikasi');
                    };
                }

                // Hide loading, show content
                setTimeout(() => {
                    loading.classList.add('hidden');
                    contentArea.classList.remove('hidden');
                }, 300);
            })
            .catch(error => {
                console.error('Error fetching kader data:', error);
                loading.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-exclamation-triangle text-red-400 text-5xl mb-4"></i>
                    <p class="text-red-600 font-medium">Gagal memuat data kader</p>
                    <p class="text-gray-600 text-sm mt-1">${error.message}</p>
                    <button onclick="closeKaderDetail()" 
                            class="mt-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Tutup
                    </button>
                </div>
            `;
            });
    }

    function closeKaderDetail() {
        const modal = document.getElementById('kaderDetailModal');
        const content = document.getElementById('kaderModalContent');

        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            currentKaderData = null;
        }, 300);
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('kaderDetailModal').classList.contains('hidden')) {
            closeKaderDetail();
        }
    });

    // Close modal when clicking outside
    document.getElementById('kaderDetailModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeKaderDetail();
        }
    });
</script>