@extends('layouts.admin')

@section('title', 'Edit DPC: ' . $dpc->kecamatan_name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit DPC</h1>
            <p class="mt-1 text-sm text-gray-600">Edit data: {{ $dpc->kecamatan_name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.dpc.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="{{ route('admin.dpc.update', $dpc) }}" method="POST" id="dpc-form">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>

                    <div class="space-y-6">
                        <!-- DPD Selection -->
                        <div>
                            <label for="dpd_id" class="block text-sm font-medium text-gray-700 mb-2">DPD Induk *</label>
                            <select name="dpd_id"
                                id="dpd_id"
                                required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                <option value="">Pilih DPD</option>
                                @foreach($dpds as $dpd)
                                <option value="{{ $dpd->id }}" {{ old('dpd_id', $dpc->dpd_id) == $dpd->id ? 'selected' : '' }}>
                                    {{ $dpd->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('dpd_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kecamatan Name -->
                        <div>
                            <label for="kecamatan_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kecamatan *</label>
                            <input type="text"
                                name="kecamatan_name"
                                id="kecamatan_name"
                                value="{{ old('kecamatan_name', $dpc->kecamatan_name) }}"
                                required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('kecamatan_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                            <textarea name="address"
                                id="address"
                                rows="3"
                                required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('address', $dpc->address) }}</textarea>
                            @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telepon *</label>
                                <input type="text"
                                    name="phone"
                                    id="phone"
                                    value="{{ old('phone', $dpc->phone) }}"
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email', $dpc->email) }}"
                                    required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leadership -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pimpinan DPC</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Ketua -->
                        <div>
                            <label for="ketua" class="block text-sm font-medium text-gray-700 mb-2">Ketua</label>
                            <input type="text"
                                name="ketua"
                                id="ketua"
                                value="{{ old('ketua', $dpc->ketua) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('ketua')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sekretaris -->
                        <div>
                            <label for="sekretaris" class="block text-sm font-medium text-gray-700 mb-2">Sekretaris</label>
                            <input type="text"
                                name="sekretaris"
                                id="sekretaris"
                                value="{{ old('sekretaris', $dpc->sekretaris) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('sekretaris')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bendahara -->
                        <div>
                            <label for="bendahara" class="block text-sm font-medium text-gray-700 mb-2">Bendahara</label>
                            <input type="text"
                                name="bendahara"
                                id="bendahara"
                                value="{{ old('bendahara', $dpc->bendahara) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            @error('bendahara')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Statistics & Location -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Statistics -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik</h3>

                        <div class="space-y-4">
                            <div>
                                <label for="total_kader" class="block text-sm font-medium text-gray-700 mb-2">Total Kader</label>
                                <input type="number"
                                    name="total_kader"
                                    id="total_kader"
                                    value="{{ old('total_kader', $dpc->total_kader) }}"
                                    min="0"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('total_kader')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="total_dprt" class="block text-sm font-medium text-gray-700 mb-2">Total DPRT</label>
                                <input type="number"
                                    name="total_dprt"
                                    id="total_dprt"
                                    value="{{ old('total_dprt', $dpc->total_dprt) }}"
                                    min="0"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                @error('total_dprt')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Koordinat Lokasi</h3>

                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                                    <input type="text"
                                        name="latitude"
                                        id="latitude"
                                        value="{{ old('latitude', $dpc->latitude) }}"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                    @error('latitude')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                                    <input type="text"
                                        name="longitude"
                                        id="longitude"
                                        value="{{ old('longitude', $dpc->longitude) }}"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                    @error('longitude')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Map Container untuk Pick Location -->
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700">Pilih Lokasi di Peta</label>
                                    <div class="flex space-x-2">
                                        <button type="button"
                                            id="get-location-btn"
                                            class="text-xs bg-blue-100 text-blue-600 hover:bg-blue-200 px-2 py-1 rounded flex items-center">
                                            <i class="fas fa-location-arrow mr-1"></i>Lokasi Saya
                                        </button>
                                        <button type="button"
                                            id="reset-map-btn"
                                            class="text-xs bg-gray-100 text-gray-600 hover:bg-gray-200 px-2 py-1 rounded flex items-center">
                                            <i class="fas fa-globe-asia mr-1"></i>Pusat Peta
                                        </button>
                                    </div>
                                </div>

                                <!-- Map Container -->
                                <div id="location-map" class="h-64 rounded-lg border border-gray-300 overflow-hidden relative">
                                    <div id="map-loading" class="absolute inset-0 flex items-center justify-center bg-gray-100 z-10">
                                        <div class="text-center">
                                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-nasdem-red mx-auto"></div>
                                            <p class="mt-2 text-sm text-gray-600">Memuat peta...</p>
                                        </div>
                                    </div>
                                    <div id="map-preview" class="absolute inset-0"></div>
                                </div>

                                <div class="mt-2 flex justify-between items-center text-xs text-gray-500">
                                    <div>
                                        <span id="current-coordinates" class="font-mono">
                                            @if($dpc->latitude && $dpc->longitude)
                                            Lat: {{ $dpc->latitude }}, Lng: {{ $dpc->longitude }}
                                            @else
                                            Klik peta untuk memilih lokasi
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button type="button"
                                            id="copy-coords-btn"
                                            class="text-blue-600 hover:text-blue-800 flex items-center">
                                            <i class="fas fa-copy mr-1"></i>Salin
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-1 text-xs text-gray-400">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Klik peta untuk menempatkan marker, atau drag marker untuk memindahkan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description"
                        id="description"
                        rows="4"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ old('description', $dpc->description) }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <div class="flex items-center">
                        <input type="checkbox"
                            name="is_active"
                            id="is_active"
                            value="1"
                            {{ old('is_active', $dpc->is_active) ? 'checked' : '' }}
                            class="h-4 w-4 text-nasdem-red focus:ring-red-200 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 text-sm text-gray-700">DPC Aktif</label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Nonaktifkan jika DPC sedang tidak beroperasi</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-between">
                <div>
                    <button type="button"
                        id="delete-btn"
                        class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700 flex items-center">
                        <i class="fas fa-trash mr-2"></i>Hapus DPC
                    </button>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.dpc.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 flex items-center">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-nasdem-red text-white rounded-md text-sm font-medium hover:bg-red-700 flex items-center">
                        <i class="fas fa-save mr-2"></i>Update DPC
                    </button>
                </div>
            </div>
        </form>

        <!-- Delete Form -->
        <form id="delete-form" action="{{ route('admin.dpc.destroy', $dpc) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map-preview {
        z-index: 1;
    }

    /* Loading animation */
    .animate-spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>
@endpush
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // SEDERHANAKAN kode untuk menghindari error
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🔄 Loading map system...');

        // Tunggu sedikit agar DOM benar-benar siap
        setTimeout(initializeMapSystem, 800);
    });

    function initializeMapSystem() {
        try {
            // Cek jika container sudah ada
            const mapContainer = document.getElementById('map-preview');
            if (!mapContainer) {
                console.error('❌ Map container not found');
                return;
            }

            // Cek jika map sudah diinisialisasi
            if (window.mapInitialized) {
                console.log('⚠️ Map already initialized, skipping...');
                return;
            }

            // Get coordinates
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');

            // Default coordinates for Bojonegoro
            const DEFAULT_LAT = -7.150975;
            const DEFAULT_LNG = 111.881860;

            let initialLat = DEFAULT_LAT;
            let initialLng = DEFAULT_LNG;

            // Parse current coordinates if available
            if (latInput && latInput.value) {
                const lat = parseFloat(latInput.value);
                if (!isNaN(lat)) initialLat = lat;
            }

            if (lngInput && lngInput.value) {
                const lng = parseFloat(lngInput.value);
                if (!isNaN(lng)) initialLng = lng;
            }

            console.log(`📍 Using coordinates: ${initialLat}, ${initialLng}`);

            // Initialize Leaflet
            delete L.Icon.Default.prototype._getIconUrl;
            L.Icon.Default.mergeOptions({
                iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
                iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
            });

            // Create map
            const map = L.map('map-preview', {
                center: [initialLat, initialLng],
                zoom: 12,
                zoomControl: true,
                scrollWheelZoom: true
            });

            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            // Create custom icon
            const customIcon = L.divIcon({
                html: '<div style="width:36px;height:36px;background:#dc2626;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3);"><i class="fas fa-map-marker-alt"></i></div>',
                iconSize: [36, 36],
                iconAnchor: [18, 36]
            });

            // Add marker
            let marker = L.marker([initialLat, initialLng], {
                icon: customIcon,
                draggable: true
            }).addTo(map);

            // Bind popup
            marker.bindPopup(`
                <div style="font-family:monospace;font-size:11px;padding:4px 8px;">
                    <strong>Lokasi DPC</strong><br>
                    Lat: ${initialLat.toFixed(6)}<br>
                    Lng: ${initialLng.toFixed(6)}<br>
                    <small>Drag untuk memindahkan</small>
                </div>
            `).openPopup();

            // Update coordinates when marker is moved
            marker.on('dragend', function(e) {
                const pos = marker.getLatLng();
                updateCoordinates(pos.lat, pos.lng);
                marker.getPopup().setContent(`
                    <div style="font-family:monospace;font-size:11px;padding:4px 8px;">
                        <strong>Lokasi DPC</strong><br>
                        Lat: ${pos.lat.toFixed(6)}<br>
                        Lng: ${pos.lng.toFixed(6)}<br>
                        <small>Drag untuk memindahkan</small>
                    </div>
                `);
            });

            // Click on map to move marker
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateCoordinates(e.latlng.lat, e.latlng.lng);
                marker.getPopup().setContent(`
                    <div style="font-family:monospace;font-size:11px;padding:4px 8px;">
                        <strong>Lokasi DPC</strong><br>
                        Lat: ${e.latlng.lat.toFixed(6)}<br>
                        Lng: ${e.latlng.lng.toFixed(6)}<br>
                        <small>Drag untuk memindahkan</small>
                    </div>
                `).openPopup();
            });

            // Initial coordinate update
            updateCoordinates(initialLat, initialLng);

            // Setup buttons
            setupButtons(map, marker);

            // Hide loading
            const loadingEl = document.getElementById('map-loading');
            if (loadingEl) {
                loadingEl.style.display = 'none';
            }

            // Mark as initialized
            window.mapInitialized = true;
            console.log('✅ Map system initialized successfully');

        } catch (error) {
            console.error('❌ Map initialization error:', error);
            showMapError();
        }
    }

    function updateCoordinates(lat, lng) {
        const formattedLat = lat.toFixed(6);
        const formattedLng = lng.toFixed(6);

        // Update inputs
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        if (latInput) latInput.value = formattedLat;
        if (lngInput) lngInput.value = formattedLng;

        // Update display
        const display = document.getElementById('current-coordinates');
        if (display) {
            display.textContent = `Lat: ${formattedLat}, Lng: ${formattedLng}`;
        }
    }

    function setupButtons(map, marker) {
        // Get current location
        const getLocationBtn = document.getElementById('get-location-btn');
        if (getLocationBtn) {
            getLocationBtn.addEventListener('click', function() {
                if (!navigator.geolocation) {
                    alert('Browser tidak mendukung geolocation');
                    return;
                }

                const btn = this;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Mendeteksi...';
                btn.disabled = true;

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        marker.setLatLng([lat, lng]);
                        updateCoordinates(lat, lng);
                        map.setView([lat, lng], 14);

                        // Current location marker
                        const currentIcon = L.divIcon({
                            html: '<div style="width:32px;height:32px;background:#3b82f6;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;border:2px solid white;"><i class="fas fa-user"></i></div>',
                            iconSize: [32, 32],
                            iconAnchor: [16, 32]
                        });

                        L.marker([lat, lng], {
                                icon: currentIcon
                            }).addTo(map)
                            .bindPopup('Lokasi Anda saat ini')
                            .openPopup();

                        btn.innerHTML = originalText;
                        btn.disabled = false;
                        alert('Lokasi berhasil dideteksi!');
                    },
                    function(error) {
                        alert('Gagal mendapatkan lokasi: ' + error.message);
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                );
            });
        }

        // Reset map view
        const resetBtn = document.getElementById('reset-map-btn');
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                const pos = marker.getLatLng();
                map.setView([pos.lat, pos.lng], 12);
            });
        }

        // Copy coordinates
        const copyBtn = document.getElementById('copy-coords-btn');
        if (copyBtn) {
            copyBtn.addEventListener('click', function() {
                const lat = document.getElementById('latitude').value;
                const lng = document.getElementById('longitude').value;

                if (!lat || !lng) {
                    alert('Koordinat masih kosong');
                    return;
                }

                const text = `${lat}, ${lng}`;
                navigator.clipboard.writeText(text)
                    .then(() => alert('Koordinat disalin: ' + text))
                    .catch(() => {
                        // Fallback
                        const textarea = document.createElement('textarea');
                        textarea.value = text;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textarea);
                        alert('Koordinat disalin: ' + text);
                    });
            });
        }

        // Delete confirmation
        const deleteBtn = document.getElementById('delete-btn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function(e) {
                if (!confirm('Yakin ingin menghapus DPC ini?')) {
                    e.preventDefault();
                }
            });
        }
    }

    function showMapError() {
        const loadingEl = document.getElementById('map-loading');
        if (loadingEl) {
            loadingEl.innerHTML = `
                <div class="text-center p-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-2"></i>
                    <p class="text-gray-700">Gagal memuat peta</p>
                    <button onclick="location.reload()" 
                            class="mt-2 px-3 py-1 bg-red-500 text-white rounded text-sm">
                        Muat Ulang
                    </button>
                </div>
            `;
        }
    }
</script>
@endpush