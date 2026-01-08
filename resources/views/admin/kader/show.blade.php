@extends('layouts.admin')

@section('title', 'Detail Kader: ' . $kader->full_name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Kader</h1>
            <p class="mt-1 text-sm text-gray-600">{{ $kader->full_name }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.kader.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <a href="{{ route('admin.kader.edit', $kader) }}"
                class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Personal Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Kader Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b bg-purple-50">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">Informasi Pribadi</h2>
                        <div class="flex items-center space-x-2">
                            @if($kader->status == 'active')
                            <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">
                                <i class="fas fa-check-circle mr-1"></i>Aktif
                            </span>
                            @elseif($kader->status == 'pending')
                            <span class="px-3 py-1 text-sm font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                <i class="fas fa-clock mr-1"></i>Pending
                            </span>
                            @else
                            <span class="px-3 py-1 text-sm font-medium bg-red-100 text-red-800 rounded-full">
                                <i class="fas fa-times-circle mr-1"></i>Ditolak
                            </span>
                            @endif

                            @if($kader->is_verified)
                            <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-full">
                                <i class="fas fa-shield-alt mr-1"></i>Terverifikasi
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-start gap-6">
                        <!-- Photo -->
                        <div class="md:w-1/3">
                            <div class="w-48 h-48 mx-auto md:mx-0 rounded-full overflow-hidden border-4 border-nasdem-red">
                                @if($kader->photo_path)
                                <img src="{{ Storage::url($kader->photo_path) }}"
                                    alt="{{ $kader->full_name }}"
                                    class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400 text-6xl"></i>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="md:w-2/3">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm text-gray-500">Nama Lengkap</span>
                                        <p class="font-medium text-gray-900">{{ $kader->full_name }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">NIK</span>
                                        <p class="font-medium text-gray-900">{{ $kader->nik }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Email</span>
                                        <p class="text-gray-900">{{ $kader->email }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Telepon</span>
                                        <p class="text-gray-900">{{ $kader->phone }}</p>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm text-gray-500">Tempat/Tanggal Lahir</span>
                                        <p class="text-gray-900">{{ $kader->place_of_birth }}, {{ \Carbon\Carbon::parse($kader->date_of_birth)->format('d/m/Y') }}</p>
                                        <p class="text-xs text-gray-500">Usia: {{ \Carbon\Carbon::parse($kader->date_of_birth)->age }} tahun</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Jenis Kelamin</span>
                                        <p class="text-gray-900">{{ $kader->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Pendidikan Terakhir</span>
                                        <p class="text-gray-900">
                                            @php
                                            $educationLabels = [
                                            'sd' => 'SD',
                                            'smp' => 'SMP',
                                            'sma' => 'SMA/SMK',
                                            'd1' => 'D1',
                                            'd2' => 'D2',
                                            'd3' => 'D3',
                                            's1' => 'S1/D4',
                                            's2' => 'S2',
                                            's3' => 'S3',
                                            ];
                                            @endphp
                                            {{ $educationLabels[$kader->education] ?? 'Tidak disebutkan' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="mt-6">
                                <span class="text-sm text-gray-500">Alamat</span>
                                <p class="text-gray-900">{{ $kader->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Organization Info -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-xl font-bold text-gray-900">Keanggotaan Organisasi</h2>
                </div>

                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Hierarchy -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-building text-red-600"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium">{{ $kader->dpd->name ?? 'DPD Kabupaten Bojonegoro' }}</span>
                                        <p class="text-sm text-gray-600">DPD</p>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>

                            <div class="flex items-center justify-between mb-3 ml-8">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium">{{ $kader->dpc->kecamatan_name ?? 'Belum ditentukan' }}</span>
                                        <p class="text-sm text-gray-600">DPC</p>
                                    </div>
                                </div>
                                @if($kader->dprt)
                                <i class="fas fa-chevron-down text-gray-400"></i>
                                @endif
                            </div>

                            @if($kader->dprt)
                            <div class="flex items-center ml-16">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-map-pin text-green-600"></i>
                                </div>
                                <div>
                                    <span class="font-medium">{{ $kader->dprt->desa_name }}</span>
                                    <p class="text-sm text-gray-600">DPRT</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Position & Skills -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($kader->position)
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Jabatan di Partai</h4>
                                <div class="bg-yellow-50 p-3 rounded-lg">
                                    <p class="text-gray-900">{{ $kader->position }}</p>
                                </div>
                            </div>
                            @endif

                            @if($kader->skills)
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Keahlian</h4>
                                <div class="bg-blue-50 p-3 rounded-lg">
                                    <p class="text-gray-900">{{ $kader->skills }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Notes -->
                        @if($kader->notes)
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Catatan</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-700">{{ $kader->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Actions & Timeline -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>

                @if($kader->status == 'pending')
                <div class="space-y-3 mb-4">
                    <form action="{{ route('admin.kader.verify', $kader) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="active">
                        <button type="submit"
                            class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            <i class="fas fa-check mr-2"></i>Verifikasi sebagai Aktif
                        </button>
                    </form>

                    <form action="{{ route('admin.kader.verify', $kader) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit"
                            class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                            onclick="return confirm('Tolak kader ini?')">
                            <i class="fas fa-times mr-2"></i>Tolak Kader
                        </button>
                    </form>
                </div>
                @endif

                <div class="space-y-2">
                    <a href="{{ route('admin.kader.print-card', $kader) }}"
                        target="_blank"
                        class="block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-center">
                        <i class="fas fa-id-card mr-2"></i>Cetak Kartu Anggota
                    </a>

                    <a href="mailto:{{ $kader->email }}"
                        class="block px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 text-center">
                        <i class="fas fa-envelope mr-2"></i>Kirim Email
                    </a>

                    <a href="https://wa.me/{{ $kader->phone }}"
                        target="_blank"
                        class="block px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 text-center">
                        <i class="fab fa-whatsapp mr-2"></i>Chat WhatsApp
                    </a>
                </div>
            </div>

            <!-- Kader Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kader</h3>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID Kader</span>
                        <span class="font-bold">KDR-{{ str_pad($kader->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal Registrasi</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($kader->registration_date)->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal Bergabung</span>
                        <span class="font-medium">{{ $kader->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status Aktif</span>
                        @if($kader->is_active)
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                            Aktif
                        </span>
                        @else
                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                            Non-Aktif
                        </span>
                        @endif
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Terakhir Diperbarui</span>
                        <span class="text-sm">{{ $kader->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($kader->deleted_at)
                    <div class="flex justify-between">
                        <span class="text-red-600">Dihapus pada</span>
                        <span class="text-red-600">{{ $kader->deleted_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Status Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Status & Aksi</h3>

                @if($kader->deleted_at)
                <div class="mb-4 p-3 bg-red-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-trash text-red-500 mr-2"></i>
                        <span class="text-red-700">Kader ini telah dihapus</span>
                    </div>
                    <form action="{{ route('admin.kader.restore', $kader) }}" method="POST" class="mt-3">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            <i class="fas fa-undo mr-2"></i>Pulihkan Kader
                        </button>
                    </form>
                </div>
                @else
                <div class="space-y-3">
                    <!-- Toggle Verification -->
                    <form action="{{ route('admin.kader.toggle-verification', $kader) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="w-full px-4 py-2 {{ $kader->is_verified ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white rounded-md">
                            <i class="fas {{ $kader->is_verified ? 'fa-times' : 'fa-check' }} mr-2"></i>
                            {{ $kader->is_verified ? 'Batalkan Verifikasi' : 'Verifikasi Kader' }}
                        </button>
                    </form>

                    <!-- Toggle Active Status -->
                    <form action="{{ route('admin.kader.toggle-active', $kader) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="w-full px-4 py-2 {{ $kader->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-md">
                            <i class="fas {{ $kader->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }} mr-2"></i>
                            {{ $kader->is_active ? 'Non-aktifkan Kader' : 'Aktifkan Kader' }}
                        </button>
                    </form>

                    <!-- Delete -->
                    <form action="{{ route('admin.kader.destroy', $kader) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kader ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            <i class="fas fa-trash mr-2"></i>Hapus Kader
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <!-- Quick Statistics -->
            <!-- Quick Statistics -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center bg-blue-50 p-3 rounded-lg">
                        <div class="text-xl font-bold text-blue-600">
                            {{ $kader->created_at->startOfDay()->diffInDays(now()->startOfDay()) }}
                        </div>
                        <div class="text-xs text-gray-600">Hari Bergabung</div>
                    </div>
                    <div class="text-center bg-green-50 p-3 rounded-lg">
                        <div class="text-xl font-bold text-green-600">
                            {{ $kader->status == 'active' ? 'Ya' : 'Tidak' }}
                        </div>
                        <div class="text-xs text-gray-600">Status Aktif</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection