<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Kader\Kader;
use App\Models\DPC\Dpc;
use App\Models\DPRT\Dprt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KaderController extends Controller
{
    public function create()
    {
        $dpcs = Dpc::where('is_active', true)->get();
        return view('front.kader.register', compact('dpcs'));
    }

    public function store(Request $request)
    {
        // Debug: Tampilkan semua input
        Log::info('Registration Form Data:', $request->all());

        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:kaders,nik',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:kaders,email',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:L,P',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date|before:today',
            'address' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'profession' => 'required|string|max:100',
            'education' => 'required|string|max:100',
            'dpc_id' => 'required|exists:dpc,id',
            'dprt_id' => 'required|exists:dprt,id',
            'join_date' => 'required|date|before_or_equal:today',
            'terms' => 'required|accepted',
        ], [
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
            'terms.required' => 'Anda harus mencentang persetujuan.',
            'nik.size' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'dpc_id.exists' => 'DPC tidak valid.',
            'dprt_id.exists' => 'DPRT tidak valid.',
        ]);

        // Tambahkan field tambahan
        $validated['status'] = 'pending';
        $validated['is_verified'] = false;

        // Jika ada user login, simpan user_id
        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        try {
            // Simpan data kader
            $kader = Kader::create($validated);

            // Debug: Tampilkan data yang disimpan
            Log::info('Kader Created Successfully:', $kader->toArray());

            // Check if request is AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pendaftaran berhasil! Status Anda akan diverifikasi oleh admin melalui proses interview.'
                ], 200);
            }

            // For regular form submission
            return redirect()->route('kader.register')
                ->with('success', 'Pendaftaran berhasil! Status Anda akan diverifikasi oleh admin melalui proses interview.');
        } catch (\Exception $e) {
            Log::error('Error creating kader: ' . $e->getMessage());

            // Check if request is AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }
}
