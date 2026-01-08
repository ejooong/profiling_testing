@extends('layouts.admin')

@section('title', 'Manajemen Gallery')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Gallery</h1>
            <p class="text-slate-600 mt-1">Kelola album foto kegiatan Partai NasDem</p>
        </div>
        <a href="{{ route('admin.galleries.create') }}"
            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-accent to-accent-light text-white rounded-lg font-medium hover:opacity-90 transition-all-300 shadow-lg hover:shadow-xl">
            <i class="fas fa-plus mr-2"></i>Tambah Gallery
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card-hover bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Total Gallery</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $galleries->total() }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-images text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card-hover bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Gallery Aktif</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">
                        {{ \App\Models\Gallery::where('is_published', true)->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fas fa-eye text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="card-hover bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Total Foto</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">
                        {{ \App\Models\GalleryImage::count() }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                    <i class="fas fa-photo-video text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex-1">
                    <div class="relative max-w-xs">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-slate-400"></i>
                        </div>
                        <input type="text" id="search-input"
                            placeholder="Cari gallery..."
                            class="pl-10 pr-4 py-2 w-full bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent">
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <select id="category-filter"
                        class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        <option value="pelantikan">Pelantikan</option>
                        <option value="sosial">Bakti Sosial</option>
                        <option value="rapat">Rapat Kerja</option>
                        <option value="kunjungan">Kunjungan</option>
                        <option value="pelatihan">Pelatihan</option>
                        <option value="kerjasama">Kerjasama</option>
                        <option value="lainnya">Lainnya</option>
                    </select>

                    <select id="status-filter"
                        class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Gallery</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Views</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($galleries as $gallery)
                    <tr class="hover:bg-slate-50 transition-colors" data-category="{{ $gallery->category }}"
                        data-status="{{ $gallery->is_published ? 'published' : 'draft' }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if($gallery->featured_image)
                                    <img src="{{ Storage::url($gallery->featured_image->image_path) }}"
                                        alt="{{ $gallery->title }}"
                                        class="w-16 h-16 object-cover rounded-lg shadow-sm">
                                    @else
                                    <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-images text-slate-400 text-xl"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900 truncate">
                                        {{ $gallery->title }}
                                    </p>
                                    <p class="text-xs text-slate-500 truncate mt-1">
                                        {{ $gallery->location }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $gallery->category_color }}">
                                {{ $gallery->category_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                            {{ $gallery->event_date->translatedFormat('d M Y') }}
                            @if($gallery->event_time)
                            <br>
                            <span class="text-xs text-slate-500">{{ $gallery->event_time }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center text-sm text-slate-900">
                                <i class="fas fa-images mr-1.5 text-slate-400"></i>
                                {{ $gallery->images_count }} foto
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button onclick="togglePublish({{ $gallery->id }})"
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors 
                                           {{ $gallery->is_published 
                                                ? 'bg-green-100 text-green-800 hover:bg-green-200' 
                                                : 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' }}">
                                <span class="w-2 h-2 rounded-full mr-1.5 {{ $gallery->is_published ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                                {{ $gallery->is_published ? 'Published' : 'Draft' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                            <div class="flex items-center">
                                <i class="fas fa-eye mr-1.5 text-slate-400"></i>
                                {{ number_format($gallery->views) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('gallery.show', $gallery->slug) }}" target="_blank"
                                    class="text-slate-400 hover:text-slate-600 transition-colors p-1.5"
                                    title="Lihat">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="{{ route('admin.galleries.show', $gallery) }}"
                                    class="text-blue-600 hover:text-blue-800 transition-colors p-1.5"
                                    title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.galleries.edit', $gallery) }}"
                                    class="text-accent hover:text-accent-light transition-colors p-1.5"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.galleries.destroy', $gallery) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus gallery ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 transition-colors p-1.5"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="text-slate-400">
                                <i class="fas fa-images text-4xl mb-4"></i>
                                <p class="text-lg font-medium text-slate-500">Belum ada gallery</p>
                                <p class="text-sm text-slate-400 mt-1">Mulai dengan membuat gallery pertama Anda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $galleries->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePublish(galleryId) {
        if (!confirm('Apakah Anda yakin ingin mengubah status publish?')) {
            return;
        }

        fetch(`/admin/galleries/${galleryId}/toggle-publish`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                }
            })
            .catch(error => {
                alert('Terjadi kesalahan');
            });
    }

    // Filter table
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const categoryFilter = document.getElementById('category-filter');
        const statusFilter = document.getElementById('status-filter');
        const rows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const category = categoryFilter.value;
            const status = statusFilter.value;

            rows.forEach(row => {
                const title = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const rowCategory = row.dataset.category;
                const rowStatus = row.dataset.status;

                const matchesSearch = title.includes(searchTerm);
                const matchesCategory = !category || rowCategory === category;
                const matchesStatus = !status || rowStatus === status;

                row.style.display = matchesSearch && matchesCategory && matchesStatus ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        categoryFilter.addEventListener('change', filterTable);
        statusFilter.addEventListener('change', filterTable);
    });
</script>
@endpush