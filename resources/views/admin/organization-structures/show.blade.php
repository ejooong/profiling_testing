@extends('layouts.admin')

@section('title', 'Detail Struktur Organisasi')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Detail Struktur Organisasi</h1>
            <p class="text-slate-600 mt-1">{{ $organizationStructure->position->name }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.organization-structures.edit', $organizationStructure) }}"
                class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.organization-structures.index', [
                'organization_type' => $organizationStructure->organization_type,
                'organization_id' => $organizationStructure->organization_id
            ]) }}"
                class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Info Card -->
    <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
        <div class="p-6 space-y-6">
            <!-- Organization Info -->
            <div class="flex items-center p-4 bg-slate-50 rounded-lg">
                <div class="w-12 h-12 rounded-lg {{ 
                    $organizationStructure->organization_type == 'dpd' ? 'bg-blue-100 text-blue-600' : 
                    ($organizationStructure->organization_type == 'dpc' ? 'bg-green-100 text-green-600' : 'bg-purple-100 text-purple-600')
                }} flex items-center justify-center mr-4">
                    <i class="fas {{ 
                        $organizationStructure->organization_type == 'dpd' ? 'fa-building' : 
                        ($organizationStructure->organization_type == 'dpc' ? 'fa-map-marker-alt' : 'fa-map-pin') 
                    }}"></i>
                </div>
                <div>
                    <div class="text-lg font-bold text-slate-800">
                        {{ $organizationStructure->organization->name ?? 
                           $organizationStructure->organization->kecamatan_name ?? 
                           $organizationStructure->organization->desa_name }}
                    </div>
                    <div class="text-sm text-slate-500 uppercase">{{ $organizationStructure->organization_type }}</div>
                </div>
            </div>

            <!-- Position & Person -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Position Card -->
                <div class="p-4 bg-gradient-to-br from-accent/5 to-accent/10 border border-accent/20 rounded-xl">
                    <h3 class="text-sm font-medium text-slate-500 mb-2">Posisi/Jabatan</h3>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-accent/20 flex items-center justify-center mr-3">
                            <i class="fas fa-briefcase text-accent"></i>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-slate-800">{{ $organizationStructure->position->name }}</div>
                            <div class="text-sm text-slate-600">{{ $organizationStructure->position->category }}</div>
                        </div>
                    </div>
                    @if($organizationStructure->position->description)
                    <p class="mt-3 text-sm text-slate-600">{{ $organizationStructure->position->description }}</p>
                    @endif
                </div>

                <!-- Person Card -->
                <div class="p-4 bg-gradient-to-br from-slate-50 to-white border border-slate-200 rounded-xl">
                    <h3 class="text-sm font-medium text-slate-500 mb-2">Penjabat</h3>
                    <div class="flex items-center">
                        @if($organizationStructure->person_photo)
                        <img src="{{ Storage::url($organizationStructure->person_photo) }}"
                            alt="{{ $organizationStructure->person_name }}"
                            class="w-12 h-12 rounded-full object-cover mr-3 border-2 border-white shadow">
                        @else
                        <div class="w-12 h-12 rounded-full bg-slate-200 flex items-center justify-center mr-3">
                            <i class="fas fa-user text-slate-400"></i>
                        </div>
                        @endif
                        <div>
                            <div class="text-lg font-bold text-slate-800">{{ $organizationStructure->person_name }}</div>
                            @if($organizationStructure->kader)
                            <div class="text-sm text-green-600">
                                <i class="fas fa-user-check mr-1"></i>Kader Terdaftar
                            </div>
                            @endif
                        </div>
                    </div>
                    @if($organizationStructure->external_phone || $organizationStructure->external_email)
                    <div class="mt-3 space-y-1">
                        @if($organizationStructure->external_phone)
                        <div class="text-sm text-slate-600">
                            <i class="fas fa-phone mr-2"></i>{{ $organizationStructure->external_phone }}
                        </div>
                        @endif
                        @if($organizationStructure->external_email)
                        <div class="text-sm text-slate-600">
                            <i class="fas fa-envelope mr-2"></i>{{ $organizationStructure->external_email }}
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Period & Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Period Card -->
                <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100/50 border border-blue-200 rounded-xl">
                    <h3 class="text-sm font-medium text-slate-500 mb-2">Periode Jabatan</h3>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                            <i class="fas fa-calendar-alt text-blue-600"></i>
                        </div>
                        <div>
                            @if($organizationStructure->period_start)
                            <div class="text-lg font-bold text-slate-800">
                                {{ \Carbon\Carbon::parse($organizationStructure->period_start)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($organizationStructure->period_end)->format('d/m/Y') }}
                            </div>
                            <div class="text-sm text-blue-600">
                                {{ \Carbon\Carbon::parse($organizationStructure->period_start)->diffInYears(\Carbon\Carbon::parse($organizationStructure->period_end)) }} tahun
                            </div>
                            @else
                            <div class="text-lg font-bold text-slate-800">-</div>
                            <div class="text-sm text-slate-400">Tidak ada periode</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="p-4 bg-gradient-to-br {{ 
                    $organizationStructure->is_active ? 'from-emerald-50 to-emerald-100/50 border-emerald-200' : 
                    'from-red-50 to-red-100/50 border-red-200'
                }} rounded-xl">
                    <h3 class="text-sm font-medium text-slate-500 mb-2">Status</h3>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg {{ 
                                $organizationStructure->is_active ? 'bg-emerald-100 text-emerald-600' : 
                                'bg-red-100 text-red-600'
                            }} flex items-center justify-center mr-3">
                                <i class="fas {{ $organizationStructure->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                            </div>
                            <div>
                                <div class="text-lg font-bold {{ 
                                    $organizationStructure->is_active ? 'text-emerald-700' : 'text-red-700'
                                }}">
                                    {{ $organizationStructure->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </div>
                                <div class="text-sm {{ 
                                    $organizationStructure->is_active ? 'text-emerald-600' : 'text-red-600'
                                }}">
                                    {{ $organizationStructure->is_active ? 'Sedang menjabat' : 'Tidak aktif menjabat' }}
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('admin.organization-structures.toggle-active', $organizationStructure) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-3 py-1 text-sm {{ 
                                $organizationStructure->is_active ? 'bg-red-100 text-red-600 hover:bg-red-200' : 
                                'bg-emerald-100 text-emerald-600 hover:bg-emerald-200'
                            }} rounded-lg">
                                {{ $organizationStructure->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order & Notes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Order -->
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                    <h3 class="text-sm font-medium text-slate-500 mb-2">Urutan Tampil</h3>
                    <div class="text-2xl font-bold text-slate-800">{{ $organizationStructure->order }}</div>
                    <div class="text-sm text-slate-600">Posisi ke-{{ $organizationStructure->order + 1 }} dalam daftar</div>
                </div>

                <!-- Notes -->
                @if($organizationStructure->notes)
                <div class="p-4 bg-gradient-to-br from-amber-50 to-amber-100/50 border border-amber-200 rounded-xl">
                    <h3 class="text-sm font-medium text-slate-500 mb-2">Catatan</h3>
                    <p class="text-slate-700">{{ $organizationStructure->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection