@props(['news', 'size' => 'medium'])

@php
    $classes = [
        'small' => 'col-span-1',
        'medium' => 'col-span-1 md:col-span-2',
        'large' => 'col-span-1 md:col-span-3',
    ];
@endphp

<div class="{{ $classes[$size] ?? 'col-span-1' }} bg-white rounded-lg shadow-md overflow-hidden news-card">
    <div class="relative">
        @if($news->featured_image)
        <img src="{{ asset('storage/' . $news->featured_image) }}" 
             alt="{{ $news->title }}" 
             class="w-full h-48 object-cover">
        @else
        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
            <i class="fas fa-newspaper text-gray-400 text-4xl"></i>
        </div>
        @endif
        <div class="absolute top-3 left-3">
            <span class="text-white text-xs font-bold px-2 py-1 rounded" 
                  style="background-color: {{ $news->category->color }}">
                {{ $news->category->name }}
            </span>
        </div>
    </div>
    
    <div class="p-5">
        <div class="flex items-center text-gray-500 text-sm mb-3">
            <i class="fas fa-calendar-alt mr-2"></i>
            <span>{{ $news->published_at->format('d M Y') }}</span>
            <span class="mx-2">•</span>
            <i class="fas fa-eye mr-2"></i>
            <span>{{ $news->views }}</span>
        </div>
        
        <h3 class="font-bold text-lg text-nasdem-navy mb-3 hover:text-nasdem-red transition duration-300">
            <a href="{{ route('news.show', $news->slug) }}">{{ Str::limit($news->title, 70) }}</a>
        </h3>
        
        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($news->excerpt, 120) }}</p>
        
        <div class="flex justify-between items-center">
            <a href="{{ route('news.show', $news->slug) }}" 
               class="text-nasdem-red font-medium text-sm hover:underline inline-flex items-center">
                Baca Selengkapnya <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
            
            @if($news->is_featured)
            <span class="text-xs font-medium bg-yellow-100 text-yellow-800 px-2 py-1 rounded">
                <i class="fas fa-star mr-1"></i>Featured
            </span>
            @endif
        </div>
    </div>
</div>