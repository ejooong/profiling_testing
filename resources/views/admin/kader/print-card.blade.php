{{-- resources/views/admin/kader/print-card.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Kader - {{ $kader->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .print-button {
                display: none !important;
            }

            .page-break {
                page-break-before: always;
            }

            .card {
                width: 85mm !important;
                height: 54mm !important;
                margin: 0;
                page-break-inside: avoid;
            }

            .card-container {
                display: flex !important;
                flex-wrap: wrap !important;
                gap: 2mm !important;
                justify-content: center !important;
            }
        }

        .card {
            width: 85mm;
            height: 54mm;
            border-radius: 4px;
            overflow: hidden;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .navy-blue {
            background-color: #001f3f;
        }

        .navy-blue-light {
            background-color: #0a3069;
        }

        .navy-blue-text {
            color: #001f3f;
        }

        .text-navy {
            color: #001f3f;
        }

        .bg-navy {
            background-color: #001f3f;
        }

        .bg-navy-light {
            background-color: #0a3069;
        }

        .border-navy {
            border-color: #001f3f;
        }
    </style>
</head>

<body class="bg-gray-100 p-4">
    <!-- Print Button -->
    <div class="print-button mb-4 text-center">
        <button onclick="window.print()"
            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold inline-flex items-center">
            <i class="fas fa-print mr-2"></i> Cetak Kartu
        </button>
        <a href="{{ route('admin.kader.show', $kader) }}"
            class="ml-4 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <!-- Card Design -->
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 card-container">
            <!-- Front of Card -->
            <div class="card bg-gradient-to-b from-blue-900 to-blue-800 text-white rounded-lg shadow-lg border border-blue-700 relative">
                <!-- Header -->
                <div class="flex justify-between items-start p-3 border-b border-blue-700">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider opacity-90">KARTU ANGGOTA</div>
                        <h1 class="text-lg font-bold mt-1">PARTAI NASDEM</h1>
                    </div>
                    <div class="text-right">
                        <div class="text-xs opacity-90">DPD KAB. BOJONEGORO</div>
                        <div class="text-xs font-mono mt-1">ID: KDR-{{ str_pad($kader->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>

                <!-- Photo and Info -->
                <div class="flex items-center p-3">
                    <div class="w-16 h-20 bg-white rounded border border-blue-600 overflow-hidden mr-3">
                        @if($kader->photo_path)
                        <img src="{{ Storage::url($kader->photo_path) }}"
                            alt="{{ $kader->name }}"
                            class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-user text-blue-400 text-xl"></i>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h2 class="font-bold text-base mb-1 leading-tight">{{ strtoupper($kader->name) }}</h2>
                        <div class="text-xs mb-1 opacity-90">NIK: {{ $kader->nik }}</div>
                        <div class="text-xs opacity-90">{{ $kader->dpc->kecamatan_name ?? 'DPC' }}</div>
                    </div>
                </div>

                <!-- Card Number -->
                <div class="px-3 py-2 bg-blue-950/50">
                    <div class="text-center font-mono text-sm tracking-widest font-bold">
                        @php
                        $cardNumber = '3214' . str_pad($kader->id, 4, '0', STR_PAD_LEFT) . '6000' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
                        $formattedCardNumber = substr($cardNumber, 0, 4) . ' ' . substr($cardNumber, 4, 4) . ' ' . substr($cardNumber, 8, 4) . ' ' . substr($cardNumber, 12, 4);
                        @endphp
                        {{ $formattedCardNumber }}
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center text-xs p-2 border-t border-blue-700">
                    <div class="flex justify-between px-2">
                        <span>Bergabung: {{ $kader->join_date->format('d/m/Y') }}</span>
                        <span>Status: {{ $kader->status == 'active' ? 'AKTIF' : 'NON-AKTIF' }}</span>
                    </div>
                    <div class="mt-1 text-[10px] opacity-80">
                        Berlaku hingga: {{ $kader->card_expiry ? $kader->card_expiry->format('d/m/Y') : '31/12/2029' }}
                    </div>
                </div>

                <!-- Simple Pattern -->
                <div class="absolute bottom-1 right-1 opacity-10">
                    <div class="text-xs font-bold">NASDEM</div>
                </div>
            </div>

            <!-- Back of Card -->
            <div class="card bg-white border-2 border-blue-200 rounded-lg shadow-lg p-2">
                <h3 class="text-blue-900 font-bold text-[13px] mb-1 text-center border-b border-blue-100 pb-1">INFORMASI KADER</h3>

                <!-- Compact Information Layout -->
                <div class="space-y-0.5 text-[10px] compact-text">
                    <div class="flex">
                        <div class="w-1/3 text-blue-800 font-medium pr-1">Alamat</div>
                        <div class="w-2/3 text-blue-900">{{ $kader->address }}</div>
                    </div>
                    <div class="flex">
                        <div class="w-1/3 text-blue-800 font-medium pr-1">Telepon</div>
                        <div class="w-2/3 text-blue-900">{{ $kader->phone }}</div>
                    </div>
                    <div class="flex">
                        <div class="w-1/3 text-blue-800 font-medium pr-1">Email</div>
                        <div class="w-2/3 text-blue-900 break-all">{{ $kader->email }}</div>
                    </div>
                    <div class="flex">
                        <div class="w-1/3 text-blue-800 font-medium pr-1">Profesi</div>
                        <div class="w-2/3 text-blue-900">{{ $kader->profession }}</div>
                    </div>
                    <div class="flex">
                        <div class="w-1/3 text-blue-800 font-medium pr-1">Pendidikan</div>
                        <div class="w-2/3 text-blue-900">{{ $kader->education }}</div>
                    </div>
                    <div class="flex">
                        <div class="w-1/3 text-blue-800 font-medium pr-1">Jabatan</div>
                        <div class="w-2/3 text-blue-900 font-semibold">{{ $kader->position_in_party ?? 'Anggota' }}</div>
                    </div>
                </div>
                <!-- Signature -->
                <div class="mt-3 text-center text-[10px] text-blue-700">
                    <div class="border-t border-blue-300 pt-1 inline-block px-3">
                        <div class="font-bold">Ketua DPC {{ $kader->dpc->kecamatan_name ?? 'KECAMATAN' }}</div>
                        <div class="text-[9px] italic">Partai NasDem Kab. Bojonegoro</div>
                    </div>
                </div>

                <!-- Website -->
                <div class="text-center text-[9px] text-blue-600 mt-2 font-semibold">
                    www.partainasdem.id
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-800">
            <div class="flex items-start">
                <i class="fas fa-info-circle mt-1 mr-3 text-blue-600"></i>
                <div>
                    <strong>Petunjuk Cetak:</strong>
                    <ul class="mt-1 list-disc list-inside">
                        <li>Klik tombol "Cetak Kartu" di atas</li>
                        <li>Atur ukuran kertas ke A4 atau sesuai dengan ukuran kartu (85mm x 54mm)</li>
                        <li>Atur margin ke minimum (0.5cm atau None)</li>
                        <li>Centang "Background graphics" di print options</li>
                        <li>Gunakan kertas tebal untuk hasil terbaik</li>
                        <li>Untuk kartu ganda, cetak dua kartu dalam satu halaman</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Multiple Cards for Printing -->
        <div class="mt-6 hidden print:block">
            <div class="text-center text-sm text-gray-600 mb-2">Halaman ini akan muncul saat mencetak</div>
            <div class="grid grid-cols-2 gap-4">
                @for($i = 0; $i < 4; $i++)
                    <div class="page-break-inside-avoid">
                    <!-- Duplicate front card -->
                    <div class="card bg-gradient-to-b from-blue-900 to-blue-800 text-white rounded-lg shadow border border-blue-700 relative mx-auto">
                        <div class="flex justify-between items-start p-3 border-b border-blue-700">
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-wider opacity-90">KARTU ANGGOTA</div>
                                <h1 class="text-lg font-bold mt-1">PARTAI NASDEM</h1>
                            </div>
                            <div class="text-right">
                                <div class="text-xs opacity-90">DPD KAB. BOJONEGORO</div>
                                <div class="text-xs font-mono mt-1">ID: KDR-{{ str_pad($kader->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                        <div class="flex items-center p-3">
                            <div class="w-16 h-20 bg-white rounded border border-blue-600 overflow-hidden mr-3">
                                @if($kader->photo_path)
                                <img src="{{ Storage::url($kader->photo_path) }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-user text-blue-400 text-xl"></i>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h2 class="font-bold text-base mb-1 leading-tight">{{ strtoupper($kader->name) }}</h2>
                                <div class="text-xs mb-1 opacity-90">NIK: {{ $kader->nik }}</div>
                                <div class="text-xs opacity-90">{{ $kader->dpc->kecamatan_name ?? 'DPC' }}</div>
                            </div>
                        </div>
                        <div class="px-3 py-2 bg-blue-950/50">
                            <div class="text-center font-mono text-sm tracking-widest font-bold">{{ $formattedCardNumber }}</div>
                        </div>
                        <div class="text-center text-xs p-2 border-t border-blue-700">
                            <div class="flex justify-between px-2">
                                <span>Bergabung: {{ $kader->join_date->format('d/m/Y') }}</span>
                                <span>Status: AKTIF</span>
                            </div>
                        </div>
                    </div>
            </div>
            @endfor
        </div>
    </div>
    </div>

    <script>
        // Auto-print jika diakses dengan parameter ?print=1
        if (window.location.search.includes('print=1')) {
            window.print();
        }

        // Format tanggal Indonesia
        function formatDate(date) {
            const options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };
            return new Date(date).toLocaleDateString('id-ID', options);
        }

        // Optimasi untuk cetak
        document.addEventListener('DOMContentLoaded', function() {
            // Tambahkan event listener untuk tombol print
            document.querySelector('button[onclick="window.print()"]').addEventListener('click', function() {
                // Tambahkan class untuk optimasi cetak
                document.body.classList.add('printing');
                setTimeout(() => {
                    document.body.classList.remove('printing');
                }, 1000);
            });
        });
    </script>
</body>

</html>