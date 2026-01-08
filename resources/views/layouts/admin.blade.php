<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Panel - NasDem Bojonegoro">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Panel' }} - NasDem Bojonegoro</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tambahkan konfigurasi Tailwind untuk disable warning -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'nasdem-red': '#dc2626',
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --primary-dark: #1e293b;
            /* slate-800 */
            --primary: #334155;
            /* slate-700 */
            --primary-light: #475569;
            /* slate-600 */
            --accent: #0ea5e9;
            /* sky-500 */
            --accent-light: #38bdf8;
            /* sky-400 */
            --success: #10b981;
            /* emerald-500 */
            --warning: #f59e0b;
            /* amber-500 */
            --danger: #ef4444;
            /* red-500 */
            --sidebar-width: 16rem;
            --header-height: 4rem;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Smooth transitions */
        .transition-all-200 {
            transition: all 200ms ease-in-out;
        }

        .transition-all-300 {
            transition: all 300ms ease-in-out;
        }

        /* Sidebar link hover effect */
        .sidebar-link {
            position: relative;
            overflow: hidden;
        }

        .sidebar-link::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(14, 165, 233, 0.1), transparent);
            transition: left 0.5s;
        }

        .sidebar-link:hover::after {
            left: 100%;
        }

        /* Glow effect for active items */
        .active-glow {
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }

        /* Card hover effects */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Loading animation */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Notification badge */
        .notification-badge {
            animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        @keyframes ping {

            75%,
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="h-full bg-slate-50" x-data="{ sidebarOpen: false }">
    <!-- Notification Toast Container (fixed top right) -->
    <div class="fixed top-4 right-4 z-50 space-y-2 max-w-sm" id="notification-container"></div>

    <!-- Loading Overlay -->
    <div id="global-loader" class="fixed inset-0 bg-white/80 backdrop-blur-sm z-[60] hidden">
        <div class="flex items-center justify-center h-full">
            <div class="text-center">
                <div class="w-16 h-16 border-4 border-slate-200 border-t-accent rounded-full animate-spin mx-auto"></div>
                <p class="mt-4 text-slate-600 font-medium">Loading...</p>
            </div>
        </div>
    </div>

    <div class="flex h-full">
        <!-- Mobile sidebar backdrop -->
        <div x-show="sidebarOpen"
            x-transition.opacity
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 lg:hidden z-40">
        </div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed lg:static inset-y-0 left-0 z-40 w-64 transform transition-transform duration-300 ease-in-out bg-slate-800 text-white shadow-xl lg:shadow-none lg:flex lg:flex-col lg:inset-0">

            <!-- Logo Header -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-slate-700/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-accent to-accent-light flex items-center justify-center shadow-lg">
                        <i class="fas fa-shield-alt text-white"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg tracking-tight">NasDem Admin</h1>
                        <p class="text-xs text-slate-300">Bojonegoro</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-300 hover:text-white">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- User Profile -->
            <div class="px-4 py-5 border-b border-slate-700/50">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-slate-600 to-slate-700 flex items-center justify-center text-white text-lg font-bold shadow-inner">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-success rounded-full border-2 border-slate-800"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium truncate">{{ auth()->user()->name }}</p>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach(auth()->user()->roles as $role)
                            <span class="px-2 py-0.5 bg-slate-700/50 text-slate-300 text-xs rounded-full border border-slate-600">
                                {{ $role->name }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="group sidebar-link flex items-center px-3 py-3 rounded-lg transition-all-300 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-700/30 active-glow' : 'hover:bg-slate-700/20' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.dashboard') ? 'bg-accent/20 text-accent' : 'bg-slate-700/50 text-slate-300 group-hover:bg-accent/10 group-hover:text-accent' }}">
                        <i class="fas fa-chart-pie text-sm"></i>
                    </div>
                    <span class="font-medium">Dashboard</span>
                    @if(request()->routeIs('admin.dashboard'))
                    <div class="ml-auto w-2 h-2 rounded-full bg-accent animate-pulse"></div>
                    @endif
                </a>

                <!-- Organization -->
                @canany(['view-dpd', 'create-dpd', 'edit-dpd', 'view-dpc', 'create-dpc', 'edit-dpc', 'view-dprt', 'create-dprt', 'edit-dprt'])
                @php
                $isOrgOpen = request()->routeIs('admin.dpd.*', 'admin.dpc.*', 'admin.dprt.*') ? 'true' : 'false';
                @endphp
                <div x-data="{ open: {{ $isOrgOpen }} }">
                    <button @click="open = !open"
                        class="group sidebar-link w-full flex items-center justify-between px-3 py-3 rounded-lg transition-all-300 hover:bg-slate-700/20">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.dpd.*', 'admin.dpc.*', 'admin.dprt.*') ? 'bg-accent/20 text-accent' : 'bg-slate-700/50 text-slate-300 group-hover:bg-accent/10 group-hover:text-accent' }}">
                                <i class="fas fa-sitemap text-sm"></i>
                            </div>
                            <span class="font-medium">Organisasi</span>
                        </div>
                        <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"
                            class="text-slate-400 text-xs transition-transform duration-300 {{ request()->routeIs('admin.dpd.*', 'admin.dpc.*', 'admin.dprt.*') ? 'rotate-180' : '' }}"></i>
                    </button>

                    <div x-show="open" class="mt-1 ml-11 space-y-1">
                        @canany(['view-dpd', 'create-dpd', 'edit-dpd'])
                        <a href="{{ route('admin.dpd.index') }}"
                            class="group flex items-center px-3 py-2 rounded text-sm transition-all-300 {{ request()->routeIs('admin.dpd.*') ? 'text-accent font-medium' : 'text-slate-300 hover:text-white' }}">
                            <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.dpd.*') ? 'bg-accent' : 'bg-slate-600 group-hover:bg-accent' }} mr-3"></div>
                            <span>DPD Pusat</span>
                        </a>
                        @endcanany

                        @canany(['view-dpc', 'create-dpc', 'edit-dpc'])
                        <a href="{{ route('admin.dpc.index') }}"
                            class="group flex items-center px-3 py-2 rounded text-sm transition-all-300 {{ request()->routeIs('admin.dpc.*') ? 'text-accent font-medium' : 'text-slate-300 hover:text-white' }}">
                            <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.dpc.*') ? 'bg-accent' : 'bg-slate-600 group-hover:bg-accent' }} mr-3"></div>
                            <span>DPC Kecamatan</span>
                        </a>
                        @endcanany

                        @canany(['view-dprt', 'create-dprt', 'edit-dprt'])
                        <a href="{{ route('admin.dprt.index') }}"
                            class="group flex items-center px-3 py-2 rounded text-sm transition-all-300 {{ request()->routeIs('admin.dprt.*') ? 'text-accent font-medium' : 'text-slate-300 hover:text-white' }}">
                            <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.dprt.*') ? 'bg-accent' : 'bg-slate-600 group-hover:bg-accent' }} mr-3"></div>
                            <span>DPRT Desa</span>
                        </a>
                        @endcanany
                    </div>
                </div>
                @endcanany

                <!-- Struktur Organisasi -->
                @if(auth()->user()->hasAnyRole(['super-admin', 'dpd-admin', 'dpc-admin']))
                @php
                $isStructureOpen = request()->routeIs('admin.organization-structures.*') ? 'true' : 'false';
                @endphp
                <div x-data="{ open: {{ $isStructureOpen }} }">
                    <button @click="open = !open"
                        class="group sidebar-link w-full flex items-center justify-between px-3 py-3 rounded-lg transition-all-300 hover:bg-slate-700/20">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.organization-structures.*') ? 'bg-accent/20 text-accent' : 'bg-slate-700/50 text-slate-300 group-hover:bg-accent/10 group-hover:text-accent' }}">
                                <i class="fas fa-sitemap text-sm"></i>
                            </div>
                            <span class="font-medium">Struktur Organisasi</span>
                        </div>
                        <div class="flex items-center">
                            <span class="bg-accent/20 text-accent text-xs px-2 py-1 rounded-full mr-2">
                                {{ \App\Models\OrganizationStructure::count() }}
                            </span>
                            <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"
                                class="text-slate-400 text-xs transition-transform duration-300 {{ request()->routeIs('admin.organization-structures.*') ? 'rotate-180' : '' }}"></i>
                        </div>
                    </button>

                    <div x-show="open" class="mt-1 ml-11 space-y-1">
                        <a href="{{ route('admin.organization-structures.select-organization') }}"
                            class="group flex items-center px-3 py-2 rounded text-sm transition-all-300 {{ request()->routeIs('admin.organization-structures.select-organization') ? 'text-accent font-medium' : 'text-slate-300 hover:text-white' }}">
                            <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.organization-structures.select-organization') ? 'bg-accent' : 'bg-slate-600 group-hover:bg-accent' }} mr-3"></div>
                            <span>Tambah Struktur Baru</span>
                        </a>

                        <a href="{{ route('admin.organization-structures.index') }}"
                            class="group flex items-center px-3 py-2 rounded text-sm transition-all-300 {{ request()->routeIs('admin.organization-structures.index') ? 'text-accent font-medium' : 'text-slate-300 hover:text-white' }}">
                            <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.organization-structures.index') ? 'bg-accent' : 'bg-slate-600 group-hover:bg-accent' }} mr-3"></div>
                            <span>Semua Struktur</span>
                        </a>
                    </div>
                </div>
                @endif


                <!-- Kader -->
                @canany(['view-kader', 'create-kader', 'edit-kader'])
                <a href="{{ route('admin.kader.index') }}"
                    class="group sidebar-link flex items-center px-3 py-3 rounded-lg transition-all-300 {{ request()->routeIs('admin.kader.*') ? 'bg-slate-700/30 active-glow' : 'hover:bg-slate-700/20' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.kader.*') ? 'bg-accent/20 text-accent' : 'bg-slate-700/50 text-slate-300 group-hover:bg-accent/10 group-hover:text-accent' }}">
                        <i class="fas fa-users text-sm"></i>
                    </div>
                    <span class="font-medium">Manajemen Kader</span>
                    <span class="ml-auto bg-accent/20 text-accent text-xs px-2 py-1 rounded-full">
                        {{ App\Models\Kader\Kader::count() }}
                    </span>
                </a>
                @endcanany

                <!-- Berita -->
                @canany(['view-berita', 'create-berita', 'edit-berita'])
                @php
                $isBeritaOpen = request()->routeIs('admin.berita.*') ? 'true' : 'false';
                @endphp
                <div x-data="{ open: {{ $isBeritaOpen }} }">
                    <button @click="open = !open"
                        class="group sidebar-link w-full flex items-center justify-between px-3 py-3 rounded-lg transition-all-300 hover:bg-slate-700/20">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.berita.*') ? 'bg-accent/20 text-accent' : 'bg-slate-700/50 text-slate-300 group-hover:bg-accent/10 group-hover:text-accent' }}">
                                <i class="fas fa-newspaper text-sm"></i>
                            </div>
                            <span class="font-medium">Berita & Media</span>
                        </div>
                        <div class="flex items-center">
                            <span class="bg-accent/20 text-accent text-xs px-2 py-1 rounded-full mr-2">
                                {{ App\Models\Berita\Berita::count() }}
                            </span>
                            <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"
                                class="text-slate-400 text-xs transition-transform duration-300 {{ request()->routeIs('admin.berita.*') ? 'rotate-180' : '' }}"></i>
                        </div>
                    </button>

                    <div x-show="open" class="mt-1 ml-11 space-y-1">
                        <a href="{{ route('admin.berita.index') }}"
                            class="group flex items-center px-3 py-2 rounded text-sm transition-all-300 {{ request()->routeIs('admin.berita.index') ? 'text-accent font-medium' : 'text-slate-300 hover:text-white' }}">
                            <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.berita.index') ? 'bg-accent' : 'bg-slate-600 group-hover:bg-accent' }} mr-3"></div>
                            <span>Semua Berita</span>
                        </a>

                        <a href="{{ route('admin.berita.create') }}"
                            class="group flex items-center px-3 py-2 rounded text-sm transition-all-300 {{ request()->routeIs('admin.berita.create') ? 'text-accent font-medium' : 'text-slate-300 hover:text-white' }}">
                            <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.berita.create') ? 'bg-accent' : 'bg-slate-600 group-hover:bg-accent' }} mr-3"></div>
                            <span>Tulis Berita Baru</span>
                        </a>


                        <a href="{{ route('admin.berita.categories.index') }}"
                            class="group flex items-center px-3 py-2 rounded text-sm transition-all-300 {{ request()->routeIs('admin.berita.categories.*') ? 'text-accent font-medium' : 'text-slate-300 hover:text-white' }}">
                            <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.berita.categories.*') ? 'bg-accent' : 'bg-slate-600 group-hover:bg-accent' }} mr-3"></div>
                            <span>Kategori Berita</span>
                        </a>

                    </div>
                </div>
                @endcanany

                <!-- Gallery -->
                @if(auth()->user()->hasAnyRole(['super-admin', 'dpd-admin', 'news-writer']))
                @php
                $isGalleryOpen = request()->routeIs('admin.galleries.*') ? 'true' : 'false';
                @endphp
                <div x-data="{ open: {{ $isGalleryOpen }} }">
                    <button @click="open = !open"
                        class="group sidebar-link w-full flex items-center justify-between px-3 py-3 rounded-lg transition-all-300 hover:bg-slate-700/20">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.galleries.*') ? 'bg-accent/20 text-accent' : 'bg-slate-700/50 text-slate-300 group-hover:bg-accent/10 group-hover:text-accent' }}">
                                <i class="fas fa-images text-sm"></i>
                            </div>
                            <span class="font-medium">Gallery</span>
                        </div>
                        <div class="flex items-center">
                            <span class="bg-accent/20 text-accent text-xs px-2 py-1 rounded-full mr-2">
                                {{ App\Models\Gallery::count() }}
                            </span>
                            <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"
                                class="text-slate-400 text-xs transition-transform duration-300 {{ request()->routeIs('admin.galleries.*') ? 'rotate-180' : '' }}"></i>
                        </div>
                    </button>

                    <div x-show="open" class="mt-1 ml-11 space-y-1">
                        <a href="{{ route('admin.galleries.index') }}"
                            class="group flex items-center px-3 py-2 rounded text-sm transition-all-300 {{ request()->routeIs('admin.galleries.index') ? 'text-accent font-medium' : 'text-slate-300 hover:text-white' }}">
                            <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.galleries.index') ? 'bg-accent' : 'bg-slate-600 group-hover:bg-accent' }} mr-3"></div>
                            <span>Semua Gallery</span>
                        </a>

                        <a href="{{ route('admin.galleries.create') }}"
                            class="group flex items-center px-3 py-2 rounded text-sm transition-all-300 {{ request()->routeIs('admin.galleries.create') ? 'text-accent font-medium' : 'text-slate-300 hover:text-white' }}">
                            <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.galleries.create') ? 'bg-accent' : 'bg-slate-600 group-hover:bg-accent' }} mr-3"></div>
                            <span>Tambah Gallery Baru</span>
                        </a>
                    </div>
                </div>
                @endif

                @if(auth()->user()->hasAnyRole(['super-admin', 'dpd-admin']))
                @php
                $isContactOpen = request()->routeIs('admin.contact-messages.*') ? 'true' : 'false';
                $unreadCount = \App\Models\ContactMessage::unread()->count();
                @endphp
                <div x-data="{ open: {{ $isContactOpen }} }">
                    <button @click="open = !open"
                        class="group sidebar-link w-full flex items-center justify-between px-3 py-3 rounded-lg transition-all-300 hover:bg-slate-700/20">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.contact-messages.*') ? 'bg-accent/20 text-accent' : 'bg-slate-700/50 text-slate-300 group-hover:bg-accent/10 group-hover:text-accent' }}">
                                <i class="fas fa-envelope text-sm"></i>
                            </div>
                            <span class="font-medium">Pesan Kontak</span>
                        </div>
                        <div class="flex items-center">
                            @if($unreadCount > 0)
                            <span class="bg-red-500/20 text-red-400 text-xs px-2 py-1 rounded-full mr-2">
                                {{ $unreadCount }} baru
                            </span>
                            @endif
                            <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"
                                class="text-slate-400 text-xs transition-transform duration-300 {{ request()->routeIs('admin.contact-messages.*') ? 'rotate-180' : '' }}"></i>
                        </div>
                    </button>

                    <div x-show="open" class="mt-1 ml-11 space-y-1">
                        <a href="{{ route('admin.contact-messages.index') }}"
                            class="group flex items-center px-3 py-2 rounded text-sm transition-all-300 {{ request()->routeIs('admin.contact-messages.index') ? 'text-accent font-medium' : 'text-slate-300 hover:text-white' }}">
                            <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.contact-messages.index') ? 'bg-accent' : 'bg-slate-600 group-hover:bg-accent' }} mr-3"></div>
                            <span>Semua Pesan</span>
                            @php
                            $totalCount = \App\Models\ContactMessage::count();
                            @endphp
                            <span class="ml-auto text-xs text-slate-400">{{ $totalCount }}</span>
                        </a>

                        <a href="{{ route('admin.contact-messages.index') }}?status=unread"
                            class="group flex items-center px-3 py-2 rounded text-sm transition-all-300 text-slate-300 hover:text-white">
                            <div class="w-1.5 h-1.5 rounded-full bg-red-500 mr-3"></div>
                            <span>Belum Dibaca</span>
                            <span class="ml-auto text-xs text-red-400">{{ $unreadCount }}</span>
                        </a>

                        <a href="{{ route('admin.contact-messages.index') }}?status=replied"
                            class="group flex items-center px-3 py-2 rounded text-sm transition-all-300 text-slate-300 hover:text-white">
                            <div class="w-1.5 h-1.5 rounded-full bg-green-500 mr-3"></div>
                            <span>Sudah Dibalas</span>
                            <span class="ml-auto text-xs text-green-400">
                                {{ \App\Models\ContactMessage::replied()->count() }}
                            </span>
                        </a>

                        <a href="{{ route('admin.contact-messages.index') }}?status=archived"
                            class="group flex items-center px-3 py-2 rounded text-sm transition-all-300 text-slate-300 hover:text-white">
                            <div class="w-1.5 h-1.5 rounded-full bg-gray-500 mr-3"></div>
                            <span>Diarsipkan</span>
                            <span class="ml-auto text-xs text-gray-400">
                                {{ \App\Models\ContactMessage::archived()->count() }}
                            </span>
                        </a>
                    </div>
                </div>
                @endif
                <!-- GIS -->
                @can('view-gis')
                <a href="{{ route('admin.gis.index') }}"
                    class="group sidebar-link flex items-center px-3 py-3 rounded-lg transition-all-300 {{ request()->routeIs('admin.gis.*') ? 'bg-slate-700/30 active-glow' : 'hover:bg-slate-700/20' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.gis.*') ? 'bg-accent/20 text-accent' : 'bg-slate-700/50 text-slate-300 group-hover:bg-accent/10 group-hover:text-accent' }}">
                        <i class="fas fa-map-marked-alt text-sm"></i>
                    </div>
                    <span class="font-medium">GIS Mapping</span>
                </a>
                @endcan



                <!-- Reports -->
                <a href="#"
                    class="group sidebar-link flex items-center px-3 py-3 rounded-lg transition-all-300 hover:bg-slate-700/20">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-700/50 text-slate-300 group-hover:bg-accent/10 group-hover:text-accent">
                        <i class="fas fa-chart-bar text-sm"></i>
                    </div>
                    <span class="font-medium">Laporan & Analisis</span>
                    <span class="ml-auto bg-success/20 text-success text-xs px-2 py-1 rounded-full">
                        New
                    </span>
                </a>

                <!-- Divider -->
                <div class="h-px bg-slate-700/50 my-4 mx-3"></div>

                <!-- Quick Links -->
                <div class="px-3 space-y-1">
                    <a href="{{ route('home') }}" target="_blank"
                        class="group flex items-center px-3 py-2 rounded-lg text-sm transition-all-300 hover:bg-slate-700/20">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center mr-3 bg-slate-700/50 text-slate-300 group-hover:bg-accent/10 group-hover:text-accent">
                            <i class="fas fa-external-link-alt text-xs"></i>
                        </div>
                        <span>Lihat Website</span>
                    </a>

                    <a href="#"
                        class="group flex items-center px-3 py-2 rounded-lg text-sm transition-all-300 hover:bg-slate-700/20">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center mr-3 bg-slate-700/50 text-slate-300 group-hover:bg-accent/10 group-hover:text-accent">
                            <i class="fas fa-cog text-xs"></i>
                        </div>
                        <span>Pengaturan</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="group">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-3 py-2 rounded-lg text-sm transition-all-300 hover:bg-slate-700/20">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center mr-3 bg-slate-700/50 text-slate-300 group-hover:bg-accent/10 group-hover:text-accent">
                                <i class="fas fa-sign-out-alt text-xs"></i>
                            </div>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Sidebar Footer -->
            <div class="px-4 py-3 border-t border-slate-700/50">
                <div class="flex items-center justify-between">
                    <div class="text-xs text-slate-400">
                        <div class="font-medium">System Status</div>
                        <div class="flex items-center mt-1">
                            <div class="w-2 h-2 rounded-full bg-success mr-2"></div>
                            <span>All Systems Operational</span>
                        </div>
                    </div>
                    <div class="text-xs bg-slate-700/50 px-2 py-1 rounded">
                        v2.0.1
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white border-b border-slate-200 shadow-sm">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center">
                            <button @click="sidebarOpen = true"
                                class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-all-300">
                                <i class="fas fa-bars text-lg"></i>
                            </button>
                            <div class="ml-4 lg:ml-0">
                                <h1 class="text-xl font-bold text-slate-800">{{ $title ?? 'Dashboard' }}</h1>
                                <div class="flex items-center text-sm text-slate-500 mt-1">
                                    <i class="fas fa-home mr-2 text-xs"></i>
                                    <span>Admin Panel</span>
                                    <i class="fas fa-chevron-right mx-2 text-xs"></i>
                                    <span class="font-medium text-slate-600">{{ $title ?? 'Dashboard' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <!-- Search -->
                            <div class="hidden md:block relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-slate-400"></i>
                                </div>
                                <input type="text"
                                    placeholder="Cari sesuatu..."
                                    class="pl-10 pr-4 py-2 w-64 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all-300">
                            </div>

                            <!-- Notifications -->
                            <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                                <button @click="open = !open"
                                    class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-all-300 relative">
                                    <i class="fas fa-bell text-lg"></i>
                                    <div class="absolute -top-1 -right-1 w-5 h-5 bg-danger text-white text-xs rounded-full flex items-center justify-center border-2 border-white notification-badge">
                                        3
                                    </div>
                                </button>
                                <div x-show="open" x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-slate-200 z-50">
                                    <div class="p-4 border-b border-slate-100">
                                        <div class="flex items-center justify-between">
                                            <h3 class="font-bold text-slate-800">Notifikasi</h3>
                                            <span class="text-xs text-accent font-medium cursor-pointer">Tandai semua terbaca</span>
                                        </div>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        <!-- Notification items -->
                                    </div>
                                    <div class="p-3 border-t border-slate-100 text-center">
                                        <a href="#" class="text-sm text-accent font-medium hover:text-accent-light">
                                            Lihat semua notifikasi
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Date & Time -->
                            <div class="hidden lg:flex flex-col text-right">
                                <div class="text-sm font-medium text-slate-800" id="current-time">--:--:--</div>
                                <div class="text-xs text-slate-500" id="current-date">-- --- ----</div>
                            </div>

                            <!-- User Menu -->
                            <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                                <button @click="open = !open"
                                    class="flex items-center space-x-3 p-2 rounded-lg hover:bg-slate-100 transition-all-300">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-slate-600 to-slate-700 flex items-center justify-center text-white font-bold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div class="hidden md:block text-left">
                                        <div class="text-sm font-medium text-slate-800">{{ auth()->user()->name }}</div>
                                        <div class="text-xs text-slate-500">{{ auth()->user()->email }}</div>
                                    </div>
                                    <i class="fas fa-chevron-down text-slate-400 text-xs"></i>
                                </button>
                                <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-slate-200 z-50">
                                    <div class="p-3 border-b border-slate-100">
                                        <div class="text-sm font-medium text-slate-800">{{ auth()->user()->name }}</div>
                                        <div class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</div>
                                    </div>
                                    <div class="py-1">
                                        <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                            <i class="fas fa-user mr-3 text-slate-400"></i>Profil Saya
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                            <i class="fas fa-cog mr-3 text-slate-400"></i>Pengaturan
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                                <i class="fas fa-sign-out-alt mr-3 text-slate-400"></i>Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gradient-to-b from-slate-50 to-white p-4 sm:p-6 lg:p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                <div class="mb-6 animate-fade-in-down">
                    <div class="flex items-center p-4 bg-success/10 border border-success/20 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-success/20 flex items-center justify-center">
                                <i class="fas fa-check text-success text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-success">{{ session('success') }}</p>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="ml-3 text-success/60 hover:text-success">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 animate-fade-in-down">
                    <div class="flex items-center p-4 bg-danger/10 border border-danger/20 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-danger/20 flex items-center justify-center">
                                <i class="fas fa-exclamation text-danger text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-danger">{{ session('error') }}</p>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="ml-3 text-danger/60 hover:text-danger">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-slate-200 py-3 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center justify-between">
                    <div class="text-sm text-slate-500 mb-2 sm:mb-0">
                        © {{ date('Y') }} NasDem Kabupaten Bojonegoro. Hak cipta dilindungi.
                    </div>
                    <div class="flex items-center space-x-6 text-sm text-slate-500">
                        <div class="hidden md:flex items-center">
                            <div class="w-2 h-2 rounded-full bg-success mr-2"></div>
                            <span>System Status: Normal</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="#" class="hover:text-accent transition-colors">Terms</a>
                            <a href="#" class="hover:text-accent transition-colors">Privacy</a>
                            <a href="#" class="hover:text-accent transition-colors">Help</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Live clock
        function updateClock() {
            const now = new Date();
            const timeElement = document.getElementById('current-time');
            const dateElement = document.getElementById('current-date');

            if (timeElement) {
                timeElement.textContent = now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            }

            if (dateElement) {
                dateElement.textContent = now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            }
        }

        // Update clock every second
        setInterval(updateClock, 1000);
        updateClock();

        // Global loading handler
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('global-loader');

            // Show loader on form submissions
            document.addEventListener('submit', function(e) {
                if (e.target.matches('form:not([data-no-loading])')) {
                    loader.classList.remove('hidden');
                }
            });

            // Hide loader when page is loaded
            window.addEventListener('load', function() {
                setTimeout(() => {
                    loader.classList.add('hidden');
                }, 500);
            });
        });

        // Notification system
        function showNotification(type, message, duration = 5000) {
            const container = document.getElementById('notification-container');
            const id = 'notification-' + Date.now();

            const colors = {
                success: {
                    bg: 'bg-success/10',
                    border: 'border-success/20',
                    text: 'text-success',
                    icon: 'fa-check'
                },
                error: {
                    bg: 'bg-danger/10',
                    border: 'border-danger/20',
                    text: 'text-danger',
                    icon: 'fa-exclamation'
                },
                info: {
                    bg: 'bg-accent/10',
                    border: 'border-accent/20',
                    text: 'text-accent',
                    icon: 'fa-info-circle'
                },
                warning: {
                    bg: 'bg-warning/10',
                    border: 'border-warning/20',
                    text: 'text-warning',
                    icon: 'fa-exclamation-triangle'
                }
            };

            const color = colors[type] || colors.info;

            const notification = document.createElement('div');
            notification.id = id;
            notification.className = `animate-fade-in-right ${color.bg} ${color.border} border rounded-lg p-4 shadow-lg`;
            notification.innerHTML = `
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 rounded-full ${color.bg} flex items-center justify-center">
                            <i class="fas ${color.icon} ${color.text} text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium ${color.text}">${message}</p>
                    </div>
                    <button onclick="document.getElementById('${id}').remove()" 
                            class="ml-3 ${color.text}/60 hover:${color.text}">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
            `;

            container.prepend(notification);

            // Auto remove after duration
            setTimeout(() => {
                if (document.getElementById(id)) {
                    document.getElementById(id).remove();
                }
            }, duration);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + K for search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                document.querySelector('input[placeholder="Cari sesuatu..."]')?.focus();
            }

            // Esc to close modals/dropdowns
            if (e.key === 'Escape') {
                document.querySelectorAll('[x-show]').forEach(el => {
                    if (el.__x && el.__x.$data && el.__x.$data.open === true) {
                        el.__x.$data.open = false;
                    }
                });
            }
        });

        // Smooth scroll to top
        window.addEventListener('scroll', function() {
            const scrollBtn = document.getElementById('scroll-to-top');
            if (!scrollBtn) return;

            if (window.scrollY > 300) {
                scrollBtn.classList.remove('opacity-0', 'invisible');
                scrollBtn.classList.add('opacity-100', 'visible');
            } else {
                scrollBtn.classList.remove('opacity-100', 'visible');
                scrollBtn.classList.add('opacity-0', 'invisible');
            }
        });
    </script>

    <!-- Floating action button - Scroll to top -->
    <button id="scroll-to-top"
        onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="fixed bottom-6 right-6 w-12 h-12 bg-accent text-white rounded-full shadow-lg flex items-center justify-center transition-all-300 opacity-0 invisible hover:bg-accent-light hover:shadow-xl hover:scale-110">
        <i class="fas fa-chevron-up"></i>
    </button>

    @stack('scripts')
</body>

</html>