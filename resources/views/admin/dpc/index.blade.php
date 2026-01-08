@extends('layouts.admin')

@section('title', 'Manajemen DPC')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dewan Pimpinan Cabang (DPC)</h1>
            <p class="mt-1 text-sm text-gray-600">Manajemen data DPC Kecamatan</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.dpc.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-plus mr-2"></i>Tambah DPC
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">DPD</label>
                    <select onchange="window.location.href = this.value" 
                            class="border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 text-sm">
                        <option value="{{ route('admin.dpc.index') }}" 
                                {{ request('dpd_id') ? '' : 'selected' }}>
                            Semua DPD
                        </option>
                        @foreach($dpds as $dpd)
                        <option value="{{ route('admin.dpc.index', ['dpd_id' => $dpd->id]) }}"
                                {{ request('dpd_id') == $dpd->id ? 'selected' : '' }}>
                            {{ $dpd->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Status</label>
                    <select onchange="window.location.href = this.value" 
                            class="border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 text-sm">
                        <option value="{{ route('admin.dpc.index') }}" 
                                {{ request('status') ? '' : 'selected' }}>
                            Semua Status
                        </option>
                        <option value="{{ route('admin.dpc.index', ['status' => 'active']) }}"
                                {{ request('status') == 'active' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="{{ route('admin.dpc.index', ['status' => 'inactive']) }}"
                                {{ request('status') == 'inactive' ? 'selected' : '' }}>
                            Non-Aktif
                        </option>
                    </select>
                </div>
            </div>
            <div class="flex-1 max-w-md">
                <form method="GET" action="{{ route('admin.dpc.index') }}">
                    <div class="relative">
                        <input type="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari kecamatan, ketua, alamat..."
                               class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200">
                        <div class="absolute left-3 top-2.5">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-blue-600">{{ $totalDpc }}</div>
            <div class="text-sm text-gray-600">Total DPC</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-green-600">{{ $activeDpc }}</div>
            <div class="text-sm text-gray-600">DPC Aktif</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-yellow-600">{{ $inactiveDpc }}</div>
            <div class="text-sm text-gray-600">DPC Non-Aktif</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-purple-600">{{ $totalKader }}</div>
            <div class="text-sm text-gray-600">Total Kader</div>
        </div>
    </div>

    <!-- DPC List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($dpcs->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kecamatan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            DPD
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pimpinan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statistik
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($dpcs as $dpc)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $dpc->kecamatan_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ Str::limit($dpc->address, 40) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $dpc->dpd->name ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="text-gray-900">
                                    <i class="fas fa-crown text-yellow-500 mr-1"></i>
                                    {{ $dpc->ketua ?? '-' }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $dpc->phone }} | {{ $dpc->email }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="flex space-x-3">
                                    <div class="text-center">
                                        <div class="font-bold text-blue-600">{{ $dpc->total_kader }}</div>
                                        <div class="text-xs text-gray-500">Kader</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="font-bold text-green-600">{{ $dpc->total_dprt }}</div>
                                        <div class="text-xs text-gray-500">DPRT</div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($dpc->is_active)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Non-Aktif
                            </span>
                            @endif
                            @if($dpc->deleted_at)
                            <div class="mt-1 text-xs text-red-600">
                                <i class="fas fa-trash"></i> Terhapus
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                               <button type="button" 
                                        onclick="showDpcDetail({{ $dpc->id }})"
                                        class="text-blue-600 hover:text-blue-900"
                                        title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('admin.dpc.edit', $dpc) }}" 
                                   class="text-yellow-600 hover:text-yellow-900"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.dpc.structure', $dpc) }}" 
                                   class="text-purple-600 hover:text-purple-900"
                                   title="Struktur">
                                    <i class="fas fa-sitemap"></i>
                                </a>
                                @if($dpc->deleted_at)
                                <form action="{{ route('admin.dpc.restore', $dpc) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="text-green-600 hover:text-green-900"
                                            title="Pulihkan">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.dpc.destroy', $dpc) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus DPC ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t">
            {{ $dpcs->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="p-12 text-center">
            <i class="fas fa-map-marker-alt text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Belum ada data DPC</h3>
            <p class="text-gray-600 mb-6">Silakan tambahkan data DPC terlebih dahulu.</p>
            <a href="{{ route('admin.dpc.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-plus mr-2"></i>Tambah DPC
            </a>
        </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.dprt.index') }}" 
           class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300 border border-transparent hover:border-nasdem-red">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                    <i class="fas fa-map-pin text-green-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">DPRT Desa</h3>
                    <p class="text-sm text-gray-600">{{ \App\Models\DPRT\Dprt::count() }} DPRT</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.dpd.index') }}" 
           class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300 border border-transparent hover:border-nasdem-red">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mr-4">
                    <i class="fas fa-building text-red-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">DPD Kabupaten</h3>
                    <p class="text-sm text-gray-600">{{ \App\Models\DPD\Dpd::count() }} DPD</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.kader.index') }}" 
           class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300 border border-transparent hover:border-nasdem-red">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                    <i class="fas fa-users text-purple-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">Kader</h3>
                    <p class="text-sm text-gray-600">{{ \App\Models\Kader\Kader::count() }} Kader</p>
                </div>
            </div>
        </a>
    </div>
</div>
@include('admin.dpc.partials.detail-modal')
@endsection