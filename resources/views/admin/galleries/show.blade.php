@extends('layouts.admin')

@section('title', 'Detail Gallery')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Detail Gallery</h1>
            <p class="text-slate-600 mt-1">Detail album foto kegiatan</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.galleries.edit', $gallery) }}"
                class="inline-flex items-center px-4 py-2 bg-accent text-white rounded-lg font-medium hover:bg-accent-light transition-all-300">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.galleries.index') }}"
                class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-lg font-medium hover:bg-slate-200 transition-all-300">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Gallery Info -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <h2 class="text-lg font-semibold text-slate-800 mb-2">{{ $gallery->title }}</h2>
                <div class="flex items-center gap-4 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $gallery->category_color }}">
                        {{ $gallery->category_label }}
                    </span>
                    <span class="text-slate-600">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        {{ $gallery->event_date instanceof \Carbon\Carbon ? $gallery->event_date->format('d F Y') : $gallery->event_date }}
                    </span>
                    <span class="text-slate-600">
                        <i class="fas fa-eye mr-1"></i>
                        {{ number_format($gallery->views) }} views
                    </span>
                </div>

                @if($gallery->description)
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-slate-700 mb-2">Deskripsi</h3>
                    <p class="text-slate-600">{{ $gallery->description }}</p>
                </div>
                @endif

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @if($gallery->location)
                    <div>
                        <h3 class="text-sm font-medium text-slate-700 mb-1">Lokasi</h3>
                        <p class="text-slate-600">{{ $gallery->location }}</p>
                    </div>
                    @endif

                    @if($gallery->event_time)
                    <div>
                        <h3 class="text-sm font-medium text-slate-700 mb-1">Waktu</h3>
                        <p class="text-slate-600">{{ $gallery->event_time }}</p>
                    </div>
                    @endif

                    @if($gallery->participant_count)
                    <div>
                        <h3 class="text-sm font-medium text-slate-700 mb-1">Peserta</h3>
                        <p class="text-slate-600">{{ number_format($gallery->participant_count) }} orang</p>
                    </div>
                    @endif

                    <div>
                        <h3 class="text-sm font-medium text-slate-700 mb-1">Status</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $gallery->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $gallery->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-slate-700 mb-3">Informasi Teknis</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-600 text-sm">ID Gallery</span>
                            <span class="text-slate-900 font-medium">{{ $gallery->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600 text-sm">Slug</span>
                            <span class="text-slate-900 font-medium">{{ $gallery->slug }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600 text-sm">Dibuat</span>
                            <span class="text-slate-900 font-medium">{{ $gallery->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600 text-sm">Diupdate</span>
                            <span class="text-slate-900 font-medium">{{ $gallery->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Images -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-800">Foto Gallery</h2>
                <span class="text-slate-600">{{ $gallery->images->count() }} foto</span>
            </div>
        </div>

        <div class="p-6">
            @if($gallery->images->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($gallery->images as $image)
                <div class="relative group bg-white rounded-lg overflow-hidden shadow-sm border border-slate-200">
                    <div class="relative aspect-square">
                        <img src="{{ Storage::url($image->image_path) }}"
                            alt="{{ $image->caption ?: $gallery->title }}"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <a href="{{ Storage::url($image->image_path) }}" target="_blank"
                                class="text-white hover:text-blue-300 p-2 mr-2">
                                <i class="fas fa-expand text-xl"></i>
                            </a>
                        </div>
                    </div>
                    @if($image->caption)
                    <div class="p-3">
                        <p class="text-xs text-slate-600">{{ $image->caption }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <i class="fas fa-images text-4xl text-slate-300 mb-4"></i>
                <p class="text-slate-500">Belum ada foto di gallery ini</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection