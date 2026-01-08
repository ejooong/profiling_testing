@extends('layouts.admin')

@section('title', 'Peta GIS Fullscreen')

@section('content')
<div class="h-screen flex flex-col">
    <!-- Map Controls -->
    <div class="bg-white shadow p-4 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Peta GIS Kabupaten Bojonegoro</h1>
            <p class="text-sm text-gray-600">Mode Fullscreen</p>
        </div>
        <div class="flex space-x-2">
            <button onclick="window.history.back()" 
                    class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </button>
        </div>
    </div>
    
    <!-- Map Container -->
    <div class="flex-1 relative">
        <div id="map" class="absolute inset-0"></div>
        
        <!-- Loading -->
        <div id="map-loading" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-90 z-10">
            <div class="text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-nasdem-red mx-auto"></div>
                <p class="mt-4 text-gray-600">Memuat peta...</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let map;

function initMap() {
    // Center on Bojonegoro
    map = L.map('map').setView([-7.150975, 111.881860], 11);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Load data via API
    fetch('{{ route("admin.gis.api.data") }}')
        .then(response => response.json())
        .then(data => {
            // Add DPC markers
            data.dpcs.forEach(dpc => {
                if (dpc.latitude && dpc.longitude) {
                    L.marker([dpc.latitude, dpc.longitude])
                        .bindPopup(`
                            <div class="font-bold">${dpc.kecamatan_name}</div>
                            <div class="text-sm">Ketua: ${dpc.ketua || 'Belum ditentukan'}</div>
                            <div class="text-sm">Kader: ${dpc.total_kader} orang</div>
                            <div class="mt-2">
                                <a href="/admin/dpc/${dpc.id}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-external-link-alt mr-1"></i>Detail
                                </a>
                            </div>
                        `)
                        .addTo(map);
                }
            });
            
            // Hide loading
            document.getElementById('map-loading').style.display = 'none';
        })
        .catch(error => {
            console.error('Error loading map data:', error);
            document.getElementById('map-loading').innerHTML = `
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-red-400 text-3xl mb-3"></i>
                    <p class="text-red-600">Gagal memuat data peta</p>
                    <button onclick="location.reload()" 
                            class="mt-3 px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                        Muat Ulang
                    </button>
                </div>
            `;
        });
}

// Initialize map when page loads
document.addEventListener('DOMContentLoaded', initMap);
</script>
@endpush
@endsection