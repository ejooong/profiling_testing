@extends('layouts.admin')

@section('title', 'Edit Struktur DPD: ' . $dpd->name)

@section('content')
                        @php
                      
                        $departments = old('departemen', $structure->departemen ?? []);
                        
                        
                        if (is_string($departments)) {
                            $departments = json_decode($departments, true) ?? [];
                        }
                        
                       
                        if (empty($departments) || !is_array($departments)) {
                            $departments = [
                                ['name' => '', 'coordinator' => '', 'members' => '', 'description' => '']
                            ];
                        }
                    @endphp
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-600 to-slate-700 flex items-center justify-center shadow-lg">
                <i class="fas fa-edit text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Struktur DPD</h1>
                <div class="flex items-center text-sm text-slate-500 mt-1">
                    <i class="fas fa-building mr-2 text-xs"></i>
                    <span>{{ $dpd->name }}</span>
                </div>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.dpd.structure', $dpd) }}" 
               class="inline-flex items-center px-4 py-2.5 bg-white text-slate-700 rounded-lg border border-slate-200 hover:bg-slate-50 hover:border-slate-300 transition-all-300 shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden card-hover">
        <form action="{{ route('admin.dpd.structure.main.update', $dpd) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-6 space-y-8">
                <!-- Period Section -->
                <div class="bg-gradient-to-br from-slate-50 to-white p-5 rounded-xl border border-slate-100">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-accent to-accent-light flex items-center justify-center mr-3 shadow-sm">
                            <i class="fas fa-calendar-alt text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Periode Kepengurusan</h3>
                            <p class="text-sm text-slate-500">Tentukan periode masa jabatan</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Start Period -->
                        <div>
                            <label for="periode_mulai" class="block text-sm font-medium text-slate-700 mb-2 flex items-center">
                                <i class="fas fa-play text-slate-400 mr-2 text-xs"></i>Mulai Periode *
                            </label>
                            <input type="date" 
                                   name="periode_mulai" 
                                   id="periode_mulai" 
                                   value="{{ old('periode_mulai', $structure->periode_mulai) }}"
                                   required
                                   class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300 bg-white shadow-sm">
                            @error('periode_mulai')
                            <p class="mt-1 text-sm text-danger flex items-center">
                                <i class="fas fa-exclamation-circle mr-2 text-xs"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- End Period -->
                        <div>
                            <label for="periode_selesai" class="block text-sm font-medium text-slate-700 mb-2 flex items-center">
                                <i class="fas fa-stop text-slate-400 mr-2 text-xs"></i>Selesai Periode *
                            </label>
                            <input type="date" 
                                   name="periode_selesai" 
                                   id="periode_selesai" 
                                   value="{{ old('periode_selesai', $structure->periode_selesai) }}"
                                   required
                                   class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300 bg-white shadow-sm">
                            @error('periode_selesai')
                            <p class="mt-1 text-sm text-danger flex items-center">
                                <i class="fas fa-exclamation-circle mr-2 text-xs"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Main Leadership Section -->
                <div class="bg-gradient-to-br from-blue-50/50 to-white p-5 rounded-xl border border-blue-100">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center mr-3 shadow-sm">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Pimpinan Utama</h3>
                            <p class="text-sm text-slate-500">Data pimpinan tertinggi DPD</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Ketua -->
                        <div class="space-y-4">
                            <div>
                                <label for="ketua" class="block text-sm font-medium text-slate-700 mb-2 flex items-center">
                                    <i class="fas fa-crown text-red-500 mr-2 text-xs"></i>Ketua *
                                </label>
                                <input type="text" 
                                       name="ketua" 
                                       id="ketua" 
                                       value="{{ old('ketua', $structure->ketua) }}"
                                       required
                                       class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all-300 bg-white shadow-sm"
                                       placeholder="Nama ketua DPD">
                                @error('ketua')
                                <p class="mt-1 text-sm text-danger flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2 text-xs"></i>{{ $message }}
                                </p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2 flex items-center">
                                    <i class="fas fa-camera text-slate-400 mr-2 text-xs"></i>Foto Ketua
                                </label>
                                <div class="relative">
                                    <input type="file" 
                                           name="ketua_photo" 
                                           accept="image/*" 
                                           class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-accent/10 file:text-accent hover:file:bg-accent/20 transition-colors cursor-pointer">
                                </div>
                                @if($structure->ketua_photo)
                                <div class="mt-2 flex items-center text-xs text-slate-500">
                                    <i class="fas fa-image mr-2"></i>
                                    <span>Foto saat ini: {{ basename($structure->ketua_photo) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Sekretaris -->
                        <div class="space-y-4">
                            <div>
                                <label for="sekretaris" class="block text-sm font-medium text-slate-700 mb-2 flex items-center">
                                    <i class="fas fa-file-alt text-blue-500 mr-2 text-xs"></i>Sekretaris *
                                </label>
                                <input type="text" 
                                       name="sekretaris" 
                                       id="sekretaris" 
                                       value="{{ old('sekretaris', $structure->sekretaris) }}"
                                       required
                                       class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all-300 bg-white shadow-sm"
                                       placeholder="Nama sekretaris">
                                @error('sekretaris')
                                <p class="mt-1 text-sm text-danger flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2 text-xs"></i>{{ $message }}
                                </p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2 flex items-center">
                                    <i class="fas fa-camera text-slate-400 mr-2 text-xs"></i>Foto Sekretaris
                                </label>
                                <div class="relative">
                                    <input type="file" 
                                           name="sekretaris_photo" 
                                           accept="image/*" 
                                           class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-100 file:text-blue-600 hover:file:bg-blue-200 transition-colors cursor-pointer">
                                </div>
                                @if($structure->sekretaris_photo)
                                <div class="mt-2 flex items-center text-xs text-slate-500">
                                    <i class="fas fa-image mr-2"></i>
                                    <span>Foto saat ini: {{ basename($structure->sekretaris_photo) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Bendahara -->
                        <div class="space-y-4">
                            <div>
                                <label for="bendahara" class="block text-sm font-medium text-slate-700 mb-2 flex items-center">
                                    <i class="fas fa-money-bill-alt text-emerald-500 mr-2 text-xs"></i>Bendahara *
                                </label>
                                <input type="text" 
                                       name="bendahara" 
                                       id="bendahara" 
                                       value="{{ old('bendahara', $structure->bendahara) }}"
                                       required
                                       class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all-300 bg-white shadow-sm"
                                       placeholder="Nama bendahara">
                                @error('bendahara')
                                <p class="mt-1 text-sm text-danger flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2 text-xs"></i>{{ $message }}
                                </p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2 flex items-center">
                                    <i class="fas fa-camera text-slate-400 mr-2 text-xs"></i>Foto Bendahara
                                </label>
                                <div class="relative">
                                    <input type="file" 
                                           name="bendahara_photo" 
                                           accept="image/*" 
                                           class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-100 file:text-emerald-600 hover:file:bg-emerald-200 transition-colors cursor-pointer">
                                </div>
                                @if($structure->bendahara_photo)
                                <div class="mt-2 flex items-center text-xs text-slate-500">
                                    <i class="fas fa-image mr-2"></i>
                                    <span>Foto saat ini: {{ basename($structure->bendahara_photo) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Departments Section -->
                <div class="bg-gradient-to-br from-slate-50/50 to-white p-5 rounded-xl border border-slate-100">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-slate-600 to-slate-700 flex items-center justify-center mr-3 shadow-sm">
                                <i class="fas fa-network-wired text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">Departemen</h3>
                                <p class="text-sm text-slate-500">Kelola departemen kepengurusan (maksimal 6)</p>
                            </div>
                        </div>
                        <div class="text-xs font-medium text-slate-600 bg-slate-100 px-3 py-1 rounded-full">
                            <span id="dept-count">{{ is_array($departments) ? count($departments) : 0 }}</span>/6 departemen
                        </div>
                    </div>
                    
                    <div id="departments-container" class="space-y-4">

                                            
                        @foreach($departments as $index => $dept)
                        <div class="department-item p-5 bg-white border border-slate-200 rounded-xl hover:border-slate-300 transition-all-300">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-accent/20 to-accent/10 flex items-center justify-center mr-3">
                                        <span class="text-sm font-bold text-accent">{{ $index + 1 }}</span>
                                    </div>
                                    <h4 class="font-bold text-slate-800">Departemen #{{ $index + 1 }}</h4>
                                </div>
                                @if($index > 0)
                                <button type="button" 
                                        onclick="removeDepartment(this)" 
                                        class="w-8 h-8 rounded-lg bg-danger/10 text-danger hover:bg-danger/20 flex items-center justify-center transition-colors">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                                @endif
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-xs font-medium text-slate-600 flex items-center">
                                        <i class="fas fa-briefcase mr-2 text-xs"></i>Nama Departemen *
                                    </label>
                                    <input type="text" 
                                           name="departemen[{{ $index }}][name]" 
                                           value="{{ $dept['name'] ?? '' }}"
                                           required
                                           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300"
                                           placeholder="Contoh: Departemen Organisasi">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-xs font-medium text-slate-600 flex items-center">
                                        <i class="fas fa-user-tie mr-2 text-xs"></i>Koordinator *
                                    </label>
                                    <input type="text" 
                                           name="departemen[{{ $index }}][coordinator]" 
                                           value="{{ $dept['coordinator'] ?? '' }}"
                                           required
                                           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300"
                                           placeholder="Nama koordinator">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-xs font-medium text-slate-600 flex items-center">
                                        <i class="fas fa-users mr-2 text-xs"></i>Jumlah Anggota
                                    </label>
                                    <input type="number" 
                                           name="departemen[{{ $index }}][members]" 
                                           value="{{ $dept['members'] ?? '' }}"
                                           min="0"
                                           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300"
                                           placeholder="0">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-xs font-medium text-slate-600 flex items-center">
                                        <i class="fas fa-tasks mr-2 text-xs"></i>Deskripsi Tugas
                                    </label>
                                    <textarea name="departemen[{{ $index }}][description]" 
                                              rows="2"
                                              class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300">{{ $dept['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <button type="button" 
                            onclick="addDepartment()" 
                            class="mt-4 inline-flex items-center px-4 py-2.5 bg-gradient-to-br from-accent/10 to-accent/5 border border-accent/20 text-accent rounded-lg hover:bg-accent/20 hover:border-accent/30 transition-all-300 shadow-sm">
                        <i class="fas fa-plus mr-2"></i>Tambah Departemen
                    </button>
                </div>

                <!-- Vision & Mission Section -->
                <div class="bg-gradient-to-br from-emerald-50/50 to-white p-5 rounded-xl border border-emerald-100">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-emerald-600 to-emerald-700 flex items-center justify-center mr-3 shadow-sm">
                            <i class="fas fa-bullseye text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Visi & Misi</h3>
                            <p class="text-sm text-slate-500">Tentukan arah dan strategi organisasi</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label for="visi" class="block text-sm font-medium text-slate-700 flex items-center">
                                <i class="fas fa-eye text-emerald-500 mr-2 text-xs"></i>Visi Organisasi
                            </label>
                            <textarea name="visi" 
                                      id="visi" 
                                      rows="3"
                                      class="w-full border border-slate-300 rounded-lg px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all-300 bg-white shadow-sm"
                                      placeholder="Tulis visi organisasi disini...">{{ old('visi', $structure->visi) }}</textarea>
                            <div class="flex items-center text-xs text-slate-500">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span>Visi adalah tujuan jangka panjang organisasi</span>
                            </div>
                            @error('visi')
                            <p class="mt-1 text-sm text-danger flex items-center">
                                <i class="fas fa-exclamation-circle mr-2 text-xs"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="misi" class="block text-sm font-medium text-slate-700 flex items-center">
                                <i class="fas fa-bullseye-arrow text-emerald-500 mr-2 text-xs"></i>Misi Organisasi
                            </label>
                            <textarea name="misi" 
                                      id="misi" 
                                      rows="4"
                                      class="w-full border border-slate-300 rounded-lg px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all-300 bg-white shadow-sm"
                                      placeholder="Tulis misi organisasi disini...">{{ old('misi', $structure->misi) }}</textarea>
                            <div class="flex items-center text-xs text-slate-500">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span>Misi adalah langkah-langkah untuk mencapai visi</span>
                            </div>
                            @error('misi')
                            <p class="mt-1 text-sm text-danger flex items-center">
                                <i class="fas fa-exclamation-circle mr-2 text-xs"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Notes Section -->
                <div class="bg-gradient-to-br from-slate-50 to-white p-5 rounded-xl border border-slate-100">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-slate-600 to-slate-700 flex items-center justify-center mr-3 shadow-sm">
                            <i class="fas fa-sticky-note text-white"></i>
                        </div>
                        <div>
                            <label for="catatan" class="block text-sm font-medium text-slate-700">Catatan Tambahan</label>
                            <p class="text-xs text-slate-500">Informasi atau catatan khusus lainnya</p>
                        </div>
                    </div>
                    
                    <textarea name="catatan" 
                              id="catatan" 
                              rows="3"
                              class="w-full border border-slate-300 rounded-lg px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300 bg-white shadow-sm"
                              placeholder="Tulis catatan tambahan disini...">{{ old('catatan', $structure->catatan) }}</textarea>
                    
                    <div class="mt-2 flex items-center text-xs text-slate-500">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span>Catatan ini akan ditampilkan di halaman struktur</span>
                    </div>
                    @error('catatan')
                    <p class="mt-1 text-sm text-danger flex items-center">
                        <i class="fas fa-exclamation-circle mr-2 text-xs"></i>{{ $message }}
                    </p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gradient-to-r from-slate-50 to-white border-t border-slate-100 flex justify-end space-x-3">
                <a href="{{ route('admin.dpd.structure', $dpd) }}" 
                   class="px-4 py-2.5 bg-white text-slate-700 rounded-lg border border-slate-200 hover:bg-slate-50 hover:border-slate-300 transition-all-300 shadow-sm">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2.5 bg-gradient-to-br from-accent to-accent-light text-white rounded-lg hover:shadow-lg transition-all-300 shadow-md">
                    <i class="fas fa-save mr-2"></i>Update Struktur
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let departmentCount = {{ is_array($departments) ? count($departments) : 0 }};

function updateDepartmentCount() {
    document.getElementById('dept-count').textContent = departmentCount;
}

function addDepartment() {
    if (departmentCount >= 6) {
        showNotification('error', 'Maksimal 6 departemen yang dapat ditambahkan.');
        return;
    }
    
    const container = document.getElementById('departments-container');
    const index = departmentCount;
    
    const html = `
    <div class="department-item p-5 bg-white border border-slate-200 rounded-xl hover:border-slate-300 transition-all-300">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-accent/20 to-accent/10 flex items-center justify-center mr-3">
                    <span class="text-sm font-bold text-accent">${index + 1}</span>
                </div>
                <h4 class="font-bold text-slate-800">Departemen #${index + 1}</h4>
            </div>
            <button type="button" 
                    onclick="removeDepartment(this)" 
                    class="w-8 h-8 rounded-lg bg-danger/10 text-danger hover:bg-danger/20 flex items-center justify-center transition-colors">
                <i class="fas fa-trash text-xs"></i>
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="block text-xs font-medium text-slate-600 flex items-center">
                    <i class="fas fa-briefcase mr-2 text-xs"></i>Nama Departemen *
                </label>
                <input type="text" 
                       name="departemen[${index}][name]" 
                       required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300"
                       placeholder="Contoh: Departemen Organisasi">
            </div>
            <div class="space-y-2">
                <label class="block text-xs font-medium text-slate-600 flex items-center">
                    <i class="fas fa-user-tie mr-2 text-xs"></i>Koordinator *
                </label>
                <input type="text" 
                       name="departemen[${index}][coordinator]" 
                       required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300"
                       placeholder="Nama koordinator">
            </div>
            <div class="space-y-2">
                <label class="block text-xs font-medium text-slate-600 flex items-center">
                    <i class="fas fa-users mr-2 text-xs"></i>Jumlah Anggota
                </label>
                <input type="number" 
                       name="departemen[${index}][members]" 
                       min="0"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300"
                       placeholder="0">
            </div>
            <div class="space-y-2">
                <label class="block text-xs font-medium text-slate-600 flex items-center">
                    <i class="fas fa-tasks mr-2 text-xs"></i>Deskripsi Tugas
                </label>
                <textarea name="departemen[${index}][description]" 
                          rows="2"
                          class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300"></textarea>
            </div>
        </div>
    </div>
    `;
    
    container.insertAdjacentHTML('beforeend', html);
    departmentCount++;
    updateDepartmentCount();
    showNotification('success', 'Departemen berhasil ditambahkan');
}

function removeDepartment(button) {
    if (departmentCount <= 1) {
        showNotification('error', 'Minimal harus ada 1 departemen.');
        return;
    }
    
    const item = button.closest('.department-item');
    item.remove();
    departmentCount--;
    updateDepartmentCount();
    
    // Update department numbers
    const departments = document.querySelectorAll('.department-item');
    departments.forEach((dept, index) => {
        const numberElement = dept.querySelector('.w-8.h-8 span');
        const titleElement = dept.querySelector('h4');
        
        if (numberElement) numberElement.textContent = index + 1;
        if (titleElement) titleElement.textContent = `Departemen #${index + 1}`;
        
        // Update input names
        const inputs = dept.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            const name = input.name.replace(/departemen\[\d+\]/, `departemen[${index}]`);
            input.name = name;
        });
    });
    
    showNotification('info', 'Departemen berhasil dihapus');
}

// Initialize department count
updateDepartmentCount();

// Add validation for dates
document.addEventListener('DOMContentLoaded', function() {
    const startDate = document.getElementById('periode_mulai');
    const endDate = document.getElementById('periode_selesai');
    
    if (startDate && endDate) {
        // Set min date for end date
        startDate.addEventListener('change', function() {
            endDate.min = this.value;
            if (endDate.value && endDate.value < this.value) {
                endDate.value = this.value;
            }
        });
        
        // Set max date for start date
        endDate.addEventListener('change', function() {
            startDate.max = this.value;
            if (startDate.value && startDate.value > this.value) {
                startDate.value = this.value;
            }
        });
    }
});
</script>
@endpush
@endsection