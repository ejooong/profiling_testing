@extends('layouts.admin')

@section('title', 'Manajemen DPRT')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dewan Pimpinan Ranting (DPRT)</h1>
            <p class="mt-1 text-sm text-gray-600">Manajemen data DPRT Desa/Kelurahan</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.dprt.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-plus mr-2"></i>Tambah DPRT
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">DPC</label>
                    <select onchange="window.location.href = this.value" 
                            class="border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 text-sm">
                        <option value="{{ route('admin.dprt.index') }}" 
                                {{ request('dpc_id') ? '' : 'selected' }}>
                            Semua DPC
                        </option>
                        @foreach($dpcs as $dpc)
                        <option value="{{ route('admin.dprt.index', ['dpc_id' => $dpc->id]) }}"
                                {{ request('dpc_id') == $dpc->id ? 'selected' : '' }}>
                            {{ $dpc->kecamatan_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Status</label>
                    <select onchange="window.location.href = this.value" 
                            class="border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 text-sm">
                        <option value="{{ route('admin.dprt.index') }}" 
                                {{ request('status') ? '' : 'selected' }}>
                            Semua Status
                        </option>
                        <option value="{{ route('admin.dprt.index', ['status' => 'active']) }}"
                                {{ request('status') == 'active' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="{{ route('admin.dprt.index', ['status' => 'inactive']) }}"
                                {{ request('status') == 'inactive' ? 'selected' : '' }}>
                            Non-Aktif
                        </option>
                    </select>
                </div>
            </div>
            <div class="flex-1 max-w-md">
                <form method="GET" action="{{ route('admin.dprt.index') }}">
                    <div class="relative">
                        <input type="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari desa, ketua, alamat..."
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
            <div class="text-2xl font-bold text-blue-600">{{ $totalDprt }}</div>
            <div class="text-sm text-gray-600">Total DPRT</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-green-600">{{ $activeDprt }}</div>
            <div class="text-sm text-gray-600">DPRT Aktif</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-yellow-600">{{ $inactiveDprt }}</div>
            <div class="text-sm text-gray-600">DPRT Non-Aktif</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-purple-600">{{ $totalKader }}</div>
            <div class="text-sm text-gray-600">Total Kader</div>
        </div>
    </div>

    <!-- DPRT List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($dprts->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Desa/Kelurahan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            DPC
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ketua
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
                    @foreach($dprts as $dprt)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-map-pin text-green-600"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $dprt->desa_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ Str::limit($dprt->address, 40) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $dprt->dpc->kecamatan_name ?? '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $dprt->dpc->dpd->name ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="text-gray-900">
                                    <i class="fas fa-crown text-yellow-500 mr-1"></i>
                                    {{ $dprt->ketua ?? '-' }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $dprt->phone }} | {{ $dprt->email }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="text-center">
                                    <div class="font-bold text-blue-600">{{ $dprt->total_kader }}</div>
                                    <div class="text-xs text-gray-500">Kader</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($dprt->is_active)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Non-Aktif
                            </span>
                            @endif
                            @if($dprt->deleted_at)
                            <div class="mt-1 text-xs text-red-600">
                                <i class="fas fa-trash"></i> Terhapus
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                       <button onclick="showDprtDetail({{ $dprt->id }})" 
                class="text-blue-600 hover:text-blue-900"
                title="Detail">
            <i class="fas fa-eye"></i>
        </button>
                                <a href="{{ route('admin.dprt.edit', $dprt) }}" 
                                   class="text-yellow-600 hover:text-yellow-900"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.dprt.structure.index', $dprt) }}" 
                                   class="text-purple-600 hover:text-purple-900"
                                   title="Struktur">
                                    <i class="fas fa-sitemap"></i>
                                </a>
                                @if($dprt->deleted_at)
                                <form action="{{ route('admin.dprt.restore', $dprt) }}" 
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
                                <form action="{{ route('admin.dprt.destroy', $dprt) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus DPRT ini?')">
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
            {{ $dprts->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="p-12 text-center">
            <i class="fas fa-map-pin text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Belum ada data DPRT</h3>
            <p class="text-gray-600 mb-6">Silakan tambahkan data DPRT terlebih dahulu.</p>
            <a href="{{ route('admin.dprt.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-plus mr-2"></i>Tambah DPRT
            </a>
        </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.dpc.index') }}" 
           class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300 border border-transparent hover:border-nasdem-red">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">DPC Kecamatan</h3>
                    <p class="text-sm text-gray-600">{{ \App\Models\DPC\Dpc::count() }} DPC</p>
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

<!-- Include DPRT Detail Modal -->
@include('admin.dprt.partials.detail-modal')
@endsection