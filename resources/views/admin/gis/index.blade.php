@extends('layouts.admin')

@section('title', 'Peta GIS Kabupaten Bojonegoro')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Peta GIS Kabupaten Bojonegoro</h1>
            <p class="mt-1 text-sm text-gray-600">Visualisasi data spasial DPC & DPRT di peta</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="exportMap()"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                <i class="fas fa-download mr-2"></i>Export Peta
            </button>
            <button onclick="printMap()"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                <i class="fas fa-print mr-2"></i>Cetak Peta
            </button>
        </div>
    </div>

    <!-- Map Controls -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Tipe Peta</label>
                    <select id="map-type"
                        class="border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 text-sm">
                        <option value="street">Street Map</option>
                        <option value="satellite">Satellite</option>
                        <option value="topographic">Topographic</option>
                        <option value="dark">Dark Mode</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Layer Data</label>
                    <select id="data-layer"
                        class="border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 text-sm">
                        <option value="dpc">DPC Kecamatan</option>
                        <option value="dprt">DPRT Desa</option>
                        <option value="kader">Distribusi Kader</option>
                        <option value="all">Semua Data</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <button id="zoom-in"
                    class="p-2 bg-gray-100 hover:bg-gray-200 rounded-md">
                    <i class="fas fa-search-plus"></i>
                </button>
                <button id="zoom-out"
                    class="p-2 bg-gray-100 hover:bg-gray-200 rounded-md">
                    <i class="fas fa-search-minus"></i>
                </button>
                <button id="reset-view"
                    class="p-2 bg-gray-100 hover:bg-gray-200 rounded-md">
                    <i class="fas fa-globe-asia"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Map Container -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="h-[600px] relative" id="map-container">
            <!-- Loading State -->
            <div id="map-loading" class="absolute inset-0 flex items-center justify-center bg-gray-100 z-10">
                <div class="text-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-nasdem-red mx-auto"></div>
                    <p class="mt-4 text-gray-600">Memuat peta...</p>
                </div>
            </div>

            <!-- Map will be rendered here -->
            <div id="map" class="absolute inset-0"></div>

            <!-- Legend -->
            <div id="map-legend" class="absolute bottom-4 left-4 bg-white rounded-lg shadow-lg p-4 z-20 max-w-xs">
                <h4 class="font-medium text-gray-900 mb-3">Legenda Peta</h4>
                <div class="legend-content">
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">DPD Pusat</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">DPC Aktif</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">DPC Non-Aktif</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">DPRT Aktif</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-purple-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">Konsentrasi Kader</span>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t">
                        <div class="flex justify-between text-xs text-gray-600">
                            <span>Rendah</span>
                            <span>Tinggi</span>
                        </div>
                        <div class="h-2 bg-gradient-to-r from-green-400 via-yellow-500 to-red-500 rounded mt-1"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-building text-red-600"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">1</div>
                        <div class="text-sm text-gray-600">DPD</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $dpcWithCoords ?? 0 }}</div>
                        <div class="text-sm text-gray-600">DPC ({{ $dpcs->count() ?? 0 }} total)</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-map-pin text-green-600"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $dprtWithCoords ?? 0 }}</div>
                        <div class="text-sm text-gray-600">DPRT ({{ $dprts->count() ?? 0 }} total)</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-users text-purple-600"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $totalKader ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Kader</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- GeoJSON Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-globe-asia text-orange-600"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $kabupatenGeo ? 1 : 0 }}</div>
                        <div class="text-sm text-gray-600">Kabupaten</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-layer-group text-yellow-600"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $kecamatanGeo->count() ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Kecamatan</div>
                        @if(($kecamatanWithDpc ?? 0) > 0)
                        <div class="text-xs text-green-600 mt-1">{{ $kecamatanWithDpc ?? 0 }} dengan DPC</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-draw-polygon text-indigo-600"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $desaGeo->count() ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Desa</div>
                        @if(($desaWithDprt ?? 0) > 0)
                        <div class="text-xs text-green-600 mt-1">{{ $desaWithDprt ?? 0 }} dengan DPRT</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- DPC List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-medium text-gray-900">DPC dengan Koordinat</h3>
                <p class="text-sm text-gray-600 mt-1">
                    Menampilkan {{ $dpcWithCoords ?? 0 }} dari {{ $dpcs->count() ?? 0 }} DPC yang memiliki koordinat
                </p>
            </div>

            @if(($dpcs->count() ?? 0) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kecamatan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Koordinat
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kader
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($dpcs ?? [] as $dpc)
                        @if($dpc->latitude && $dpc->longitude)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $dpc->kecamatan_name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $dpc->latitude }}, {{ $dpc->longitude }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($dpc->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Aktif
                                </span>
                                @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Non-Aktif
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $dpc->total_kader }} kader</div>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="focusOnDPC({{ $dpc->latitude }}, {{ $dpc->longitude }}, '{{ $dpc->kecamatan_name }}')"
                                    class="text-blue-600 hover:text-blue-900 text-sm">
                                    <i class="fas fa-map-marker-alt mr-1"></i>Lihat di Peta
                                </button>
                            </td>
                        </tr>
                        @endif
                        @endforeach

                        @if(($dpcWithCoords ?? 0) == 0)
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-map-marker-alt text-gray-300 text-3xl mb-3"></i>
                                <p>Tidak ada DPC dengan koordinat yang tersedia</p>
                                <p class="text-sm mt-1">Silakan tambahkan koordinat pada data DPC terlebih dahulu</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            @else
            <div class="px-6 py-8 text-center">
                <i class="fas fa-database text-gray-300 text-4xl mb-3"></i>
                <p class="text-gray-600">Belum ada data DPC</p>
                <a href="{{ route('admin.dpc.create') }}" class="text-sm text-nasdem-red hover:text-red-700">
                    <i class="fas fa-plus mr-1"></i>Tambah DPC pertama
                </a>
            </div>
            @endif
        </div>
    </div>
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    <style>
        #map {
            z-index: 1;
        }

        .leaflet-popup-content {
            min-width: 200px;
        }

        .marker-cluster-small {
            background-color: rgba(34, 197, 94, 0.6);
        }

        .marker-cluster-small div {
            background-color: rgba(34, 197, 94, 0.8);
        }

        .marker-cluster-medium {
            background-color: rgba(234, 179, 8, 0.6);
        }

        .marker-cluster-medium div {
            background-color: rgba(234, 179, 8, 0.8);
        }

        .marker-cluster-large {
            background-color: rgba(220, 38, 38, 0.6);
        }

        .marker-cluster-large div {
            background-color: rgba(220, 38, 38, 0.8);
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .dpd-marker,
        .dpc-marker,
        .dprt-marker {
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        .marker-cluster {
            background-clip: padding-box;
            border-radius: 20px;
        }

        .marker-cluster div {
            width: 30px;
            height: 30px;
            margin-left: 5px;
            margin-top: 5px;
            text-align: center;
            border-radius: 15px;
            font: 12px "Helvetica Neue", Arial, Helvetica, sans-serif;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Custom styles for our markers */
        .custom-dpd-icon {
            width: 40px;
            height: 40px;
            background-color: #dc2626;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .custom-dpc-icon {
            width: 32px;
            height: 32px;
            background-color: #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .custom-dprt-icon {
            width: 24px;
            height: 24px;
            background-color: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        /* Legend styling */
        #map-legend {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        select option.font-bold {
            font-weight: 600 !important;
        }

        select option.text-nasdem-red {
            color: #dc2626 !important;
        }

        /* Active layer indicator */
        .layer-active {
            border-left: 4px solid #3b82f6 !important;
        }

        /* Layer control styling */
        .leaflet-control-layers {
            border-radius: 8px !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
        }

        .leaflet-control-layers-toggle {
            background-color: white !important;
            border: 2px solid #3b82f6 !important;
        }

        /* Tambahkan di bagian CSS */
        .leaflet-interactive {
            cursor: pointer !important;
            transition: all 0.2s ease-in-out;
        }

        .leaflet-interactive:hover {
            filter: drop-shadow(0 0 8px rgba(0, 0, 0, 0.3));
        }

        /* Style untuk popup yang lebih baik */
        .leaflet-popup-content-wrapper {
            border-radius: 8px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
        }

        .leaflet-popup-content {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif !important;
        }

        /* Tooltip styling */
        .leaflet-tooltip {
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 6px !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
            font-size: 12px !important;
            padding: 6px 10px !important;
        }

        .leaflet-tooltip-top:before {
            border-top-color: rgba(255, 255, 255, 0.95) !important;
        }

        .kecamatan-active {
            animation: pulse-border 2s infinite;
        }

        @keyframes pulse-border {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(220, 38, 38, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0);
            }
        }

        .desa-highlighted {
            filter: drop-shadow(0 0 5px rgba(37, 99, 235, 0.5));
            transition: all 0.3s ease-in-out;
        }

        /* Style untuk button dalam popup */
        .leaflet-popup-content button {
            transition: all 0.2s ease-in-out;
        }

        .leaflet-popup-content button:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .desa-highlighted {
            filter: drop-shadow(0 0 5px rgba(37, 99, 235, 0.5)) !important;
            transition: all 0.3s ease-in-out !important;
        }

        /* Pastikan layer desa di atas layer lain */
        .leaflet-pane.leaflet-overlay-pane {
            z-index: 400 !important;
        }

        .leaflet-pane.leaflet-marker-pane {
            z-index: 600 !important;
        }

        /* Style untuk notification popup */
        #simple-notification {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            font-size: 14px;
            max-width: 300px;
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        const apiUrl = '{{ route("admin.gis.api.data") }}';
    </script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

    <script>
        // 🔧 Fix Leaflet marker icon path
        delete L.Icon.Default.prototype._getIconUrl;
        L.Icon.Default.mergeOptions({
            iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
            iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
        });

        // 🗺️ GLOBAL VARIABLES - DIPERBAIKI
        let map = null;
        let markerCluster = null;
        let currentTileLayer = null;
        let currentMapType = 'street';
        let currentDataLayer = 'all';
        let lastClickedKecamatan = null;
        let lastClickedKecamatanLayer = null;

        let kecamatanDesaLayers = L.layerGroup();
        // Layer groups untuk mengelola visibility
        let layerGroups = {
            dpd: null,
            dpc: L.layerGroup(),
            dprt: L.markerClusterGroup({
                maxClusterRadius: 40,
                iconCreateFunction: function(cluster) {
                    const count = cluster.getChildCount();
                    let color = '#22c55e';
                    let size = 40;

                    if (count > 20) {
                        color = '#dc2626';
                        size = 45;
                    } else if (count > 10) {
                        color = '#eab308';
                        size = 42;
                    }

                    return L.divIcon({
                        html: `
                        <div style="background-color: ${color}; width: ${size}px; height: ${size}px; border-radius: 50%; 
                             display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; border: 3px solid white;">
                            ${count}
                        </div>
                    `,
                        className: 'marker-cluster',
                        iconSize: L.point(size, size)
                    });
                }
            }),
            kabupaten: null,
            kecamatan: L.layerGroup(),
            desa: L.layerGroup()
        };

        // Data markers
        let dpcMarkers = [];
        let dprtMarkers = [];

        // 🚀 MAIN MAP INITIALIZATION
        async function initMap() {
            console.log('🗺️ Initializing map...');

            try {
                // 1. Create map instance dengan parameter yang benar
                map = L.map('map', {
                    center: [-7.150975, 111.881860],
                    zoom: 10,
                    zoomControl: false,
                    maxBounds: [
                        [-7.5, 111.5], // SW
                        [-6.8, 112.3] // NE
                    ],
                    maxBoundsViscosity: 1.0
                });

                // 2. DEBUG: Tampilkan data dari API sebelum diproses
                console.log('📡 Fetching data from API...');
                const response = await fetch(apiUrl);
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const data = await response.json();
                console.log('✅ Data loaded from API');

                // DEBUG: Tampilkan detail data
                console.log('📊 Data analysis:');
                console.log('- Total DPC:', data.dpcs?.length || 0);
                console.log('- Total DPRT:', data.dprts?.length || 0);

                // Cek data DPC dengan koordinat
                const dpcWithCoords = data.dpcs?.filter(dpc => dpc.latitude && dpc.longitude) || [];
                console.log('- DPC with coordinates:', dpcWithCoords.length);

                // Cek data DPRT dengan koordinat
                const dprtWithCoords = data.dprts?.filter(dprt => dprt.latitude && dprt.longitude) || [];
                console.log('- DPRT with coordinates:', dprtWithCoords.length);

                // Tampilkan contoh data jika ada
                if (dpcWithCoords.length > 0) {
                    console.log('📍 Example DPC with coords:', dpcWithCoords[0]);
                }
                if (dprtWithCoords.length > 0) {
                    console.log('📍 Example DPRT with coords:', dprtWithCoords[0]);
                }

                // 3. Add default tile layer terlebih dahulu
                currentTileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 19,
                    minZoom: 8
                }).addTo(map);

                // 4. Initialize all layers
                initAllLayers(data);

                // 5. Add DPD marker (always visible)
                addDpdMarker();

                // 6. Setup controls
                setupMapControls();

                // 7. Setup layer controls
                setupLayerControls();

                // 8. Show all layers by default
                toggleDataLayers('all');

                // 9. Hide loading indicator
                document.getElementById('map-loading').style.display = 'none';

                // 10. Update legend with statistics
                updateLegendStatistics(data.statistics);

                console.log('🎉 Map successfully loaded!');

            } catch (error) {
                console.error('❌ Map initialization error:', error);
                showMapError(error);
            }
        }

        // 🗺️ INITIALIZE ALL LAYERS
        function initAllLayers(data) {
            console.log('🔄 Initializing all layers...');

            // Clear existing markers
            dpcMarkers = [];
            dprtMarkers = [];

            // Reset layer groups
            layerGroups.dpc.clearLayers();
            layerGroups.dprt.clearLayers();
            layerGroups.kecamatan.clearLayers();

            // 1. Add GeoJSON layers
            addGeojsonLayers(data);

            // 2. Add DPC markers
            addDpcMarkers(data);

            // 3. Add DPRT markers
            addDprtMarkers(data);

            // Add layer groups to map (but hidden initially)
            if (layerGroups.kabupaten) {
                layerGroups.kabupaten.addTo(map);
            }
            layerGroups.kecamatan.addTo(map);
            layerGroups.dpc.addTo(map);
            layerGroups.dprt.addTo(map);

            console.log('✅ All layers initialized');
        }

        // 🗺️ ADD GEOJSON LAYERS
        function addGeojsonLayers(data) {
            try {
                // Kabupaten boundary
                if (data.geojson?.kabupaten?.geojson) {
                    try {
                        const kabupatenGeoJSON = typeof data.geojson.kabupaten.geojson === 'string' ?
                            JSON.parse(data.geojson.kabupaten.geojson) :
                            data.geojson.kabupaten.geojson;

                        layerGroups.kabupaten = L.geoJSON(kabupatenGeoJSON, {
                            style: {
                                fillColor: '#dc2626',
                                weight: 3,
                                opacity: 0.8,
                                color: '#dc2626',
                                fillOpacity: 0.05,
                                dashArray: '5, 5'
                            }
                        }).bindPopup(`
                        <div style="font-weight: bold; color: #dc2626; margin-bottom: 8px; font-size: 14px;">
                            ${data.geojson.kabupaten.name}
                        </div>
                        <div style="font-size: 12px; color: #4b5563;">
                            ${data.geojson.kabupaten.total_kecamatan} Kecamatan
                        </div>
                        <div style="font-size: 12px; color: #4b5563;">
                            ${data.geojson.kabupaten.total_desa} Desa
                        </div>
                    `);

                        console.log('✅ Kabupaten boundary added');
                    } catch (e) {
                        console.warn('⚠️ Failed to parse kabupaten GeoJSON:', e);
                    }
                }

                // Kecamatan boundaries
                if (data.geojson?.kecamatans && Array.isArray(data.geojson.kecamatans)) {
                    data.geojson.kecamatans.forEach(kecamatan => {
                        if (kecamatan.geojson) {
                            try {
                                const kecamatanGeoJSON = typeof kecamatan.geojson === 'string' ?
                                    JSON.parse(kecamatan.geojson) :
                                    kecamatan.geojson;

                                const layer = L.geoJSON(kecamatanGeoJSON, {
                                    style: {
                                        fillColor: '#3b82f6',
                                        weight: 2.5, // Lebih tebal dari desa
                                        opacity: 0.8,
                                        color: '#1d4ed8', // Biru lebih gelap
                                        fillOpacity: 0.05, // Sangat transparan
                                        dashArray: '5, 5' // Dash agar berbeda dengan desa
                                    },
                                    // TAMBAHKAN INTERACTIVE STYLE untuk kecamatan juga
                                    interactive: true,
                                    onEachFeature: function(feature, layer) {
                                        layer.on('mouseover', function(e) {
                                            this.setStyle({
                                                weight: 4,
                                                color: '#7c3aed', // Ungu saat hover
                                                opacity: 1,
                                                fillOpacity: 0.15,
                                                fillColor: '#a78bfa',
                                                dashArray: null // Solid saat hover
                                            });

                                            layer.bindTooltip(`
                                <div style="font-weight: bold; color: #7c3aed; font-size: 14px;">
                                    Kecamatan ${kecamatan.name}
                                </div>
                                <div style="font-size: 12px; color: #4b5563;">
                                    ${kecamatan.total_desa || 0} Desa
                                </div>
                            `, {
                                                direction: 'top',
                                                offset: [0, -10],
                                                permanent: false,
                                                sticky: true
                                            }).openTooltip();

                                            layer.bringToFront();
                                        });

                                        layer.on('mouseout', function(e) {
                                            this.setStyle({
                                                weight: 2.5,
                                                color: '#1d4ed8',
                                                opacity: 0.8,
                                                fillOpacity: 0.05,
                                                fillColor: '#3b82f6',
                                                dashArray: '5, 5'
                                            });

                                            layer.closeTooltip();
                                        });

                                        // ⚠️ INI YANG DIGANTI - EVENT CLICK BARU
                                        layer.on('click', function(e) {
                                            // Zoom ke kecamatan yang diklik
                                            map.fitBounds(layer.getBounds().pad(0.1));
                                            // Dapatkan data jumlah desa
                                            const desaCount = kecamatan.total_desa || 0;
                                            // Tampilkan desa-desa dalam kecamatan ini DENGAN DATA YANG BENAR
                                            showDesaInKecamatan(kecamatan.name, desaCount);
                                            // Update legenda langsung dari sini
                                            updateKecamatanLegend(kecamatan.name, desaCount);
                                            // Highlight kecamatan
                                            this.setStyle({
                                                weight: 5,
                                                color: '#dc2626', // Merah saat diklik
                                                opacity: 1,
                                                fillOpacity: 0.1,
                                                fillColor: '#f87171',
                                                dashArray: null
                                            });

                                            // Tampilkan popup kecamatan
                                            layer.bindPopup(`
                                <div style="font-weight: bold; color: #dc2626; margin-bottom: 8px; font-size: 14px;">
                                    Kecamatan ${kecamatan.name}
                                </div>
                                <div style="font-size: 12px; color: #4b5563; margin-bottom: 5px;">
                                    <i class="fas fa-map-marker-alt mr-2"></i>Kode BPS: ${kecamatan.kode_bps || '-'}
                                </div>
                                <div style="font-size: 12px; color: #4b5563; margin-bottom: 5px;">
                                    <i class="fas fa-layer-group mr-2"></i>Jumlah Desa: ${kecamatan.total_desa || 0}
                                </div>
                                <div style="margin-top: 10px;">
                                    <button onclick="showDesaInKecamatan('${kecamatan.name}')"
                                        style="background-color: #3b82f6; color: white; padding: 5px 10px; 
                                               border-radius: 4px; border: none; cursor: pointer; font-size: 12px; margin-right: 5px;">
                                        <i class="fas fa-eye mr-1"></i>Tampilkan Desa
                                    </button>
                                    <button onclick="resetKecamatanView()"
                                        style="background-color: #6b7280; color: white; padding: 5px 10px; 
                                               border-radius: 4px; border: none; cursor: pointer; font-size: 12px;">
                                        <i class="fas fa-times mr-1"></i>Tutup
                                    </button>
                                </div>
                            `).openPopup();

                                            // Simpan layer kecamatan yang diklik
                                            lastClickedKecamatan = kecamatan.name;
                                            lastClickedKecamatanLayer = layer;

                                            // Tampilkan desa-desa dalam kecamatan ini
                                            showDesaInKecamatan(kecamatan.name);
                                        });
                                    }
                                }).bindPopup(`
                    <div style="font-weight: bold; color: #3b82f6; margin-bottom: 5px; font-size: 13px;">
                        Kecamatan ${kecamatan.name}
                    </div>
                    <div style="font-size: 12px; color: #4b5563;">
                        ${kecamatan.total_desa || 0} Desa
                    </div>
                    <div style="font-size: 12px; color: #6b7280;">
                        Kode BPS: ${kecamatan.kode_bps || '-'}
                    </div>
                `);

                                layerGroups.kecamatan.addLayer(layer);
                            } catch (e) {
                                console.warn('⚠️ Failed to parse kecamatan GeoJSON:', e);
                            }
                        }
                    });
                    console.log(`✅ ${data.geojson.kecamatans.length} kecamatan boundaries added`);
                }


                // Desa boundaries
                if (data.geojson?.desas && Array.isArray(data.geojson.desas)) {
                    data.geojson.desas.forEach(desa => {
                        if (desa.geojson) {
                            try {
                                const desaGeoJSON = typeof desa.geojson === 'string' ?
                                    JSON.parse(desa.geojson) :
                                    desa.geojson;

                                const layer = L.geoJSON(desaGeoJSON, {
                                    style: {
                                        // WARNA LEBIH KONTRAST DAN JELAS
                                        fillColor: '#10b981', // Hijau lebih terang
                                        weight: 2, // Lebih tebal
                                        opacity: 0.7, // Lebih terlihat
                                        color: '#059669', // Border hijau lebih gelap
                                        fillOpacity: 0.1, // Lebih transparan agar tidak menutupi
                                        dashArray: null, // Hilangkan dash, gunakan garis solid
                                        fillRule: 'evenodd'
                                    },
                                    // TAMBAHKAN INTERACTIVE STYLE
                                    interactive: true, // Aktifkan interaksi

                                    // TAMBAHKAN EVENT HANDLERS untuk efek hover
                                    onEachFeature: function(feature, layer) {
                                        // Event mouseover - highlight desa
                                        layer.on('mouseover', function(e) {
                                            feature.properties = {
                                                ...feature.properties,
                                                desa_id: desa.id,
                                                desa_name: desa.name,
                                                kecamatan_name: desa.kecamatan_name,
                                                kode_bps: desa.kode_bps,
                                                center: desa.center
                                            };
                                            this.setStyle({
                                                weight: 4,
                                                color: '#dc2626', // Merah saat hover
                                                opacity: 1,
                                                fillOpacity: 0.3,
                                                fillColor: '#f87171' // Merah muda saat hover
                                            });

                                            // Tampilkan tooltip/tooltip sederhana
                                            layer.bindTooltip(`
                                <div style="font-weight: bold; color: #dc2626; font-size: 13px;">
                                    Desa ${desa.name}
                                </div>
                                <div style="font-size: 11px; color: #4b5563;">
                                    Kecamatan: ${desa.kecamatan_name || '-'}
                                </div>
                            `, {
                                                direction: 'top',
                                                offset: [0, -10],
                                                permanent: false,
                                                sticky: true
                                            }).openTooltip();

                                            // Tambah efek shadow
                                            layer.bringToFront();
                                        });

                                        // Event mouseout - kembalikan ke style normal
                                        layer.on('mouseout', function(e) {
                                            this.setStyle({
                                                weight: 2,
                                                color: '#059669',
                                                opacity: 0.7,
                                                fillOpacity: 0.1,
                                                fillColor: '#10b981'
                                            });

                                            // Tutup tooltip
                                            layer.closeTooltip();
                                        });

                                        // Event click - highlight dan zoom
                                        layer.on('click', function(e) {
                                            // Zoom ke desa yang diklik
                                            map.fitBounds(layer.getBounds().pad(0.1));

                                            // Highlight lebih intens
                                            this.setStyle({
                                                weight: 5,
                                                color: '#1d4ed8', // Biru saat diklik
                                                opacity: 1,
                                                fillOpacity: 0.4,
                                                fillColor: '#60a5fa'
                                            });

                                            // Tampilkan popup
                                            layer.bindPopup(`
                                <div style="font-weight: bold; color: #1d4ed8; margin-bottom: 8px; font-size: 14px;">
                                    Desa ${desa.name}
                                </div>
                                <div style="font-size: 12px; color: #4b5563; margin-bottom: 5px;">
                                    <i class="fas fa-map-marker-alt mr-2"></i>Kecamatan: ${desa.kecamatan_name || '-'}
                                </div>
                                <div style="font-size: 12px; color: #4b5563; margin-bottom: 5px;">
                                    <i class="fas fa-hashtag mr-2"></i>Kode BPS: ${desa.kode_bps || '-'}
                                </div>
                                <div style="margin-top: 10px;">
                                    <button onclick="focusOnDesa(${desa.center?.[0] || -7.15}, ${desa.center?.[1] || 111.88}, '${desa.name}')"
                                        style="background-color: #3b82f6; color: white; padding: 5px 10px; 
                                               border-radius: 4px; border: none; cursor: pointer; font-size: 12px;">
                                        <i class="fas fa-search-location mr-1"></i>Fokus ke Desa
                                    </button>
                                </div>
                            `).openPopup();
                                        });
                                    }
                                });

                                layerGroups.desa.addLayer(layer);
                            } catch (e) {
                                console.warn('⚠️ Failed to parse desa GeoJSON:', e);
                            }
                        }
                    });
                    console.log(`✅ ${data.geojson.desas.length} desa boundaries added`);
                }

            } catch (error) {
                console.warn('⚠️ GeoJSON layers error:', error);
            }

        }

        // 📍 ADD DPC MARKERS
        function addDpcMarkers(data) {
            if (!data.dpcs || !Array.isArray(data.dpcs)) return;

            console.log(`📌 Processing ${data.dpcs.length} DPCs...`);

            data.dpcs.forEach((dpc, index) => {
                // Gunakan koordinat default jika tidak ada
                const lat = dpc.latitude ? parseFloat(dpc.latitude) : -7.150975 + (Math.random() * 0.1 - 0.05);
                const lng = dpc.longitude ? parseFloat(dpc.longitude) : 111.881860 + (Math.random() * 0.1 - 0.05);
                const hasCoords = dpc.latitude && dpc.longitude;

                // DEBUG: Log setiap DPC
                if (!hasCoords) {
                    console.warn(`⚠️ DPC ${index}: "${dpc.kecamatan_name}" has no coordinates`);
                }

                // Warna berdasarkan status dan apakah ada koordinat
                let color = '#3b82f6'; // default blue for active
                if (!dpc.is_active) {
                    color = '#9ca3af'; // gray for inactive
                }
                if (!hasCoords) {
                    color = '#f59e0b'; // orange/yellow for no coordinates
                }

                // Create custom icon
                const icon = L.divIcon({
                    html: `
                <div style="position: relative;">
                    <div class="custom-dpc-icon" style="background-color: ${color};">
                        <i class="fas fa-building" style="font-size: 12px;"></i>
                    </div>
                    ${dpc.total_kader > 0 ? `
                        <div style="position: absolute; top: -4px; right: -4px; width: 16px; height: 16px; 
                             background-color: white; border-radius: 50%; border: 1px solid ${color}; 
                             display: flex; align-items: center; justify-content: center;">
                            <span style="font-size: 9px; font-weight: bold; color: ${color};">
                                ${dpc.total_kader || 0}
                            </span>
                        </div>
                    ` : ''}
                    ${!hasCoords ? `
                        <div style="position: absolute; top: -2px; left: -2px; width: 8px; height: 8px; 
                             background-color: #ef4444; border-radius: 50%; border: 1px solid white;">
                        </div>
                    ` : ''}
                </div>
            `,
                    className: 'dpc-marker',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32]
                });

                // Create marker
                const marker = L.marker([lat, lng], {
                        icon
                    })
                    .bindPopup(`
                <div style="font-weight: bold; color: ${color}; margin-bottom: 5px; font-size: 13px;">
                    ${dpc.kecamatan_name}
                </div>
                <div style="font-size: 12px; color: #4b5563; margin-bottom: 3px;">
                    Ketua: ${dpc.ketua || 'Belum ditentukan'}
                </div>
                <div style="font-size: 12px; color: #4b5563; margin-bottom: 3px;">
                    Kader: ${dpc.total_kader || 0} orang
                </div>
                <div style="font-size: 12px; color: #4b5563; margin-bottom: 3px;">
                    DPRT: ${dpc.total_dprt || 0} desa
                </div>
                <div style="font-size: 12px; color: ${dpc.is_active ? '#059669' : '#dc2626'}; margin-bottom: 5px; font-weight: 500;">
                    ${dpc.is_active ? '✓ Aktif' : '✗ Non-Aktif'}
                </div>
                ${!hasCoords ? 
                    '<div style="font-size: 11px; color: #f59e0b; font-style: italic; margin-bottom: 5px;">⚠️ Koordinat belum diisi</div>' 
                    : ''}
                <div style="margin-top: 8px;">
                    <a href="/admin/dpc/${dpc.id}" 
                       style="display: inline-block; background-color: ${color}; color: white; 
                              padding: 4px 8px; border-radius: 4px; font-size: 12px; text-decoration: none; transition: all 0.2s;">
                        <i class="fas fa-external-link-alt" style="margin-right: 4px;"></i>Detail
                    </a>
                </div>
            `);

                dpcMarkers.push(marker);
                layerGroups.dpc.addLayer(marker);
            });

            console.log(`✅ ${dpcMarkers.length} DPC markers added`);
        }


        // 📍 ADD DPRT MARKERS
        // 📍 ADD DPRT MARKERS - DIPERBAIKI (tampilkan semua, bahkan tanpa koordinat)
        function addDprtMarkers(data) {
            if (!data.dprts || !Array.isArray(data.dprts)) return;

            console.log(`📍 Processing ${data.dprts.length} DPRTs...`);

            // Group DPRT by DPC for better distribution
            const dprtsByDpc = {};
            data.dprts.forEach((dprt, index) => {
                const dpcId = dprt.dpc_id || 'unknown';
                if (!dprtsByDpc[dpcId]) {
                    dprtsByDpc[dpcId] = [];
                }
                dprtsByDpc[dpcId].push({
                    dprt,
                    index
                });
            });

            // Add markers with intelligent distribution
            Object.values(dprtsByDpc).forEach(dprtGroup => {
                dprtGroup.forEach(({
                    dprt,
                    index
                }) => {
                    // Gunakan koordinat default yang tersebar jika tidak ada
                    const baseLat = -7.150975;
                    const baseLng = 111.881860;
                    const lat = dprt.latitude ? parseFloat(dprt.latitude) :
                        baseLat + (Math.random() * 0.2 - 0.1);
                    const lng = dprt.longitude ? parseFloat(dprt.longitude) :
                        baseLng + (Math.random() * 0.2 - 0.1);
                    const hasCoords = dprt.latitude && dprt.longitude;

                    // DEBUG: Log DPRT tanpa koordinat
                    if (!hasCoords && index < 5) { // Hanya log 5 pertama
                        console.warn(`⚠️ DPRT ${index}: "${dprt.desa_name}" has no coordinates`);
                    }

                    // Warna berdasarkan status dan apakah ada koordinat
                    let color = '#22c55e'; // default green for active
                    if (!dprt.is_active) {
                        color = '#9ca3af'; // gray for inactive
                    }
                    if (!hasCoords) {
                        color = '#f59e0b'; // orange/yellow for no coordinates
                    }

                    const icon = L.divIcon({
                        html: `
                    <div class="custom-dprt-icon" style="background-color: ${color};">
                        <i class="fas fa-map-pin" style="font-size: 10px;"></i>
                    </div>
                `,
                        className: 'dprt-marker',
                        iconSize: [24, 24],
                        iconAnchor: [12, 24]
                    });

                    const marker = L.marker([lat, lng], {
                            icon
                        })
                        .bindPopup(`
                    <div style="font-weight: bold; color: ${color}; margin-bottom: 5px; font-size: 13px;">
                        ${dprt.desa_name}
                    </div>
                    <div style="font-size: 12px; color: #4b5563; margin-bottom: 3px;">
                        Kecamatan: ${dprt.dpc_name || 'Tidak diketahui'}
                    </div>
                    <div style="font-size: 12px; color: #4b5563; margin-bottom: 3px;">
                        Ketua: ${dprt.ketua || 'Belum ditentukan'}
                    </div>
                    <div style="font-size: 12px; color: #4b5563; margin-bottom: 3px;">
                        Kader: ${dprt.total_kader || 0} orang
                    </div>
                    <div style="font-size: 12px; color: ${dprt.is_active ? '#059669' : '#dc2626'}; margin-bottom: 5px; font-weight: 500;">
                        ${dprt.is_active ? '✓ Aktif' : '✗ Non-Aktif'}
                    </div>
                    ${!hasCoords ? 
                        '<div style="font-size: 11px; color: #f59e0b; font-style: italic; margin-bottom: 5px;">⚠️ Koordinat belum diisi</div>' 
                        : ''}
                    <div style="margin-top: 8px;">
                        <a href="/admin/dprt/${dprt.id}" 
                           style="display: inline-block; background-color: ${color}; color: white; 
                                  padding: 4px 8px; border-radius: 4px; font-size: 12px; text-decoration: none; transition: all 0.2s;">
                            <i class="fas fa-external-link-alt" style="margin-right: 4px;"></i>Detail
                        </a>
                    </div>
                `);

                    dprtMarkers.push(marker);
                    layerGroups.dprt.addLayer(marker);
                });
            });

            console.log(`✅ ${dprtMarkers.length} DPRT markers added`);
        }

        // 🏛️ ADD DPD MARKER
        function addDpdMarker() {
            const marker = L.marker([-7.150975, 111.881860], {
                icon: L.divIcon({
                    html: '<div class="custom-dpd-icon"><i class="fas fa-flag"></i></div>',
                    className: 'dpd-marker',
                    iconSize: [40, 40],
                    iconAnchor: [20, 40]
                })
            }).addTo(map);

            marker.bindPopup(`
            <div style="font-weight: bold; color: #dc2626; margin-bottom: 5px; font-size: 14px;">
                DPD NasDem Kabupaten Bojonegoro
            </div>
            <div style="font-size: 12px; color: #4b5563; margin-bottom: 3px;">
                Alamat: Jl. Dr. Sutomo No. 45, Bojonegoro
            </div>
            <div style="font-size: 12px; color: #4b5563;">
                Telepon: (0353) 881234
            </div>
        `);

            layerGroups.dpd = marker;
            console.log('✅ DPD marker added');
        }

        // 🎛️ SETUP MAP CONTROLS
        function setupMapControls() {
            if (!map) return;

            // Zoom controls
            document.getElementById('zoom-in').addEventListener('click', () => {
                if (map) map.zoomIn();
            });

            document.getElementById('zoom-out').addEventListener('click', () => {
                if (map) map.zoomOut();
            });

            document.getElementById('reset-view').addEventListener('click', () => {
                if (map) map.setView([-7.150975, 111.881860], 10);
            });

            // Map type control
            document.getElementById('map-type').addEventListener('change', function(e) {
                changeMapType(e.target.value);
            });

            console.log('✅ Map controls setup complete');
        }

        // 🎪 SETUP LAYER CONTROLS
        function setupLayerControls() {
            const dataLayerSelect = document.getElementById('data-layer');

            if (!dataLayerSelect) {
                console.warn('⚠️ Data layer select element not found');
                return;
            }

            dataLayerSelect.addEventListener('change', function(e) {
                const selectedLayer = e.target.value;
                currentDataLayer = selectedLayer;
                toggleDataLayers(selectedLayer);

                // Update legend based on selected layer
                updateLegendForLayer(selectedLayer);
            });
            const overlayLayers = {
                "Kabupaten": layerGroups.kabupaten,
                "Kecamatan": layerGroups.kecamatan,
                "Desa": layerGroups.desa,
                "DPC": layerGroups.dpc,
                "DPRT": layerGroups.dprt
            };

            L.control.layers(null, overlayLayers, {
                collapsed: false,
                position: 'topright'
            }).addTo(map);
            console.log('✅ Layer controls setup complete');
        }

        // 👁️ TOGGLE DATA LAYERS - DIPERBAIKI
        // 👁️ TOGGLE DATA LAYERS - DIPERBAIKI untuk selalu tampilkan desa saat mode DPRT
        function toggleDataLayers(layerType) {
            if (!map) return;

            console.log(`🔧 Switching to layer: ${layerType}`);

            // Reset kecamatan view jika sedang aktif
            if (lastClickedKecamatan) {
                resetKecamatanView();
            }

            // Hide all layers first
            if (layerGroups.kabupaten && map.hasLayer(layerGroups.kabupaten)) {
                map.removeLayer(layerGroups.kabupaten);
            }
            if (map.hasLayer(layerGroups.kecamatan)) {
                map.removeLayer(layerGroups.kecamatan);
            }
            if (map.hasLayer(layerGroups.desa)) {
                map.removeLayer(layerGroups.desa);
            }
            if (map.hasLayer(layerGroups.dpc)) {
                map.removeLayer(layerGroups.dpc);
            }
            if (map.hasLayer(layerGroups.dprt)) {
                map.removeLayer(layerGroups.dprt);
            }

            // Show selected layers
            switch (layerType) {
                case 'dpc':
                    if (layerGroups.kabupaten) {
                        map.addLayer(layerGroups.kabupaten);
                    }
                    map.addLayer(layerGroups.kecamatan);
                    map.addLayer(layerGroups.dpc);
                    console.log('✅ Showing DPC layers only');
                    break;

                case 'dprt':
                    // PERBAIKAN: Tampilkan DESA bukan KECAMATAN untuk layer DPRT
                    if (layerGroups.kabupaten) {
                        map.addLayer(layerGroups.kabupaten);
                    }
                    // TAMBAH INI: Pastikan layer desa ditampilkan
                    map.addLayer(layerGroups.desa);
                    map.addLayer(layerGroups.dprt);
                    console.log('✅ Showing DPRT and DESA layers');
                    break;

                case 'kader':
                    if (layerGroups.kabupaten) {
                        map.addLayer(layerGroups.kabupaten);
                    }
                    map.addLayer(layerGroups.kecamatan);
                    map.addLayer(layerGroups.desa);
                    map.addLayer(layerGroups.dpc);
                    map.addLayer(layerGroups.dprt);
                    console.log('✅ Showing all layers for kader distribution');
                    break;

                case 'all':
                default:
                    if (layerGroups.kabupaten) {
                        map.addLayer(layerGroups.kabupaten);
                    }
                    map.addLayer(layerGroups.kecamatan);
                    map.addLayer(layerGroups.desa);
                    map.addLayer(layerGroups.dpc);
                    map.addLayer(layerGroups.dprt);
                    console.log('✅ Showing all layers');
                    break;
            }

            updateActiveLayerIndicator(layerType);
        }

        // 🎨 CHANGE MAP TYPE
        function changeMapType(type) {
            if (!map) return;

            // Jika sama, tidak perlu ganti
            if (currentMapType === type) return;

            console.log(`🔄 Changing map type to: ${type}`);

            let url, attribution, maxZoom;

            switch (type) {
                case 'satellite':
                    url = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
                    attribution = 'Tiles © Esri';
                    maxZoom = 18;
                    break;
                case 'topographic':
                    url = 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png';
                    attribution = 'Map data © OpenStreetMap contributors';
                    maxZoom = 17;
                    break;
                case 'dark':
                    url = 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png';
                    attribution = '© OpenStreetMap, © CARTO';
                    maxZoom = 19;
                    break;
                default: // street
                    url = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                    attribution = '© OpenStreetMap contributors';
                    maxZoom = 19;
            }

            // Remove existing tile layer
            if (currentTileLayer) {
                map.removeLayer(currentTileLayer);
            }

            // Add new tile layer
            currentTileLayer = L.tileLayer(url, {
                attribution: attribution,
                maxZoom: maxZoom,
                minZoom: 8
            }).addTo(map);

            currentMapType = type;
            console.log(`✅ Changed map type to: ${type}`);
        }

        // 📊 UPDATE LEGEND FOR SELECTED LAYER
        function updateLegendForLayer(layerType) {
            const legend = document.getElementById('map-legend');
            if (!legend) return;

            const legendContent = legend.querySelector('.legend-content');
            if (!legendContent) return;

            let newContent = '';

            switch (layerType) {
                case 'dpc':
                    newContent = `
                    <h4 class="font-medium text-gray-900 mb-3">Legenda DPC</h4>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">DPD Pusat</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">DPC Aktif</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-gray-400 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">DPC Non-Aktif</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-100 rounded-full border border-blue-500 mr-2"></div>
                            <span class="text-sm text-gray-700">Wilayah Kecamatan</span>
                        </div>
                    </div>
                `;
                    break;

                case 'dprt':
                    newContent = `
        <h4 class="font-medium text-gray-900 mb-3">Legenda DPRT</h4>
        <div class="space-y-2">
            <div class="flex items-center">
                <div class="w-4 h-4 bg-red-500 rounded-full mr-2"></div>
                <span class="text-sm text-gray-700">DPD Pusat</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-green-500 rounded-full mr-2"></div>
                <span class="text-sm text-gray-700">DPRT Aktif</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-gray-400 rounded-full mr-2"></div>
                <span class="text-sm text-gray-700">DPRT Non-Aktif</span>
            </div>
            <!-- TAMBAH LEGENDA UNTUK BOUNDARIES -->
            <div class="flex items-center">
                <div class="w-4 h-1 bg-[#059669] mr-2"></div>
                <span class="text-sm text-gray-700">Batas Desa</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-1 bg-[#10b981] opacity-50 mr-2"></div>
                <span class="text-sm text-gray-700">Area Desa</span>
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-gray-200">
            <p class="text-xs text-gray-500 mb-2">Interaksi:</p>
            <div class="space-y-1">
                <div class="flex items-center">
                    <div class="w-4 h-4 border-2 border-[#dc2626] mr-2"></div>
                    <span class="text-xs text-gray-600">Hover: Highlight merah</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 border-2 border-[#1d4ed8] mr-2"></div>
                    <span class="text-xs text-gray-600">Klik: Highlight biru</span>
                </div>
            </div>
        </div>
    `;
                    break;

                case 'kader':
                    newContent = `
                    <h4 class="font-medium text-gray-900 mb-3">Legenda Kader</h4>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">DPD Pusat</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">DPC Aktif</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">DPRT Aktif</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-100 rounded-full border border-blue-500 mr-2"></div>
                            <span class="text-sm text-gray-700">Wilayah Kecamatan</span>
                        </div>
                    </div>
                `;
                    break;

                default: // all
                    newContent = `
                    <h4 class="font-medium text-gray-900 mb-3">Legenda Peta</h4>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">DPD Pusat</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">DPC Aktif</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-gray-400 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">DPC Non-Aktif</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">DPRT Aktif</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-100 rounded-full border border-blue-500 mr-2"></div>
                            <span class="text-sm text-gray-700">Wilayah Kecamatan</span>
                        </div>
                    </div>
                `;
            }

            legendContent.innerHTML = newContent;
        }

        // 🎯 UPDATE ACTIVE LAYER INDICATOR
        function updateActiveLayerIndicator(layerType) {
            const dataLayerSelect = document.getElementById('data-layer');
            if (dataLayerSelect) {
                // Reset all options
                Array.from(dataLayerSelect.options).forEach(option => {
                    option.classList.remove('font-bold', 'text-nasdem-red');
                });

                // Highlight active option
                const activeOption = dataLayerSelect.querySelector(`option[value="${layerType}"]`);
                if (activeOption) {
                    activeOption.classList.add('font-bold', 'text-nasdem-red');
                }
            }
        }

        // 📊 UPDATE LEGEND STATISTICS
        function updateLegendStatistics(stats) {
            const legend = document.getElementById('map-legend');
            if (!legend) return;

            // Remove existing stats if any
            const existingStats = legend.querySelector('.legend-stats');
            if (existingStats) {
                existingStats.remove();
            }

            const statsHtml = `
            <div class="legend-stats" style="margin-top: 12px; padding-top: 12px; border-top: 1px solid #e5e7eb;">
                <div style="font-size: 11px; font-weight: 500; color: #374151; margin-bottom: 8px;">
                    Statistik:
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 11px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #6b7280;">DPC:</span>
                        <span style="font-weight: bold;">${stats.dpc_with_coords || 0}/${stats.total_dpc || 0}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #6b7280;">DPRT:</span>
                        <span style="font-weight: bold;">${stats.dprt_with_coords || 0}/${stats.total_dprt || 0}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #6b7280;">Kader:</span>
                        <span style="font-weight: bold;">${stats.total_kader || 0}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #6b7280;">Wilayah:</span>
                        <span style="font-weight: bold;">${stats.total_kecamatan || 0} kec</span>
                    </div>
                </div>
            </div>
            `;

            legend.insertAdjacentHTML('beforeend', statsHtml);
            console.log('✅ Legend statistics updated');
        }

        // Tambahkan fungsi ini setelah fungsi updateLegendStatistics()
        function updateKecamatanLegend(kecamatanName, desaCount) {
            const legend = document.getElementById('map-legend');
            if (!legend) return;

            const legendContent = legend.querySelector('.legend-content');
            if (!legendContent) return;

            const newContent = `
        <h4 class="font-medium text-gray-900 mb-3">Kecamatan ${kecamatanName}</h4>
        <div class="space-y-2">
            <div class="flex items-center">
                <div class="w-4 h-1 bg-[#dc2626] mr-2"></div>
                <span class="text-sm text-gray-700">Batas Kecamatan</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-1 bg-[#1d4ed8] mr-2"></div>
                <span class="text-sm text-gray-700">Batas Desa</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-1 bg-[#60a5fa] opacity-30 mr-2"></div>
                <span class="text-sm text-gray-700">Area Desa</span>
            </div>
        </div>
        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
            <div class="flex items-center justify-between">
                <div class="text-sm font-medium text-blue-700">Total Desa</div>
                <div class="text-lg font-bold text-blue-800">${desaCount}</div>
            </div>
            <div class="mt-2">
                <button onclick="resetKecamatanView()"
                    class="w-full bg-white text-blue-600 hover:bg-blue-50 py-2 px-3 rounded-md text-sm font-medium border border-blue-200 transition-colors">
                    <i class="fas fa-times mr-2"></i>Tutup Tampilan Kecamatan
                </button>
            </div>
        </div>
    `;

            legendContent.innerHTML = newContent;
        }

        // ⚠️ SHOW MAP ERROR
        function showMapError(error) {
            const loadingEl = document.getElementById('map-loading');
            if (!loadingEl) return;

            loadingEl.innerHTML = `
            <div style="text-align: center; padding: 24px;">
                <i class="fas fa-exclamation-triangle" style="color: #ef4444; font-size: 48px; margin-bottom: 12px;"></i>
                <h3 style="font-size: 18px; font-weight: 500; color: #111827; margin-bottom: 8px;">
                    Gagal Memuat Peta
                </h3>
                <p style="color: #6b7280; font-size: 14px; margin-bottom: 16px;">
                    Error: ${error.message || 'Unknown error'}
                </p>
                <button onclick="initMap()" 
                        style="background-color: #1f2937; color: white; padding: 8px 16px; 
                               border-radius: 6px; border: none; cursor: pointer; font-size: 14px;">
                    <i class="fas fa-redo" style="margin-right: 8px;"></i>Coba Lagi
                </button>
            </div>
        `;

            console.error('❌ Map error displayed to user');
        }

        // 🎯 FOCUS ON DPC
        function focusOnDPC(lat, lng, name) {
            if (!map) {
                alert('Peta belum siap. Silakan tunggu sebentar.');
                return;
            }

            const targetLat = parseFloat(lat) || -7.150975;
            const targetLng = parseFloat(lng) || 111.881860;

            // Zoom to location
            map.setView([targetLat, targetLng], 14);

            // Find and open popup
            let found = false;
            dpcMarkers.forEach(marker => {
                const markerLatLng = marker.getLatLng();
                if (Math.abs(markerLatLng.lat - targetLat) < 0.001 &&
                    Math.abs(markerLatLng.lng - targetLng) < 0.001) {
                    marker.openPopup();
                    found = true;
                }
            });

            if (!found) {
                // Show a temporary marker if not found
                const tempMarker = L.marker([targetLat, targetLng])
                    .addTo(map)
                    .bindPopup(`<b>${name}</b><br>Lat: ${lat}, Lng: ${lng}`)
                    .openPopup();

                // Remove after 5 seconds
                setTimeout(() => {
                    map.removeLayer(tempMarker);
                }, 5000);
            }

            // Show notification
            showNotification('info', `Memfokuskan peta ke: ${name}`);
        }

        // 💾 EXPORT MAP DATA
        async function exportMap() {
            try {
                showNotification('info', 'Mengekspor data peta...');

                const response = await fetch(apiUrl);
                if (!response.ok) throw new Error('Gagal mengambil data dari API');

                const data = await response.json();

                const exportData = {
                    metadata: {
                        title: 'Peta GIS Partai NasDem Kabupaten Bojonegoro',
                        exported_at: new Date().toISOString(),
                        center: map ? map.getCenter() : [-7.150975, 111.881860],
                        zoom: map ? map.getZoom() : 10,
                        source: 'NasDem Bojonegoro Admin Panel'
                    },
                    statistics: data.statistics,
                    dpcs: data.dpcs,
                    dprts: data.dprts,
                    summary: {
                        total_dpc: data.statistics.total_dpc,
                        total_dprt: data.statistics.total_dprt,
                        total_kader: data.statistics.total_kader,
                        kecamatan_count: data.statistics.total_kecamatan,
                        export_format: 'JSON v1.0'
                    }
                };

                // Create and trigger download
                const dataStr = 'data:text/json;charset=utf-8,' +
                    encodeURIComponent(JSON.stringify(exportData, null, 2));
                const downloadLink = document.createElement('a');
                downloadLink.setAttribute('href', dataStr);
                downloadLink.setAttribute('download',
                    `peta-nasdem-bojonegoro-${new Date().toISOString().slice(0, 10)}.json`);
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);

                showNotification('success', '✅ Data peta berhasil diekspor!');

            } catch (error) {
                console.error('Export error:', error);
                showNotification('error', '❌ Gagal mengekspor data peta.');
            }
        }


        function focusOnDesa(lat, lng, name) {
            if (!map) {
                alert('Peta belum siap. Silakan tunggu sebentar.');
                return;
            }

            const targetLat = parseFloat(lat) || -7.150975;
            const targetLng = parseFloat(lng) || 111.881860;

            // Zoom lebih dekat untuk desa
            map.setView([targetLat, targetLng], 14);

            // Cari dan highlight boundary desa
            let foundDesa = false;
            layerGroups.desa.eachLayer(function(layer) {
                if (layer.feature && layer.feature.properties) {
                    const desaName = layer.feature.properties.name ||
                        layer.feature.properties.desa_name ||
                        layer.feature.properties.NAMOBJ;

                    if (desaName && desaName.includes(name) || name.includes(desaName)) {
                        // Highlight desa
                        layer.setStyle({
                            weight: 6,
                            color: '#dc2626',
                            opacity: 1,
                            fillOpacity: 0.3,
                            fillColor: '#fca5a5'
                        });

                        // Zoom ke bounds desa
                        if (layer.getBounds) {
                            map.fitBounds(layer.getBounds().pad(0.05));
                        }

                        // Buka popup
                        layer.openPopup();
                        foundDesa = true;

                        // Kembalikan style setelah 5 detik
                        setTimeout(() => {
                            layer.setStyle({
                                weight: 2,
                                color: '#059669',
                                opacity: 0.7,
                                fillOpacity: 0.1,
                                fillColor: '#10b981'
                            });
                        }, 5000);
                    }
                }
            });

            if (!foundDesa) {
                // Jika tidak ditemukan boundary, buat marker sementara
                const tempMarker = L.marker([targetLat, targetLng])
                    .addTo(map)
                    .bindPopup(`<b>${name}</b><br>Pusat desa`)
                    .openPopup();

                setTimeout(() => {
                    map.removeLayer(tempMarker);
                }, 3000);
            }

            showNotification('info', `Memfokuskan peta ke Desa: ${name}`);
        }
        // 🔔 SHOW NOTIFICATION
        function showNotification(type, message, duration = 5000) {
            // Cegah infinite loop dengan cek kondisi
            console.log(`📢 Notification [${type}]: ${message}`);

            // Use the notification system from admin layout if available
            if (typeof window.showNotification === 'function' && window.showNotification !== showNotification) {
                window.showNotification(type, message, duration);
            } else {
                // Fallback dengan alert atau console log
                console.log(`${type.toUpperCase()}: ${message}`);

                // Atau buat notification sederhana jika diperlukan
                createSimpleNotification(type, message, duration);
            }
        }


        // Fungsi bantu untuk membuat notifikasi sederhana
        function createSimpleNotification(type, message, duration) {
            // Hapus notifikasi sebelumnya jika ada
            const existingNotif = document.getElementById('simple-notification');
            if (existingNotif) {
                existingNotif.remove();
            }

            // Buat element notifikasi
            const notif = document.createElement('div');
            notif.id = 'simple-notification';
            notif.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 8px;
        background-color: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        font-weight: 500;
        z-index: 9999;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        animation: slideIn 0.3s ease-out;
    `;

            // Tambahkan style untuk animasi
            const style = document.createElement('style');
            style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    `;
            document.head.appendChild(style);

            notif.innerHTML = `
        <div style="display: flex; align-items: center;">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}" 
               style="margin-right: 10px; font-size: 18px;"></i>
            <span>${message}</span>
        </div>
    `;

            document.body.appendChild(notif);

            // Hapus otomatis setelah durasi
            setTimeout(() => {
                if (notif.parentNode) {
                    notif.style.animation = 'slideOut 0.3s ease-in';
                    setTimeout(() => notif.remove(), 300);
                }
            }, duration);
        }
        // Tambahkan fungsi ini setelah fungsi focusOnDesa()
        function showDesaInKecamatan(kecamatanName) {
            console.log(`📍 Menampilkan desa-desa di Kecamatan: ${kecamatanName}`);

            // Clear previous desa layers
            kecamatanDesaLayers.clearLayers();

            // Tambah layer group ke map jika belum ada
            if (!map.hasLayer(kecamatanDesaLayers)) {
                map.addLayer(kecamatanDesaLayers);
                console.log('✅ Added kecamatanDesaLayers to map');
            }

            // VARIABLE UNTUK MENGHITUNG DESA
            let desaCount = 0;
            let desaBounds = [];

            // Ambil data dari API untuk mendapatkan total desa
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    // Cari kecamatan yang sesuai untuk mendapatkan total_desa
                    const matchingKecamatan = data.geojson?.kecamatans?.find(k => {
                        const kName = k.name.toLowerCase();
                        const searchName = kecamatanName.toLowerCase();
                        return kName.includes(searchName) || searchName.includes(kName);
                    });

                    // Dapatkan total desa dari data API
                    const totalDesaFromApi = matchingKecamatan?.total_desa || 0;

                    console.log(`📊 Total desa dari API untuk ${kecamatanName}: ${totalDesaFromApi}`);

                    // DEBUG: Tampilkan semua desa yang tersedia
                    console.log('📊 === LIST ALL DESA DATA ===');
                    layerGroups.desa.eachLayer(function(desaLayer) {
                        if (desaLayer.feature && desaLayer.feature.properties) {
                            console.log(`🔍 Desa: ${desaLayer.feature.properties.name || desaLayer.feature.properties.desa_name}`);
                            console.log(`   - All properties:`, desaLayer.feature.properties);
                        }
                    });
                    console.log('📊 === END LIST ===');

                    // DEBUG: Hitung total desa yang tersedia
                    let totalDesaLayers = 0;
                    layerGroups.desa.eachLayer(() => totalDesaLayers++);
                    console.log(`📊 Total desa layers available: ${totalDesaLayers}`);

                    // Loop melalui semua desa
                    layerGroups.desa.eachLayer(function(desaLayer) {
                        if (desaLayer.feature && desaLayer.feature.properties) {
                            // Cari semua kemungkinan properti yang mengandung nama kecamatan
                            const properties = desaLayer.feature.properties;
                            const possibleKecamatanFields = [
                                'kecamatan_name',
                                'KECAMATAN',
                                'WADMKC',
                                'kecamatan',
                                'nama_kecamatan',
                                'kec',
                                'kecamatan_id'
                            ];

                            let foundKecamatan = null;

                            // Cari di semua kemungkinan field
                            for (const field of possibleKecamatanFields) {
                                if (properties[field]) {
                                    foundKecamatan = properties[field];
                                    console.log(`🔍 Found kecamatan in field "${field}": ${foundKecamatan}`);
                                    break;
                                }
                            }

                            // Jika tidak ditemukan, coba cari di semua properti
                            if (!foundKecamatan) {
                                // Cari string yang mengandung "kecamatan" atau "KECAMATAN"
                                for (const key in properties) {
                                    if (typeof properties[key] === 'string') {
                                        const value = properties[key].toLowerCase();
                                        if (value.includes('kecamatan') || value.includes('kec')) {
                                            foundKecamatan = properties[key];
                                            console.log(`🔍 Found kecamatan in property "${key}": ${foundKecamatan}`);
                                            break;
                                        }
                                    }
                                }
                            }

                            if (foundKecamatan) {
                                const kecamatanLower = kecamatanName.toLowerCase();
                                const foundKecamatanLower = foundKecamatan.toLowerCase();

                                // Cek kecocokan dengan berbagai metode
                                const isMatch =
                                    foundKecamatanLower.includes(kecamatanLower) ||
                                    kecamatanLower.includes(foundKecamatanLower) ||
                                    foundKecamatanLower === kecamatanLower ||
                                    foundKecamatanLower.replace(/[^a-z]/g, '') === kecamatanLower.replace(/[^a-z]/g, '') ||
                                    similarText(foundKecamatanLower, kecamatanLower) > 0.8;

                                if (isMatch) {
                                    console.log(`✅ Match found! Desa: ${properties.name || properties.desa_name} belongs to Kecamatan: ${foundKecamatan}`);

                                    // Highlight desa dengan style khusus
                                    desaLayer.setStyle({
                                        fillColor: '#60a5fa',
                                        weight: 3,
                                        opacity: 0.8,
                                        color: '#1d4ed8',
                                        fillOpacity: 0.2,
                                        dashArray: null
                                    });

                                    // Tambah ke layer group untuk kontrol
                                    kecamatanDesaLayers.addLayer(desaLayer);
                                    desaCount++;

                                    // Kumpulkan bounds untuk zoom
                                    if (desaLayer.getBounds) {
                                        desaBounds.push(desaLayer.getBounds());
                                    }

                                    // Update popup desa untuk menunjukkan kecamatan
                                    desaLayer.bindPopup(`
                        <div style="font-weight: bold; color: #1d4ed8; margin-bottom: 8px; font-size: 14px;">
                            Desa ${properties.name || properties.desa_name || 'Tidak ada nama'}
                        </div>
                        <div style="font-size: 12px; color: #4b5563; margin-bottom: 5px;">
                            <i class="fas fa-map-marker-alt mr-2"></i>Kecamatan: ${foundKecamatan}
                        </div>
                        <div style="font-size: 12px; color: #4b5563; margin-bottom: 5px;">
                            <i class="fas fa-hashtag mr-2"></i>Kode BPS: ${properties.kode_bps || properties.KD_BPS || '-'}
                        </div>
                        <div style="margin-top: 10px;">
                            <button onclick="focusOnDesa(${properties.center?.[0] || -7.15}, 
                                                         ${properties.center?.[1] || 111.88}, 
                                                         '${properties.name || properties.desa_name || ''}')"
                                style="background-color: #3b82f6; color: white; padding: 5px 10px; 
                                       border-radius: 4px; border: none; cursor: pointer; font-size: 12px;">
                                <i class="fas fa-search-location mr-1"></i>Fokus ke Desa
                            </button>
                        </div>
                    `);

                                    // Highlight desa dengan efek khusus
                                    desaLayer.bringToFront();

                                    // Tampilkan desa secara visual
                                    if (!map.hasLayer(layerGroups.desa)) {
                                        console.log('⚠️ Layer desa is NOT visible on map - adding it');
                                        map.addLayer(layerGroups.desa);
                                    }
                                } else {
                                    console.log(`❌ No match: "${foundKecamatan}" ≠ "${kecamatanName}"`);
                                }
                            } else {
                                console.log(`⚠️ No kecamatan data found for desa: ${properties.name || properties.desa_name}`);
                            }
                        }
                    });

                    // Update legenda dengan data dari API
                    updateKecamatanLegend(kecamatanName, totalDesaFromApi);

                    // Zoom ke semua desa jika ada
                    if (desaBounds.length > 0) {
                        const groupBounds = L.latLngBounds(desaBounds);
                        map.fitBounds(groupBounds.pad(0.05));
                        console.log('✅ Zoomed to desa bounds');
                    } else {
                        console.log('⚠️ No desa bounds found for zooming');
                        // Coba tambahkan debug tambahan untuk melihat data API
                        debugApiData(kecamatanName);
                    }

                    // Tampilkan jumlah desa yang ditemukan vs dari API
                    console.log(`📊 Desa ditemukan: ${desaCount}, Dari API: ${totalDesaFromApi}`);

                    console.log(`✅ Finished showing desa in kecamatan`);
                })
                .catch(error => {
                    console.error('Error fetching API data:', error);
                    // Fallback: gunakan desaCount yang dihitung
                    updateKecamatanLegend(kecamatanName, desaCount);
                });
        }

        // Fungsi bantu untuk menghitung similarity
        function similarText(str1, str2) {
            str1 = str1.toLowerCase().replace(/[^a-z]/g, '');
            str2 = str2.toLowerCase().replace(/[^a-z]/g, '');

            if (str1 === str2) return 1.0;

            const len1 = str1.length;
            const len2 = str2.length;
            const maxLen = Math.max(len1, len2);

            let matches = 0;
            for (let i = 0; i < maxLen; i++) {
                if (str1[i] === str2[i]) matches++;
            }

            return matches / maxLen;
        }

        // Fungsi untuk debug data API
        function debugApiData(kecamatanName) {
            console.log('🔍 Debugging API data for kecamatan:', kecamatanName);

            // Ambil data dari API lagi untuk debug
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    console.log('📊 API Data Analysis:');
                    console.log('Kecamatan from API:', data.geojson?.kecamatans?.map(k => k.name));
                    console.log('Desa from API (first 5):', data.geojson?.desas?.slice(0, 5).map(d => ({
                        name: d.name,
                        kecamatan: d.kecamatan_name,
                        properties: Object.keys(d)
                    })));

                    // Cari kecamatan yang cocok
                    const matchingKecamatan = data.geojson?.kecamatans?.find(k =>
                        k.name.toLowerCase().includes(kecamatanName.toLowerCase()) ||
                        kecamatanName.toLowerCase().includes(k.name.toLowerCase())
                    );

                    if (matchingKecamatan) {
                        console.log('✅ Found matching kecamatan in API:', matchingKecamatan);
                    } else {
                        console.log('❌ No matching kecamatan found in API');
                        console.log('Available kecamatan names:', data.geojson?.kecamatans?.map(k => k.name));
                    }
                })
                .catch(error => console.error('Error fetching API data:', error));
        }


        function resetKecamatanView() {
            console.log('🔄 Mereset tampilan kecamatan');

            // Reset style kecamatan yang diklik
            if (lastClickedKecamatanLayer) {
                lastClickedKecamatanLayer.setStyle({
                    weight: 2.5,
                    color: '#1d4ed8',
                    opacity: 0.8,
                    fillOpacity: 0.05,
                    fillColor: '#3b82f6',
                    dashArray: '5, 5'
                });
            }

            // Reset style semua desa
            layerGroups.desa.eachLayer(function(desaLayer) {
                desaLayer.setStyle({
                    weight: 2,
                    color: '#059669',
                    opacity: 0.7,
                    fillOpacity: 0.1,
                    fillColor: '#10b981'
                });
            });

            // Clear layer group
            kecamatanDesaLayers.clearLayers();

            // Reset state
            lastClickedKecamatan = null;
            lastClickedKecamatanLayer = null;

            // Reset legend
            updateLegendForLayer(currentDataLayer);

            // Tampilkan notifikasi
            showNotification('info', 'Tampilan kecamatan direset');
        }

        // 📄 INITIALIZE WHEN DOM IS READY
        document.addEventListener('DOMContentLoaded', function() {
            console.log('📄 DOM Content Loaded');

            // Initialize map with a small delay to ensure everything is ready
            setTimeout(() => {
                initMap();
            }, 300);
        });
    </script>
    @endpush
    @endsection