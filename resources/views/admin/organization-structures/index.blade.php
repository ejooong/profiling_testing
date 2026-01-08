@extends('layouts.admin')

@section('title', 'Struktur Organisasi')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Struktur Organisasi</h1>
            <p class="text-slate-600 mt-1">Manajemen struktur organisasi DPD, DPC, dan DPRT</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.organization-structures.select-organization') }}"
                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-br from-accent to-accent-light text-white rounded-lg hover:shadow-lg transition-all-300">
                <i class="fas fa-plus mr-2"></i>Tambah Struktur
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <form method="GET" action="{{ route('admin.organization-structures.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Organization Type -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Organisasi</label>
                    <select name="organization_type" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent">
                        <option value="">Semua</option>
                        <option value="dpd" {{ request('organization_type') == 'dpd' ? 'selected' : '' }}>DPD</option>
                        <option value="dpc" {{ request('organization_type') == 'dpc' ? 'selected' : '' }}>DPC</option>
                        <option value="dprt" {{ request('organization_type') == 'dprt' ? 'selected' : '' }}>DPRT</option>
                    </select>
                </div>

                <!-- Organization -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Organisasi</label>
                    <select name="organization_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent">
                        <option value="">Semua</option>
                        @if(request('organization_type') == 'dpd')
                        @foreach($dpds as $dpd)
                        <option value="{{ $dpd->id }}" {{ request('organization_id') == $dpd->id ? 'selected' : '' }}>
                            {{ $dpd->name }}
                        </option>
                        @endforeach
                        @elseif(request('organization_type') == 'dpc')
                        @foreach($dpcs as $dpc)
                        <option value="{{ $dpc->id }}" {{ request('organization_id') == $dpc->id ? 'selected' : '' }}>
                            {{ $dpc->kecamatan_name }}
                        </option>
                        @endforeach
                        @elseif(request('organization_type') == 'dprt')
                        @foreach($dprts as $dprt)
                        <option value="{{ $dprt->id }}" {{ request('organization_id') == $dprt->id ? 'selected' : '' }}>
                            {{ $dprt->desa_name }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                    <select name="is_active" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent">
                        <option value="">Semua</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-3">
                    <button type="submit"
                        class="px-4 py-2.5 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition-all-300 w-full">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.organization-structures.index') }}"
                        class="px-4 py-2.5 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition-all-300">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-slate-800">
                        {{ \App\Models\OrganizationStructure::count() }}
                    </div>
                    <div class="text-sm text-slate-600">Total Struktur</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-sitemap text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-slate-800">
                        {{ \App\Models\OrganizationStructure::where('is_active', true)->count() }}
                    </div>
                    <div class="text-sm text-slate-600">Aktif</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-slate-800">
                        {{ \App\Models\OrganizationStructure::where('organization_type', 'dpd')->count() }}
                    </div>
                    <div class="text-sm text-slate-600">Struktur DPD</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                    <i class="fas fa-building text-amber-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-slate-800">
                        {{ \App\Models\OrganizationStructure::whereNotNull('kader_id')->count() }}
                    </div>
                    <div class="text-sm text-slate-600">Terhubung Kader</div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                    <i class="fas fa-user-tie text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Structures Table -->
    <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Organisasi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Posisi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Penjabat</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Periode</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($structures as $structure)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center mr-3 
                                    {{ $structure->organization_type == 'dpd' ? 'bg-blue-100 text-blue-600' : 
                                       ($structure->organization_type == 'dpc' ? 'bg-green-100 text-green-600' : 
                                       'bg-purple-100 text-purple-600') }}">
                                    <i class="fas {{ $structure->organization_type == 'dpd' ? 'fa-building' : 
                                        ($structure->organization_type == 'dpc' ? 'fa-map-marker-alt' : 
                                        'fa-map-pin') }} text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-slate-900">
                                        @if($structure->organization)
                                        {{ $structure->organization_type == 'dpd' ? $structure->organization->name : 
                                               ($structure->organization_type == 'dpc' ? $structure->organization->kecamatan_name : 
                                               $structure->organization->desa_name) }}
                                        @else
                                        <span class="text-red-500">Organisasi tidak ditemukan</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-slate-500 uppercase">
                                        {{ strtoupper($structure->organization_type) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-900">
                                {{ $structure->position->name }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $structure->position->category }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($structure->person_photo)
                                <div class="flex-shrink-0 w-8 h-8 rounded-full mr-3">
                                    <img class="w-8 h-8 rounded-full object-cover"
                                        src="{{ Storage::url($structure->person_photo) }}"
                                        alt="{{ $structure->person_name }}">
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-slate-900">
                                        {{ $structure->person_name }}
                                    </div>
                                    @if($structure->kader)
                                    <div class="text-xs text-slate-500">
                                        <i class="fas fa-user-check mr-1"></i>Kader Terdaftar
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-slate-900">
                                @if($structure->period_start)
                                {{ \Carbon\Carbon::parse($structure->period_start)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($structure->period_end)->format('d/m/Y') }}
                                @else
                                <span class="text-slate-400">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($structure->is_active)
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800">
                                <i class="fas fa-check-circle mr-1"></i>Aktif
                            </span>
                            @else
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>Non-Aktif
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.organization-structures.show', $structure) }}"
                                    class="text-blue-600 hover:text-blue-900" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.organization-structures.edit', $structure) }}"
                                    class="text-amber-600 hover:text-amber-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.organization-structures.toggle-active', $structure) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-slate-600 hover:text-slate-900"
                                        title="{{ $structure->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas {{ $structure->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.organization-structures.destroy', $structure) }}"
                                    method="POST" class="inline"
                                    onsubmit="return confirm('Hapus struktur ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-slate-400">
                                <i class="fas fa-inbox text-4xl mb-4"></i>
                                <p class="text-lg">Belum ada data struktur</p>
                                <p class="text-sm mt-2">Mulai dengan menambahkan struktur organisasi</p>
                                <a href="{{ route('admin.organization-structures.select-organization') }}"
                                    class="mt-4 inline-flex items-center px-4 py-2 bg-accent text-white rounded-lg hover:bg-accent-light transition-colors">
                                    <i class="fas fa-plus mr-2"></i>Tambah Struktur
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($structures->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $structures->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    // Dynamic organization dropdown
    document.querySelector('select[name="organization_type"]').addEventListener('change', function() {
        // Refresh page with new organization type filter
        this.form.submit();
    });
</script>
@endsection