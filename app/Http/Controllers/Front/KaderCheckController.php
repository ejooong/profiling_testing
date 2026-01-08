<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Kader\Kader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KaderCheckController extends Controller
{
    /**
     * Show check status form
     */
   public function checkForm()
{
    return view('front.kader.check');
}

/**
 * Check kader status by NIK
 */
public function checkStatus(Request $request)
{
    $request->validate([
        'nik' => 'required|string|size:16|regex:/^[0-9]{16}$/',
    ], [
        'nik.size' => 'NIK harus 16 digit angka.',
        'nik.regex' => 'NIK harus berupa angka.',
    ]);

    $nik = $request->input('nik');

    try {
        $kader = Kader::where('nik', $nik)->first();

        if (!$kader) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan. Pastikan NIK yang dimasukkan benar atau Anda telah mendaftar.'
                ], 404);
            }

            return back()->withErrors([
                'nik' => 'Data tidak ditemukan. Pastikan NIK yang dimasukkan benar atau Anda telah mendaftar.'
            ])->withInput();
        }

        // Load relationships
        $kader->load(['dpc', 'dprt']);

        $statusInfo = [
            'pending' => [
                'title' => 'Menunggu Verifikasi',
                'description' => 'Pendaftaran Anda telah diterima dan sedang dalam proses verifikasi.',
                'steps' => [
                    'Admin akan memverifikasi data Anda dalam 1-3 hari kerja',
                    'Anda akan dihubungi untuk jadwal wawancara',
                    'Siapkan dokumen pendukung (KTP asli, foto 3x4)',
                    'Status akan berubah menjadi "Aktif" setelah verifikasi'
                ]
            ],
            'active' => [
                'title' => 'Kader Aktif',
                'description' => 'Selamat! Anda adalah kader aktif Partai NasDem Bojonegoro.',
                'steps' => [
                    'Kartu anggota dapat diambil di sekretariat DPC',
                    'Anda dapat mengikuti kegiatan dan pelatihan',
                    'Akses informasi internal kader tersedia',
                    'Partisipasi dalam program partai'
                ]
            ],
            'rejected' => [
                'title' => 'Pendaftaran Ditolak',
                'description' => 'Mohon maaf, pendaftaran Anda tidak dapat diproses.',
                'steps' => [
                    'Data tidak memenuhi persyaratan',
                    'Hubungi admin untuk informasi lebih lanjut',
                    'Anda dapat mendaftar ulang dengan data yang benar',
                    'Konsultasi dengan tim kader'
                ]
            ],
            'inactive' => [
                'title' => 'Non-Aktif',
                'description' => 'Status keanggotaan Anda saat ini tidak aktif.',
                'steps' => [
                    'Hubungi admin untuk mengaktifkan kembali',
                    'Perbarui data diri jika diperlukan',
                    'Ikuti prosedur reaktivasi',
                    'Konfirmasi keanggotaan'
                ]
            ]
        ];

        $statusData = $statusInfo[$kader->status] ?? $statusInfo['pending'];

        $responseData = [
            'success' => true,
            'kader' => $kader,
            'status_info' => $statusData,
            'verification_status' => $kader->is_verified ? 'Terverifikasi' : 'Belum Terverifikasi',
            'verification_date' => $kader->verified_at ? $kader->verified_at->format('d F Y') : null,
            'formatted_data' => [
                'join_date' => $kader->join_date->format('d F Y'),
                'birth_date' => $kader->birth_date->format('d F Y'),
                'created_at' => $kader->created_at->format('d F Y H:i'),
                'updated_at' => $kader->updated_at->format('d F Y H:i'),
            ]
        ];

        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($responseData);
        }

        // For regular form submission
        return view('front.kader.check-result', $responseData);

    } catch (\Exception $e) {
        Log::error('Error checking kader status: ' . $e->getMessage());

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memeriksa status. Silakan coba lagi.'
            ], 500);
        }

        return back()->withErrors([
            'error' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
        ])->withInput();
    }
}
}
