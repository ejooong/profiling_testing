@extends('layouts.front')

@section('title', $category->name . ' - Berita Partai NasDem')

@section('content')
<!-- Hero Section -->
<section class="nasdem-gradient py-16 md:py-20 full-width relative overflow-hidden">
    <div class="px-4 sm:px-6 lg:px-8 mx-auto relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="flex items-center justify-center mb-6">
                <div class="w-16 h-16 {{ $category->color ?? 'bg-red-100' }} rounded-full flex items-center justify-center mr-4">
                    <i class="fas {{ $category->icon ?? 'fa-newspaper' }} {{ $category->color_text ?? 'text-red-600' }} text-2xl"></i>
                </div>
                <div class="text-left">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-2">{{ $category->name }}</h1>
                    <p class="text-xl text-gray-200">{{ $category->description }}</p>
                </div>
            </div>
            
            <div class="inline-flex items-center px-6 py-3 bg-white/10 backdrop-blur-sm rounded-full">
                <i class="fas fa-newspaper mr-3 text-white"></i>
                <span class="text-white font-medium">{{ $news->total() }} Berita dalam Kategori Ini</span>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="full-width bg-gradient-to-r from-[#E69D00] to-[#E69D00] py-12 md:py-16">
    <div class="px-4 sm:px-6 lg:px-8 mx-auto">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-red-600">
                            <i class="fas fa-home mr-2"></i>Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="{{ route('news.index') }}" class="text-gray-600 hover:text-red-600">Berita</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-red-600 font-medium">{{ $category->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 xl:gap-12">
            <!-- News List -->
            <div class="lg:w-2/3">
                @if($news->count() > 0)
                <div id="news-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    @foreach($news as $item)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover-card group">
                        <div class="relative h-56 md:h-60 overflow-hidden">
                            @if($item->featured_image)
                            <img src="{{ asset('storage/' . $item->featured_image) }}" 
                                 alt="{{ $item->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                            <div class="w-full h-full bg-gradient-to-r from-gray-100 to-gray-200 flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-newspaper text-gray-400 text-5xl mb-3"></i>
                                    <p class="text-gray-500 text-sm">Tidak ada gambar</p>
                                </div>
                            </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-red-600 text-white text-xs font-bold rounded-full">
                                    {{ $category->name }}
                                </span>
                            </div>
                            @if($item->is_featured)
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full">
                                    <i class="fas fa-star mr-1"></i>Featured
                                </span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="p-5 md:p-6">
                            <div class="flex items-center text-gray-500 text-sm mb-3">
                                <i class="fas fa-calendar-alt mr-2 text-red-600"></i>
                                <span>{{ $item->published_at->format('d M Y') }}</span>
                                <i class="fas fa-eye ml-4 mr-2 text-red-600"></i>
                                <span>{{ $item->views }} views</span>
                            </div>
                            
                            <h3 class="font-bold text-xl text-gray-900 mb-3 hover:text-red-600 transition duration-300">
                                <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                            </h3>
                            
                            <p class="text-gray-600 mb-4 line-clamp-2">{{ $item->excerpt }}</p>
                            
                            <a href="{{ route('news.show', $item->slug) }}" 
                               class="inline-flex items-center text-red-600 font-medium hover:text-red-700">
                                Baca Selengkapnya
                                <i class="fas fa-arrow-right ml-2 text-xs transform group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-12">
                    {{ $news->links() }}
                </div>
                @else
                <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                    <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-newspaper text-gray-300 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum ada berita</h3>
                    <p class="text-gray-600 mb-8">Tidak ada berita yang tersedia untuk kategori ini.</p>
                    <a href="{{ route('news.index') }}" class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Semua Berita
                    </a>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3">
                <!-- Category Info -->
                <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Tentang Kategori</h3>
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 {{ $category->color ?? 'bg-red-100' }} rounded-full flex items-center justify-center mr-4">
                            <i class="fas {{ $category->icon ?? 'fa-newspaper' }} {{ $category->color_text ?? 'text-red-600' }}"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $category->name }}</h4>
                            <p class="text-gray-600 text-sm">{{ $category->description }}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-red-600 mb-1">{{ $news->total() }}</div>
                            <div class="text-gray-600">Total Berita</div>
                        </div>
                    </div>
                </div>

                <!-- Other Categories -->
                <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Kategori Lainnya</h3>
                    <div class="space-y-3">
                        @foreach($categories as $cat)
                            @if($cat->id != $category->id)
                            <a href="{{ route('news.category', $cat->slug) }}" 
                               class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition duration-300">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $cat->color ?? '#ef4444' }}"></div>
                                    <span class="text-gray-700">{{ $cat->name }}</span>
                                </div>
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                    {{ $cat->beritas_count ?? 0 }}
                                </span>
                            </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Back to All News -->
                <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-2xl shadow-xl p-6 text-white">
                    <div class="text-center">
                        <i class="fas fa-layer-group text-3xl mb-4"></i>
                        <h3 class="text-xl font-bold mb-2">Lihat Semua Berita</h3>
                        <p class="text-red-100 mb-6">Telusuri semua berita dari berbagai kategori</p>
                        <a href="{{ route('news.index') }}" class="inline-flex items-center bg-white text-red-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-100">
                            <i class="fas fa-newspaper mr-2"></i>Semua Berita
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
.hover-card {
    transition: all 0.3s ease;
    border-bottom: 3px solid transparent;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    border-bottom: 3px solid #e31b23;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush