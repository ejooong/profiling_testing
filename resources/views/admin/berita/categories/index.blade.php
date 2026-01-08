@extends('layouts.admin')

@section('title', 'Kategori Berita')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kategori Berita</h1>
            <p class="mt-1 text-sm text-gray-600">Manajemen kategori berita Partai NasDem</p>
        </div>
        <div>
            <a href="{{ route('admin.berita.categories.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-plus mr-2"></i>Tambah Kategori
            </a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-blue-600">{{ $totalCategories }}</div>
            <div class="text-sm text-gray-600">Total Kategori</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-green-600">{{ $activeCategories }}</div>
            <div class="text-sm text-gray-600">Kategori Aktif</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-purple-600">{{ $totalBerita }}</div>
            <div class="text-sm text-gray-600">Total Berita</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-yellow-600">{{ $featuredCategories }}</div>
            <div class="text-sm text-gray-600">Featured</div>
        </div>
    </div>

    <!-- Categories List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($categories->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Deskripsi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statistik
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
                    @foreach($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 {{ $category->color ?? 'bg-blue-100' }} rounded-full flex items-center justify-center mr-3">
                                    <i class="fas {{ $category->icon ?? 'fa-newspaper' }} {{ $category->color_text ?? 'text-blue-600' }}"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $category->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $category->slug }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ Str::limit($category->description, 60) }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="text-gray-900 font-medium">{{ $category->berita_count }} berita</div>
                                <div class="text-xs text-gray-500">
                                    @if($category->featured_berita_count > 0)
                                    {{ $category->featured_berita_count }} featured
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 text-gray-800 rounded-full text-sm font-bold">
                                    {{ $category->order }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($category->is_active)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Non-Aktif
                            </span>
                            @endif
                            
                            @if($category->is_featured)
                            <div class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Featured
                                </span>
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.berita.index', ['category' => $category->id]) }}" 
                                   class="text-blue-600 hover:text-blue-900"
                                   title="Lihat Berita">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.berita.categories.edit', $category) }}" 
                                   class="text-yellow-600 hover:text-yellow-900"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($category->berita_count == 0)
                                <form action="{{ route('admin.berita.categories.destroy', $category) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                <span class="text-gray-400 cursor-not-allowed" title="Tidak dapat dihapus karena ada berita">
                                    <i class="fas fa-trash"></i>
                                </span>
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
            {{ $categories->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="p-12 text-center">
            <i class="fas fa-tags text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Belum ada kategori berita</h3>
            <p class="text-gray-600 mb-6">Silakan tambahkan kategori terlebih dahulu.</p>
            <a href="{{ route('admin.berita.categories.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700">
                <i class="fas fa-plus mr-2"></i>Tambah Kategori
            </a>
        </div>
        @endif
    </div>

    <!-- Category Colors Legend -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Legenda Warna Kategori</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
            <div class="flex items-center">
                <div class="w-6 h-6 bg-blue-100 rounded-full mr-2"></div>
                <span class="text-sm text-gray-600">Politik</span>
            </div>
            <div class="flex items-center">
                <div class="w-6 h-6 bg-red-100 rounded-full mr-2"></div>
                <span class="text-sm text-gray-600">Berita</span>
            </div>
            <div class="flex items-center">
                <div class="w-6 h-6 bg-green-100 rounded-full mr-2"></div>
                <span class="text-sm text-gray-600">Organisasi</span>
            </div>
            <div class="flex items-center">
                <div class="w-6 h-6 bg-yellow-100 rounded-full mr-2"></div>
                <span class="text-sm text-gray-600">Kegiatan</span>
            </div>
            <div class="flex items-center">
                <div class="w-6 h-6 bg-purple-100 rounded-full mr-2"></div>
                <span class="text-sm text-gray-600">Pengumuman</span>
            </div>
            <div class="flex items-center">
                <div class="w-6 h-6 bg-pink-100 rounded-full mr-2"></div>
                <span class="text-sm text-gray-600">Lainnya</span>
            </div>
        </div>
    </div>
</div>
@endsection