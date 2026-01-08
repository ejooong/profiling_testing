@extends('layouts.admin')

@section('title', 'Struktur DPC: ' . $dpc->kecamatan_name)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Struktur DPC {{ $dpc->kecamatan_name }}</h1>
            <p class="mt-1 text-sm text-gray-600">Manajemen struktur kepengurusan DPC</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.dpc.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <a href="{{ route('admin.dpc.structure.edit', $dpc) }}" 
               class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-plus mr-2"></i>Tambah Struktur
            </a>
        </div>
    </div>
    
    <!-- Tampilkan struktur di sini -->
    @if($structures->count() > 0)
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-2xl font-bold text-blue-600">{{ $structures->where('level', 'pengurus')->count() }}</div>
                <div class="text-sm text-gray-600">Pengurus</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-2xl font-bold text-green-600">{{ $structures->where('level', 'bpo')->count() }}</div>
                <div class="text-sm text-gray-600">BPO</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-2xl font-bold text-purple-600">{{ $structures->where('level', 'departemen')->count() }}</div>
                <div class="text-sm text-gray-600">Departemen</div>
            </div>
        </div>
    
        <!-- Tabel struktur -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jabatan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pejabat
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Level
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Urutan
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
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $structure->position_name }}</div>
                                @if($structure->responsibilities)
                                <div class="text-xs text-gray-500 mt-1">{{ Str::limit($structure->responsibilities, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $structure->person_name }}</div>
                                <div class="text-xs text-gray-500">
                                    @if($structure->phone) {{ $structure->phone }} @endif
                                    @if($structure->email) | {{ $structure->email }} @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $levelColors = [
                                        'pengurus' => 'bg-blue-100 text-blue-800',
                                        'bpo' => 'bg-yellow-100 text-yellow-800',
                                        'departemen' => 'bg-purple-100 text-purple-800'
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $levelColors[$structure->level] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($structure->level) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $structure->order }}</div>
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
                                    <a href="{{ route('admin.dpc.structure.edit', [$dpc, $structure]) }}" 
                                       class="text-yellow-600 hover:text-yellow-900"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.dpc.structure.destroy', [$dpc, $structure]) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus struktur ini?')">
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
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-users text-gray-300 text-5xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada struktur</h3>
            <p class="text-gray-600 mb-4">Silakan tambahkan struktur kepengurusan DPC</p>
            <a href="{{ route('admin.dpc.structure.edit', $dpc) }}" 
               class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-plus mr-2"></i>Tambah Struktur
            </a>
        </div>
    @endif
</div>
@endsection