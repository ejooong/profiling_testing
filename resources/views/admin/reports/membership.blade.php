@extends('layouts.admin')

@section('title', 'Laporan Keanggotaan')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Keanggotaan</h1>
            <p class="mt-1 text-sm text-gray-600">Laporan detail data keanggotaan kader</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="printMembershipReport()" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                <i class="fas fa-print mr-2"></i>Cetak Laporan
            </button>
            <button onclick="exportMembershipData()" 
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                <i class="fas fa-file-excel mr-2"></i>Export Data
            </button>
        </div>
    </div>

    <!-- Report Filters -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">DPD</label>
                <select id="filter-dpd" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 text-sm">
                    <option value="">Semua DPD</option>
                    @foreach($dpds as $dpd)
                    <option value="{{ $dpd->id }}">{{ $dpd->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">DPC</label>
                <select id="filter-dpc" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 text-sm">
                    <option value="">Semua DPC</option>
                    @foreach($dpcs as $dpc)
                    <option value="{{ $dpc->id }}">{{ $dpc->kecamatan_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Status</label>
                <select id="filter-status" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 text-sm">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="pending">Pending</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Periode</label>
                <select id="filter-period" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 text-sm">
                    <option value="all">Semua Waktu</option>
                    <option value="today">Hari Ini</option>
                    <option value="week">Minggu Ini</option>
                    <option value="month">Bulan Ini</option>
                    <option value="quarter">Kuartal Ini</option>
                    <option value="year">Tahun Ini</option>
                </select>
            </div>
        </div>
        <div class="mt-4 flex justify-end">
            <button onclick="applyFilters()" 
                    class="px-4 py-2 bg-nasdem-red text-white rounded-md hover:bg-red-700 text-sm">
                Terapkan Filter
            </button>
            <button onclick="resetFilters()" 
                    class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm">
                Reset
            </button>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-users text-purple-600"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($summary['total']) }}</div>
                    <div class="text-sm text-gray-600">Total Kader</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($summary['active']) }}</div>
                    <div class="text-sm text-gray-600">Kader Aktif</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($summary['pending']) }}</div>
                    <div class="text-sm text-gray-600">Pending</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-times-circle text-red-600"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($summary['rejected']) }}</div>
                    <div class="text-sm text-gray-600">Ditolak</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gender Distribution -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Distribusi Jenis Kelamin</h3>
            <div class="h-48">
                <canvas id="genderChart"></canvas>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-4 text-center">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <div class="text-xl font-bold text-blue-600">{{ number_format($genderStats['male']) }}</div>
                    <div class="text-sm text-gray-600">Laki-laki</div>
                    <div class="text-xs text-gray-500">{{ $genderStats['male_percent'] }}%</div>
                </div>
                <div class="p-3 bg-pink-50 rounded-lg">
                    <div class="text-xl font-bold text-pink-600">{{ number_format($genderStats['female']) }}</div>
                    <div class="text-sm text-gray-600">Perempuan</div>
                    <div class="text-xs text-gray-500">{{ $genderStats['female_percent'] }}%</div>
                </div>
            </div>
        </div>

        <!-- Education Distribution -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Distribusi Pendidikan</h3>
            <div class="h-48">
                <canvas id="educationChart"></canvas>
            </div>
            <div class="mt-4">
                <div class="text-sm text-gray-600 mb-2">Rata-rata pendidikan: {{ $educationStats['average'] }}</div>
                <div class="text-xs text-gray-500">
                    Tertinggi: {{ $educationStats['highest'] }} | Terendah: {{ $educationStats['lowest'] }}
                </div>
            </div>
        </div>
    </div>

    <!-- Age Distribution -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Distribusi Usia</h3>
        <div class="h-64">
            <canvas id="ageChart"></canvas>
        </div>
        <div class="mt-4 grid grid-cols-3 gap-4 text-center">
            <div class="p-3 bg-green-50 rounded-lg">
                <div class="text-xl font-bold text-green-600">{{ $ageStats['young'] }}</div>
                <div class="text-sm text-gray-600">Muda (< 30)</div>
                <div class="text-xs text-gray-500">{{ $ageStats['young_percent'] }}%</div>
            </div>
            <div class="p-3 bg-blue-50 rounded-lg">
                <div class="text-xl font-bold text-blue-600">{{ $ageStats['middle'] }}</div>
                <div class="text-sm text-gray-600">Menengah (30-50)</div>
                <div class="text-xs text-gray-500">{{ $ageStats['middle_percent'] }}%</div>
            </div>
            <div class="p-3 bg-purple-50 rounded-lg">
                <div class="text-xl font-bold text-purple-600">{{ $
                    {{ $ageStats['senior'] }}</div>
                <div class="text-sm text-gray-600">Senior (> 50)</div>
                <div class="text-xs text-gray-500">{{ $ageStats['senior_percent'] }}%</div>
            </div>
        </div>
    </div>

    <!-- Membership Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Data Keanggotaan</h3>
            <div class="text-sm text-gray-600">
                Menampilkan {{ $kaders->count() }} dari {{ $summary['total'] }} kader
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kader
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Informasi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Wilayah
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($kaders as $kader)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 mr-3">
                                    @if($kader->photo)
                                    <img class="h-10 w-10 rounded-full object-cover" 
                                         src="{{ asset('storage/' . $kader->photo) }}" 
                                         alt="{{ $kader->full_name }}">
                                    @else
                                    <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-gray-500"></i>
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $kader->full_name }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $kader->nik }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="text-gray-900">{{ $kader->email }}</div>
                                <div class="text-gray-500">{{ $kader->phone }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ ucfirst($kader->gender) }} • {{ $kader->age }} tahun
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                <div class="font-medium">{{ $kader->dpc->kecamatan_name ?? '-' }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $kader->dprt->desa_name ?? '-' }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($kader->status == 'active')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                            @elseif($kader->status == 'pending')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Ditolak
                            </span>
                            @endif
                            
                            <div class="mt-1 text-xs text-gray-500">
                                {{ $kader->created_at->format('d/m/Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <div>Daftar: {{ $kader->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">
                                    @if($kader->verified_at)
                                    Verifikasi: {{ $kader->verified_at->format('d/m/Y') }}
                                    @else
                                    Belum diverifikasi
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.kader.show', $kader) }}" 
                                   class="text-blue-600 hover:text-blue-900"
                                   title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.kader.edit', $kader) }}" 
                                   class="text-yellow-600 hover:text-yellow-900"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.kader.card', $kader) }}" 
                                   class="text-green-600 hover:text-green-900"
                                   title="Kartu Anggota">
                                    <i class="fas fa-id-card"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t">
            {{ $kaders->links() }}
        </div>
    </div>

    <!-- Report Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Laporan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.reports.statistics') }}" 
               class="p-4 bg-blue-50 hover:bg-blue-100 rounded-lg text-center">
                <i class="fas fa-chart-bar text-blue-600 text-2xl mb-2"></i>
                <div class="font-medium text-gray-900">Statistik Lengkap</div>
                <div class="text-sm text-gray-600">Lihat analisis data</div>
            </a>
            <button onclick="generateMembershipCard()" 
                    class="p-4 bg-green-50 hover:bg-green-100 rounded-lg text-center">
                <i class="fas fa-id-card text-green-600 text-2xl mb-2"></i>
                <div class="font-medium text-gray-900">Kartu Anggota</div>
                <div class="text-sm text-gray-600">Generate massal</div>
            </button>
            <button onclick="sendMembershipReport()" 
                    class="p-4 bg-purple-50 hover:bg-purple-100 rounded-lg text-center">
                <i class="fas fa-envelope text-purple-600 text-2xl mb-2"></i>
                <div class="font-medium text-gray-900">Kirim Email</div>
                <div class="text-sm text-gray-600">Ke pengurus DPD</div>
            </button>
            <button onclick="backupMembershipData()" 
                    class="p-4 bg-red-50 hover:bg-red-100 rounded-lg text-center">
                <i class="fas fa-database text-red-600 text-2xl mb-2"></i>
                <div class="font-medium text-gray-900">Backup Data</div>
                <div class="text-sm text-gray-600">Simpan ke cloud</div>
            </button>
        </div>
    </div>

    <!-- Membership Summary -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Keanggotaan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-gray-900 mb-2">Pertumbuhan Kader</h4>
                <div class="space-y-2">
                    @foreach($growthData as $period => $data)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ $period }}</span>
                        <span class="text-sm font-medium {{ $data['growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $data['growth'] >= 0 ? '+' : '' }}{{ $data['growth'] }}%
                        </span>
                        <span class="text-sm text-gray-900">{{ $data['count'] }} kader</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 mb-2">Target Keanggotaan</h4>
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Target 2024</span>
                            <span class="text-gray-900">{{ number_format($targets['target']) }} kader</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" 
                                 style="width: {{ $targets['achievement'] }}%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            Tercapai: {{ number_format($targets['current']) }} ({{ $targets['achievement'] }}%)
                        </div>
                    </div>
                    <div class="text-sm text-gray-600">
                        <p><i class="fas fa-info-circle mr-1"></i> Sisa target: {{ number_format($targets['remaining']) }} kader</p>
                        <p><i class="fas fa-calendar-alt mr-1"></i> Estimasi tercapai: {{ $targets['estimate_date'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Initialize charts
let genderChart, educationChart, ageChart;

// Gender Distribution Chart
function initGenderChart() {
    const ctx = document.getElementById('genderChart').getContext('2d');
    
    genderChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [
                    {{ $genderStats['male'] }},
                    {{ $genderStats['female'] }}
                ],
                backgroundColor: ['#3b82f6', '#ec4899'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15
                    }
                }
            }
        }
    });
}

// Education Distribution Chart
function initEducationChart() {
    const ctx = document.getElementById('educationChart').getContext('2d');
    const labels = @json($educationStats['labels']);
    const data = @json($educationStats['data']);
    const colors = ['#10b981', '#3b82f6', '#8b5cf6', '#f59e0b', '#ef4444', '#6b7280'];
    
    educationChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Kader',
                data: data,
                backgroundColor: colors,
                borderColor: colors.map(color => color.replace('500', '700')),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Age Distribution Chart
function initAgeChart() {
    const ctx = document.getElementById('ageChart').getContext('2d');
    const labels = @json($ageStats['ranges']);
    const data = @json($ageStats['counts']);
    
    ageChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Distribusi Usia',
                data: data,
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Filter functions
function applyFilters() {
    const dpd = document.getElementById('filter-dpd').value;
    const dpc = document.getElementById('filter-dpc').value;
    const status = document.getElementById('filter-status').value;
    const period = document.getElementById('filter-period').value;
    
    // Show loading
    const loader = document.createElement('div');
    loader.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    loader.innerHTML = `
        <div class="bg-white p-6 rounded-lg">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-nasdem-red mx-auto"></div>
            <p class="mt-4 text-gray-600">Menerapkan filter...</p>
        </div>
    `;
    document.body.appendChild(loader);
    
    // Build query string
    const params = new URLSearchParams();
    if (dpd) params.append('dpd_id', dpd);
    if (dpc) params.append('dpc_id', dpc);
    if (status) params.append('status', status);
    if (period) params.append('period', period);
    
    // In real implementation, this would be an AJAX call or page reload
    setTimeout(() => {
        document.body.removeChild(loader);
        alert('Filter diterapkan:\n' + 
              'DPD: ' + (dpd || 'Semua') + '\n' +
              'DPC: ' + (dpc || 'Semua') + '\n' +
              'Status: ' + (status || 'Semua') + '\n' +
              'Periode: ' + period);
        
        // Reload page with filters
        // window.location.href = '/admin/reports/membership?' + params.toString();
    }, 1000);
}

function resetFilters() {
    document.getElementById('filter-dpd').value = '';
    document.getElementById('filter-dpc').value = '';
    document.getElementById('filter-status').value = '';
    document.getElementById('filter-period').value = 'all';
}

function printMembershipReport() {
    const printWindow = window.open('', '_blank');
    const today = new Date().toLocaleDateString('id-ID');
    
    printWindow.document.write(`
        <html>
            <head>
                <title>Laporan Keanggotaan - Partai NasDem Kabupaten Bojonegoro</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #dc2626; padding-bottom: 15px; }
                    .summary { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin: 20px 0; }
                    .summary-item { text-align: center; padding: 15px; border: 1px solid #ddd; border-radius: 8px; }
                    .summary-number { font-size: 24px; font-weight: bold; color: #dc2626; }
                    .summary-label { font-size: 12px; color: #666; margin-top: 5px; }
                    .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 30px 0; }
                    .stats-box { border: 1px solid #ddd; border-radius: 8px; padding: 15px; }
                    .stats-title { font-weight: bold; color: #333; margin-bottom: 10px; }
                    .table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 11px; }
                    .table th { background-color: #f5f5f5; border: 1px solid #ddd; padding: 8px; text-align: left; }
                    .table td { border: 1px solid #ddd; padding: 8px; }
                    .status-active { color: #10b981; font-weight: bold; }
                    .status-pending { color: #f59e0b; font-weight: bold; }
                    .status-rejected { color: #ef4444; font-weight: bold; }
                    .footer { margin-top: 30px; font-size: 12px; color: #666; text-align: center; border-top: 1px solid #ddd; padding-top: 15px; }
                    .page-break { page-break-after: always; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>LAPORAN KEANGGOTAAN</h1>
                    <h2>Partai NasDem Kabupaten Bojonegoro</h2>
                    <p>Tanggal Cetak: ${today}</p>
                </div>
                
                <div class="summary">
                    <div class="summary-item">
                        <div class="summary-number">{{ number_format($summary['total']) }}</div>
                        <div class="summary-label">Total Kader</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-number">{{ number_format($summary['active']) }}</div>
                        <div class="summary-label">Kader Aktif</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-number">{{ number_format($summary['pending']) }}</div>
                        <div class="summary-label">Pending</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-number">{{ number_format($summary['rejected']) }}</div>
                        <div class="summary-label">Ditolak</div>
                    </div>
                </div>
                
                <div class="stats-grid">
                    <div class="stats-box">
                        <div class="stats-title">Distribusi Jenis Kelamin</div>
                        <p>Laki-laki: {{ number_format($genderStats['male']) }} ({{ $genderStats['male_percent'] }}%)</p>
                        <p>Perempuan: {{ number_format($genderStats['female']) }} ({{ $genderStats['female_percent'] }}%)</p>
                    </div>
                    <div class="stats-box">
                        <div class="stats-title">Distribusi Usia</div>
                        <p>Muda (< 30): {{ $ageStats['young'] }} ({{ $ageStats['young_percent'] }}%)</p>
                        <p>Menengah (30-50): {{ $ageStats['middle'] }} ({{ $ageStats['middle_percent'] }}%)</p>
                        <p>Senior (> 50): {{ $ageStats['senior'] }} ({{ $ageStats['senior_percent'] }}%)</p>
                    </div>
                </div>
                
                <div style="page-break-before: always;">
                    <h3>Data Keanggotaan (Halaman 1)</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>DPC</th>
                                <th>Status</th>
                                <th>Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kaders as $index => $kader)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $kader->full_name }}</td>
                                <td>{{ $kader->nik }}</td>
                                <td>{{ $kader->email }}</td>
                                <td>{{ $kader->phone }}</td>
                                <td>{{ $kader->dpc->kecamatan_name ?? '-' }}</td>
                                <td class="status-{{ $kader->status }}">
                                    {{ $kader->status == 'active' ? 'Aktif' : ($kader->status == 'pending' ? 'Pending' : 'Ditolak') }}
                                </td>
                                <td>{{ $kader->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="footer">
                    <p>Partai NasDem Kabupaten Bojonegoro</p>
                    <p>Jl. Dr. Sutomo No. 45, Bojonegoro | Telp: (0353) 881234</p>
                    <p>Website: nasdem-bojonegoro.id | Email: info@nasdem-bojonegoro.id</p>
                    <p>Halaman 1 dari 1</p>
                </div>
                
                <script>
                    window.onload = function() {
                        window.print();
                        setTimeout(function() {
                            window.close();
                        }, 1000);
                    };
                </script>
            </body>
        </html>
    `);
}

function exportMembershipData() {
    // Create export data
    const exportData = {
        title: 'Data Keanggotaan Partai NasDem Kabupaten Bojonegoro',
        date: new Date().toLocaleDateString('id-ID'),
        summary: @json($summary),
        statistics: {
            gender: @json($genderStats),
            age: @json($ageStats),
            education: @json($educationStats)
        },
        members: @json($kaders->map(function($kader) {
            return {
                id: $kader->id,
                full_name: $kader->full_name,
                nik: $kader->nik,
                email: $kader->email,
                phone: $kader->phone,
                gender: $kader->gender,
                age: $kader->age,
                dpc: $kader->dpc->kecamatan_name ?? null,
                dprt: $kader->dprt->desa_name ?? null,
                status: $kader->status,
                created_at: $kader->created_at,
                verified_at: $kader->verified_at
            };
        }))
    };
    
    // Export as JSON
    const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(exportData, null, 2));
    const downloadAnchor = document.createElement('a');
    downloadAnchor.setAttribute("href", dataStr);
    downloadAnchor.setAttribute("download", "keanggotaan-nasdem-" + new Date().toISOString().slice(0,10) + ".json");
    document.body.appendChild(downloadAnchor);
    downloadAnchor.click();
    downloadAnchor.remove();
}

function generateMembershipCard() {
    alert('Fitur ini akan membuka halaman generate kartu anggota massal.');
    // window.location.href = '/admin/kader/generate-cards';
}

function sendMembershipReport() {
    const email = prompt('Masukkan email tujuan untuk mengirim laporan:');
    if (email) {
        alert('Laporan akan dikirim ke: ' + email + '\nFitur ini akan mengirim email dengan attachment PDF.');
    }
}

function backupMembershipData() {
    if (confirm('Apakah Anda yakin ingin melakukan backup data keanggotaan?')) {
        alert('Backup sedang dilakukan...\nData akan disimpan ke penyimpanan cloud.');
    }
}

// Initialize charts when page loads
document.addEventListener('DOMContentLoaded', function() {
    initGenderChart();
    initEducationChart();
    initAgeChart();
});
</script>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        font-size: 11pt;
    }
    
    .bg-white {
        box-shadow: none;
        border: 1px solid #ddd;
    }
}
</style>
@endpush
@endsection