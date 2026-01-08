@extends('layouts.admin')

@section('title', 'Manajemen Kader')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-xl shadow-lg p-6 mb-6">
        <div class="flex flex-col lg:flex-row justify-between items-center">
            <div class="text-white mb-4 lg:mb-0">
                <h1 class="text-3xl font-bold">Manajemen Kader</h1>
                <p class="text-slate-300 mt-2">Data kader Partai NasDem Kabupaten Bojonegoro</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.kader.create') }}" 
                   class="inline-flex items-center px-5 py-2.5 bg-accent text-white rounded-lg hover:bg-accent-light transition-all duration-300 shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus mr-2"></i>Tambah Kader
                </a>
                <button type="button" 
                        onclick="alert('Fitur export akan segera tersedia')"
                        class="inline-flex items-center px-5 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                    <i class="fas fa-file-excel mr-2"></i>Export Excel
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-slate-700">
            <div class="flex items-center">
                <div class="p-3 bg-slate-100 rounded-lg mr-4">
                    <i class="fas fa-users text-slate-700 text-2xl"></i>
                </div>
                <div>
                    <div class="text-3xl font-bold text-slate-800">{{ $totalKader }}</div>
                    <div class="text-gray-600">Total Kader</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-success">
            <div class="flex items-center">
                <div class="p-3 bg-success/10 rounded-lg mr-4">
                    <i class="fas fa-check-circle text-success text-2xl"></i>
                </div>
                <div>
                    <div class="text-3xl font-bold text-slate-800">{{ $activeKader }}</div>
                    <div class="text-gray-600">Kader Aktif</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-warning">
            <div class="flex items-center">
                <div class="p-3 bg-warning/10 rounded-lg mr-4">
                    <i class="fas fa-clock text-warning text-2xl"></i>
                </div>
                <div>
                    <div class="text-3xl font-bold text-slate-800">{{ $pendingKader }}</div>
                    <div class="text-gray-600">Pending</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-danger">
            <div class="flex items-center">
                <div class="p-3 bg-danger/10 rounded-lg mr-4">
                    <i class="fas fa-times-circle text-danger text-2xl"></i>
                </div>
                <div>
                    <div class="text-3xl font-bold text-slate-800">{{ $rejectedKader }}</div>
                    <div class="text-gray-600">Non Aktif</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-col md:flex-row gap-4 mb-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">DPC Kecamatan</label>
                <select onchange="window.location.href = this.value" 
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-all">
                    <option value="{{ route('admin.kader.index') }}" 
                            {{ request('dpc_id') ? '' : 'selected' }}>
                        Semua DPC
                    </option>
                    @foreach($dpcs as $dpc)
                    <option value="{{ route('admin.kader.index', ['dpc_id' => $dpc->id]) }}"
                            {{ request('dpc_id') == $dpc->id ? 'selected' : '' }}>
                        {{ $dpc->kecamatan_name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select onchange="window.location.href = this.value" 
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-all">
                    <option value="{{ route('admin.kader.index') }}" 
                            {{ request('status') ? '' : 'selected' }}>
                        Semua Status
                    </option>
                    <option value="{{ route('admin.kader.index', ['status' => 'active']) }}"
                            {{ request('status') == 'active' ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="{{ route('admin.kader.index', ['status' => 'pending']) }}"
                            {{ request('status') == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>
                    <option value="{{ route('admin.kader.index', ['status' => 'non_active']) }}"
                            {{ request('status') == 'non_active' ? 'selected' : '' }}>
                        Non Aktif
                    </option>
                </select>
            </div>
            
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                <form method="GET" action="{{ route('admin.kader.index') }}">
                    <div class="relative">
                        <input type="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari nama, NIK, email..."
                               class="w-full pl-12 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-all">
                        <div class="absolute left-4 top-3.5">
                            <i class="fas fa-search text-slate-400"></i>
                        </div>
                        @if(request('search'))
                        <a href="{{ route('admin.kader.index') }}" 
                           class="absolute right-4 top-3.5 text-slate-400 hover:text-slate-600">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Kader Grid -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        @if($kaders->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-6">
            @foreach($kaders as $kader)
            <div class="bg-gradient-to-b from-slate-50 to-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-slate-200 kader-card">
                <!-- Header with Photo -->
                <div class="relative h-48 bg-slate-800 overflow-hidden">
                    @if($kader->photo_path)
                    <div class="w-full h-full flex items-center justify-center p-2">
                        <img src="{{ asset('storage/' . $kader->photo_path) }}" 
                             alt="{{ $kader->name }}" 
                             class="max-w-full max-h-full object-contain rounded-lg">
                    </div>
                    @else
                    <div class="flex items-center justify-center h-full">
                        <div class="w-24 h-24 rounded-full bg-white/10 backdrop-blur-sm flex items-center justify-center">
                            <i class="fas fa-user text-white text-4xl"></i>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4">
                        @if($kader->status == 'active')
                        <span class="px-3 py-1 bg-success text-white text-xs font-semibold rounded-full shadow-sm">
                            <i class="fas fa-check-circle mr-1"></i>Aktif
                        </span>
                        @elseif($kader->status == 'pending')
                        <span class="px-3 py-1 bg-warning text-white text-xs font-semibold rounded-full shadow-sm">
                            <i class="fas fa-clock mr-1"></i>Pending
                        </span>
                        @else
                        <span class="px-3 py-1 bg-danger text-white text-xs font-semibold rounded-full shadow-sm">
                            <i class="fas fa-times-circle mr-1"></i>Non Aktif
                        </span>
                        @endif
                    </div>
                </div>
                
                <!-- Profile Info -->
                <div class="p-6">
                    <div class="text-center mb-4">
                        <h3 class="text-xl font-bold text-slate-900">{{ $kader->name }}</h3>
                        <p class="text-slate-600 text-sm mt-1">{{ $kader->profession }}</p>
                        
                        @if($kader->dpc)
                        <div class="flex items-center justify-center mt-2 text-sm text-slate-500">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $kader->dpc->kecamatan_name }}
                        </div>
                        @endif
                    </div>
                    
                    <!-- Quick Info -->
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-id-card text-slate-600 w-5 mr-3"></i>
                            <span class="text-sm text-slate-700">NIK: {{ $kader->nik }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone text-slate-600 w-5 mr-3"></i>
                            <span class="text-sm text-slate-700">{{ $kader->phone }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-slate-600 w-5 mr-3"></i>
                            <span class="text-sm text-slate-700">Bergabung: {{ $kader->join_date->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex justify-center mt-6 pt-4 border-t border-slate-100">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.kader.show', $kader) }}" 
                               class="p-2 text-accent hover:bg-accent/10 rounded-lg transition-colors"
                               title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.kader.edit', $kader) }}" 
                               class="p-2 text-warning hover:bg-warning/10 rounded-lg transition-colors"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            @if($kader->status == 'pending')
                            <form action="{{ route('admin.kader.verify', $kader) }}" 
                                  method="POST" 
                                  class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="active">
                                <button type="submit" 
                                        class="p-2 text-success hover:bg-success/10 rounded-lg transition-colors"
                                        title="Verifikasi"
                                        onclick="return confirm('Verifikasi kader ini?')">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif
                            
                            @if(!$kader->deleted_at)
                            <form action="{{ route('admin.kader.destroy', $kader) }}" 
                                  method="POST" 
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 text-danger hover:bg-danger/10 rounded-lg transition-colors"
                                        title="Hapus"
                                        onclick="return confirm('Hapus kader ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $kaders->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-slate-100 flex items-center justify-center">
                <i class="fas fa-users text-slate-600 text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 mb-2">Belum ada data kader</h3>
            <p class="text-slate-600 mb-8 max-w-md mx-auto">Mulai dengan menambahkan data kader baru untuk membangun database anggota partai.</p>
            <a href="{{ route('admin.kader.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-slate-800 to-slate-900 text-white rounded-lg hover:from-slate-900 hover:to-slate-950 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-plus mr-2"></i>Tambah Kader Pertama
            </a>
        </div>
        @endif
    </div>

    <!-- Quick Stats -->
    <div class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl shadow-lg p-6 mt-6">
        <div class="text-center mb-6">
            <h3 class="text-xl font-bold text-slate-900">Statistik Singkat</h3>
            <p class="text-slate-600">Gambaran cepat database kader</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                <div class="text-2xl font-bold text-slate-700">{{ $kaders->count() }}</div>
                <div class="text-sm text-slate-600">Ditampilkan</div>
            </div>
            <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                <div class="text-2xl font-bold text-success">{{ round(($activeKader / max($totalKader, 1)) * 100) }}%</div>
                <div class="text-sm text-slate-600">Rasio Aktif</div>
            </div>
            <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                <div class="text-2xl font-bold text-warning">{{ round(($pendingKader / max($totalKader, 1)) * 100) }}%</div>
                <div class="text-sm text-slate-600">Belum Diverifikasi</div>
            </div>
            <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                <div class="text-2xl font-bold text-accent">{{ $dpcs->count() }}</div>
                <div class="text-sm text-slate-600">DPC Tersedia</div>
            </div>
        </div>
    </div>
</div>

<style>
    .kader-card {
        transition: all 0.3s ease;
    }
    .kader-card:hover {
        transform: translateY(-5px);
    }
    
    .photo-container {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    }
</style>

@push('scripts')
<script>
    // Card hover effect
    document.querySelectorAll('.kader-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-5px)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    });
</script>
@endpush
@endsection