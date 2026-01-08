@extends('layouts.admin')

@section('title', 'Struktur DPRT: ' . $dprt->desa_name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Struktur Organisasi DPRT</h1>
            <p class="mt-1 text-sm text-gray-600">{{ $dprt->desa_name }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.dprt.show', $dprt) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <a href="{{ route('admin.dprt.structure.create', $dprt) }}" 
               class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-plus mr-2"></i>Tambah Pengurus
            </a>
        </div>
    </div>

    <!-- Structure Management -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Daftar Pengurus DPRT</h2>
                    <p class="text-sm text-gray-600">Total {{ $structures->count() }} pengurus</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Filter:</span>
                    <select onchange="filterByLevel(this.value)" 
                            class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">Semua Level</option>
                        <option value="pengurus">Pengurus</option>
                        <option value="anggota">Anggota</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Structure Table -->
        @if($structures->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Urutan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jabatan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Pengurus
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kontak
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Level
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
                    @foreach($structures as $structure)
                    <tr class="hover:bg-gray-50" data-level="{{ $structure->level }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 text-green-800 rounded-full text-sm font-bold">
                                    {{ $structure->order }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $structure->position_name }}
                            </div>
                            @if($structure->responsibilities)
                            <div class="text-xs text-gray-500 mt-1">
                                {{ Str::limit($structure->responsibilities, 60) }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($structure->person_photo)
                                <div class="flex-shrink-0 h-10 w-10 mr-3">
                                    <img class="h-10 w-10 rounded-full object-cover" 
                                         src="{{ asset('storage/' . $structure->person_photo) }}" 
                                         alt="{{ $structure->person_name }}">
                                </div>
                                @else
                                <div class="flex-shrink-0 h-10 w-10 mr-3 bg-gray-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $structure->person_name }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ $structure->phone ?? '-' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $structure->email ?? '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($structure->level == 'pengurus')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Pengurus
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Anggota
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($structure->is_active)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Non-Aktif
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.dprt.structure.edit', [$dprt, $structure]) }}" 
                                   class="text-yellow-600 hover:text-yellow-900"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.dprt.structure.destroy', [$dprt, $structure]) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengurus ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <!-- Empty State -->
        <div class="p-12 text-center">
            <i class="fas fa-sitemap text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Belum ada struktur organisasi</h3>
            <p class="text-gray-600 mb-6">Tambahkan pengurus untuk membentuk struktur organisasi DPRT.</p>
            <a href="{{ route('admin.dprt.structure.create', $dprt) }}" 
               class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-plus mr-2"></i>Tambah Pengurus
            </a>
        </div>
        @endif
    </div>

    <!-- Print/Export Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Ekspor Struktur Organisasi</h3>
        <div class="flex space-x-4">
            <button onclick="window.print()" 
                    class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-print mr-2"></i>Cetak Struktur
            </button>
            <a href="{{ route('admin.dprt.structure.export', $dprt) }}" 
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                <i class="fas fa-file-excel mr-2"></i>Export Excel
            </a>
        </div>
    </div>

    <!-- Organization Chart Preview -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-medium text-gray-900">Preview Struktur Organisasi</h3>
            <button onclick="toggleChart()" 
                    class="text-sm text-nasdem-red hover:text-red-700">
                <i class="fas fa-expand mr-1"></i>Tampilkan/Sembunyikan
            </button>
        </div>
        
        <div id="org-chart" class="hidden">
            <div class="bg-gray-50 p-4 rounded-lg">
                <!-- Ketua -->
                @php $ketua = $structures->where('level', 'pengurus')->where('position_name', 'like', '%ketua%')->first(); @endphp
                @if($ketua)
                <div class="flex justify-center mb-8">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-2">
                            @if($ketua->person_photo)
                            <img src="{{ asset('storage/' . $ketua->person_photo) }}" 
                                 alt="{{ $ketua->person_name }}" 
                                 class="w-20 h-20 rounded-full object-cover">
                            @else
                            <i class="fas fa-crown text-green-600 text-3xl"></i>
                            @endif
                        </div>
                        <h4 class="font-bold text-gray-900">{{ $ketua->position_name }}</h4>
                        <p class="text-nasdem-red font-medium">{{ $ketua->person_name }}</p>
                    </div>
                </div>
                @endif

                <!-- Pengurus Inti -->
                @php $pengurusInti = $structures->where('level', 'pengurus')->whereNotIn('position_name', ['Ketua', 'ketua'])->take(4); @endphp
                @if($pengurusInti->count() > 0)
                <div class="flex justify-center mb-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($pengurusInti as $pengurus)
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-2">
                                @if($pengurus->person_photo)
                                <img src="{{ asset('storage/' . $pengurus->person_photo) }}" 
                                     alt="{{ $pengurus->person_name }}" 
                                     class="w-16 h-16 rounded-full object-cover">
                                @else
                                <i class="fas fa-user-tie text-blue-600 text-xl"></i>
                                @endif
                            </div>
                            <h5 class="text-sm font-medium text-gray-900">{{ $pengurus->position_name }}</h5>
                            <p class="text-xs text-gray-700">{{ $pengurus->person_name }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Anggota -->
                @php $anggota = $structures->where('level', 'anggota'); @endphp
                @if($anggota->count() > 0)
                <div class="mt-8">
                    <h4 class="text-center font-medium text-gray-900 mb-4">Anggota</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                        @foreach($anggota as $member)
                        <div class="text-center bg-white p-2 rounded border">
                            <div class="w-10 h-10 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-1">
                                @if($member->person_photo)
                                <img src="{{ asset('storage/' . $member->person_photo) }}" 
                                     alt="{{ $member->person_name }}" 
                                     class="w-10 h-10 rounded-full object-cover">
                                @else
                                <i class="fas fa-user text-gray-600 text-sm"></i>
                                @endif
                            </div>
                            <h5 class="text-xs font-medium text-gray-900">{{ $member->position_name }}</h5>
                            <p class="text-xs text-gray-700 truncate">{{ $member->person_name }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function filterByLevel(level) {
    const rows = document.querySelectorAll('tbody tr[data-level]');
    rows.forEach(row => {
        if (!level || row.dataset.level === level) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function toggleChart() {
    const chart = document.getElementById('org-chart');
    chart.classList.toggle('hidden');
}
</script>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    #org-chart {
        display: block !important;
    }
    
    body {
        font-size: 12pt;
    }
    
    .bg-white {
        box-shadow: none;
        border: 1px solid #ddd;
    }
}
</style>
@endpush
@endsection