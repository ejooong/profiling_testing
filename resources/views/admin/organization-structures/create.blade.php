@extends('layouts.admin')

@section('title', 'Tambah Struktur Organisasi')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Struktur Organisasi</h1>
            <p class="text-slate-600 mt-1">{{ $organization->name ?? $organization->kecamatan_name ?? $organization->desa_name }}</p>
        </div>
        <a href="{{ route('admin.organization-structures.index', [
            'organization_type' => request('organization_type'),
            'organization_id' => request('organization_id')
        ]) }}"
            class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
        <form action="{{ route('admin.organization-structures.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="organization_type" value="{{ request('organization_type') }}">
            <input type="hidden" name="organization_id" value="{{ request('organization_id') }}">

            <div class="space-y-6">
                <!-- Position Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-slate-700">Posisi/Jabatan *</label>
                    <select name="position_id" required class="w-full border border-slate-300 rounded-lg px-4 py-2.5">
                        <option value="">Pilih Posisi</option>
                        @foreach($positions as $category => $positionGroup)
                        <optgroup label="{{ ucfirst($category) }}">
                            @foreach($positionGroup as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                </div>

                <!-- Person Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-slate-700">Penjabat</label>
                    <div class="space-y-4">
                        <!-- Select from Kader -->
                        <div class="space-y-2">
                            <label class="text-sm text-slate-600">Pilih dari Kader Terdaftar:</label>
                            <select name="kader_id" class="w-full border border-slate-300 rounded-lg px-4 py-2.5">
                                <option value="">-- Pilih Kader --</option>
                                @foreach($kaders as $kader)
                                <option value="{{ $kader->id }}">{{ $kader->name }} ({{ $kader->nik }})</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-500 mt-1">Atau isi manual di bawah jika bukan kader</p>
                        </div>

                        <!-- Manual Input -->
                        <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <h4 class="text-sm font-medium text-slate-700 mb-3">Data Manual</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-slate-600 mb-1">Nama Lengkap</label>
                                    <input type="text" name="external_name" class="w-full border border-slate-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm text-slate-600 mb-1">Foto</label>
                                    <input type="file" name="external_photo" accept="image/*" class="w-full">
                                </div>
                                <div>
                                    <label class="block text-sm text-slate-600 mb-1">Telepon</label>
                                    <input type="text" name="external_phone" class="w-full border border-slate-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm text-slate-600 mb-1">Email</label>
                                    <input type="email" name="external_email" class="w-full border border-slate-300 rounded-lg px-3 py-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Period -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Periode Mulai</label>
                        <input type="date" name="period_start" class="w-full border border-slate-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Periode Selesai</label>
                        <input type="date" name="period_end" class="w-full border border-slate-300 rounded-lg px-3 py-2">
                    </div>
                </div>

                <!-- Order & Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Urutan Tampil *</label>
                        <input type="number" name="order" required min="0" value="0" class="w-full border border-slate-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300">
                                <span class="ml-2 text-slate-600">Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Catatan</label>
                    <textarea name="notes" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-200">
                    <button type="submit" class="px-6 py-3 bg-accent text-white rounded-lg hover:bg-accent-light">
                        <i class="fas fa-save mr-2"></i>Simpan Struktur
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection