@extends('layouts.admin')

@section('title', 'Manajemen Berita')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Berita</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola berita dan artikel Partai NasDem Bojonegoro</p>
        </div>
        <div>
            <a href="{{ route('admin.berita.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-plus mr-2"></i>Tambah Berita
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div>
                <select class="border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                    <option>Semua Status</option>
                    <option>Published</option>
                    <option>Draft</option>
                    <option>Archived</option>
                </select>
            </div>
            <div>
                <select class="border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                    <option>Semua Kategori</option>
                    @foreach(\App\Models\Berita\BeritaCategory::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <input type="text" 
                       placeholder="Cari berita..." 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
            </div>
            <div>
                <button class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-500">Total Berita</div>
            <div class="text-2xl font-bold text-gray-900">{{ $beritas->total() }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-500">Published</div>
            <div class="text-2xl font-bold text-green-600">{{ $beritas->where('status', 'published')->count() }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-500">Draft</div>
            <div class="text-2xl font-bold text-yellow-600">{{ $beritas->where('status', 'draft')->count() }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-sm text-gray-500">Total Views</div>
            <div class="text-2xl font-bold text-blue-600">{{ number_format($beritas->sum('views')) }}</div>
        </div>
    </div>

    <!-- News Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($beritas as $berita)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($berita->featured_image)
                                <div class="flex-shrink-0 h-10 w-10 mr-3">
                                    <img class="h-10 w-10 rounded object-cover" 
                                         src="{{ asset('storage/' . $berita->featured_image) }}" 
                                         alt="{{ $berita->title }}">
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($berita->title, 50) }}</div>
                                    <div class="text-xs text-gray-500">
                                        @if($berita->is_featured)
                                        <span class="inline-flex items-center text-yellow-600">
                                            <i class="fas fa-star mr-1"></i>Featured
                                        </span>
                                        @endif
                                        @if($berita->is_headline)
                                        <span class="inline-flex items-center text-red-600 ml-2">
                                            <i class="fas fa-bullhorn mr-1"></i>Headline
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full text-white" 
                                  style="background-color: {{ $berita->category->color }}">
                                {{ $berita->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $berita->user->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($berita->status == 'published')
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Published</span>
                            @elseif($berita->status == 'draft')
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Draft</span>
                            @else
                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Archived</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ number_format($berita->views) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $berita->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('news.show', $berita->slug) }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-900" 
                                   title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.berita.edit', $berita) }}" 
                                   class="text-yellow-600 hover:text-yellow-900"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($berita->status != 'published')
                                <form action="{{ route('admin.berita.publish', $berita) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-green-600 hover:text-green-900"
                                            title="Publish"
                                            onclick="return confirm('Publikasikan berita ini?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.berita.destroy', $berita) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900"
                                            title="Hapus"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
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
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t">
            {{ $beritas->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
}

.pagination li {
    margin: 0 2px;
}

.pagination li a,
.pagination li span {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 4px;
    text-decoration: none;
    color: #4b5563;
    background-color: white;
    border: 1px solid #d1d5db;
}

.pagination li.active span {
    background-color: var(--nasdem-red);
    color: white;
    border-color: var(--nasdem-red);
}

.pagination li a:hover {
    background-color: #f3f4f6;
}
</style>
@endpush