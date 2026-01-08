<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Kader\Kader;
use App\Models\DPC\Dpc;
use App\Models\DPRT\Dprt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MembershipController extends Controller
{
    /**
     * Show check status form
     */
    public function check()
    {
        return view('front.membership.check');
    }

    /**
     * Check membership status
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'type' => 'required|in:nik,email'
        ]);

        $identifier = $request->input('identifier');
        $type = $request->input('type');

        try {
            $kader = Kader::where($type, $identifier)->first();

            if (!$kader) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data tidak ditemukan. Pastikan NIK/Email yang dimasukkan benar.'
                    ], 404);
                }

                return back()->withErrors([
                    'identifier' => 'Data tidak ditemukan. Pastikan NIK/Email yang dimasukkan benar.'
                ])->withInput();
            }

            // Load relationships
            $kader->load(['dpc', 'dprt']);

            $responseData = [
                'success' => true,
                'data' => [
                    'name' => $kader->name,
                    'nik' => $kader->nik,
                    'email' => $kader->email,
                    'phone' => $kader->phone,
                    'gender' => $kader->gender == 'L' ? 'Laki-laki' : 'Perempuan',
                    'status' => $kader->status,
                    'is_verified' => $kader->is_verified,
                    'join_date' => $kader->join_date->format('d F Y'),
                    'created_at' => $kader->created_at->format('d F Y H:i'),
                    'updated_at' => $kader->updated_at->format('d F Y H:i'),
                    'profession' => $kader->profession,
                    'education' => $kader->education,
                    'address' => $kader->address,
                    'rt' => $kader->rt,
                    'rw' => $kader->rw,
                    'kelurahan' => $kader->kelurahan,
                    'kecamatan' => $kader->kecamatan,
                    'birth_place' => $kader->birth_place,
                    'birth_date' => $kader->birth_date->format('d F Y'),
                    'dpc_name' => $kader->dpc->kecamatan_name ?? 'N/A',
                    'dprt_name' => $kader->dprt->desa_name ?? 'N/A',
                ]
            ];

            // Check if request is AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($responseData);
            }

            // For regular form submission
            return view('front.membership.check', [
                'result' => $kader,
                'searched' => true
            ]);

        } catch (\Exception $e) {
            Log::error('Error checking membership status: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memeriksa status.'
                ], 500);
            }

            return back()->withErrors([
                'error' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ])->withInput();
        }
    }

    /**
     * Verify membership (from email link or manual verification)
     */
    public function verify(Request $request)
    {
        // Implementation for verification process
        return view('front.membership.verify');
    }
}