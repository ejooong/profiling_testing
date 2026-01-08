<?php

namespace App\Http\Controllers\Admin\Kader;

use App\Http\Controllers\Controller;
use App\Models\Kader\Kader;
use App\Models\DPC\Dpc;
use App\Models\DPRT\Dprt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KaderController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua data untuk filter
        $dpds = \App\Models\DPD\DPD::where('is_active', true)->get();
        $dpcs = \App\Models\DPC\Dpc::where('is_active', true)->get();

        // Query kader dengan filter
        $query = Kader::with(['dpc', 'dprt']);

        // Filter berdasarkan DPD (jika ada model DPD)
        if ($request->filled('dpd_id')) {
            $query->whereHas('dpc', function ($q) use ($request) {
                $q->where('dpd_id', $request->dpd_id);
            });
        }

        // Filter berdasarkan DPC
        if ($request->filled('dpc_id')) {
            $query->where('dpc_id', $request->dpc_id);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $kaders = $query->paginate(20);

        // Hitung statistik
        $totalKader = Kader::count();
        $activeKader = Kader::where('status', 'active')->count();
        $pendingKader = Kader::where('status', 'pending')->count();
        $rejectedKader = Kader::where('status', 'rejected')->count();

        return view('admin.kader.index', compact(
            'kaders',
            'dpds',
            'dpcs',
            'totalKader',
            'activeKader',
            'pendingKader',
            'rejectedKader'
        ));
    }
    public function create()
    {
        $dpds = \App\Models\DPD\Dpd::where('is_active', true)->get(); // ← TAMBAHKAN INI
        $dpcs = Dpc::where('is_active', true)->get();
        $dprts = Dprt::where('is_active', true)->get();

        return view('admin.kader.create', compact('dpds', 'dpcs', 'dprts')); // ← TAMBAHKAN $dpds
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dpc_id' => 'required|exists:dpc,id',
            'dprt_id' => 'required|exists:dprt,id',
            'nik' => 'required|string|size:16|unique:kaders,nik',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:kaders,email',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:male,female,L,P',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'profession' => 'required|string|max:100',
            'education' => 'required|string|max:100',
            'join_date' => 'required|date',
            'status' => 'required|in:active,pending,non_active',
            'position_in_party' => 'nullable|string|max:100',
            'skills' => 'nullable|string',
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Tambah ini
        ]);

        // Handle photo upload
        if ($request->hasFile('photo_path')) {
            $path = $request->file('photo_path')->store('kader/photos', 'public');
            $validated['photo_path'] = $path;
        }

        $validated['is_verified'] = $validated['status'] === 'active';

        if ($validated['is_verified']) {
            $validated['verified_at'] = now();
            $validated['verified_by'] = auth()->id();
        }

        Kader::create($validated);

        return redirect()->route('admin.kader.index')
            ->with('success', 'Kader berhasil ditambahkan.');
    }

    public function show(Kader $kader)
    {
        return view('admin.kader.show', compact('kader'));
    }

    public function edit(Kader $kader)
    {
        $dpcs = Dpc::where('is_active', true)->get();
        $dprts = Dprt::where('is_active', true)->get();
        return view('admin.kader.edit', compact('kader', 'dpcs', 'dprts'));
    }

    public function update(Request $request, Kader $kader)
    {
        $validated = $request->validate([
            'dpc_id' => 'required|exists:dpc,id',
            'dprt_id' => 'required|exists:dprt,id',
            'nik' => 'required|string|size:16|unique:kaders,nik,' . $kader->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:kaders,email,' . $kader->id,
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:L,P',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'profession' => 'required|string|max:100',
            'education' => 'required|string|max:100',
            'join_date' => 'required|date',
            'status' => 'required|in:active,pending,non_active',
            'position_in_party' => 'nullable|string|max:100',
            'skills' => 'nullable|string',
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Tambah validasi untuk foto
        ]);

        // Handle photo upload
        if ($request->hasFile('photo_path')) {
            // Hapus foto lama jika ada
            if ($kader->photo_path) {
                Storage::delete('public/' . $kader->photo_path);
            }

            // Upload foto baru
            $path = $request->file('photo_path')->store('kader/photos', 'public');
            $validated['photo_path'] = $path;
        }

        // Handle remove photo checkbox
        if ($request->has('remove_photo') && $request->remove_photo == '1') {
            if ($kader->photo_path) {
                Storage::delete('public/' . $kader->photo_path);
            }
            $validated['photo_path'] = null;
        }

        // Update verification status
        if ($validated['status'] === 'active' && !$kader->is_verified) {
            $validated['is_verified'] = true;
            $validated['verified_at'] = now();
            $validated['verified_by'] = auth()->id();
        } elseif ($validated['status'] !== 'active') {
            $validated['is_verified'] = false;
            $validated['verified_at'] = null;
            $validated['verified_by'] = null;
        }

        $kader->update($validated);

        return redirect()->route('admin.kader.index')
            ->with('success', 'Kader berhasil diperbarui.');
    }

    public function destroy(Kader $kader)
    {
        $kader->delete();

        return redirect()->route('admin.kader.index')
            ->with('success', 'Kader berhasil dihapus.');
    }

    public function verify(Request $request, Kader $kader)
    {
        $request->validate([
            'status' => 'required|in:active,rejected'
        ]);

        $kader->update([
            'is_verified' => $request->status === 'active',
            'verified_at' => $request->status === 'active' ? now() : null,
            'verified_by' => $request->status === 'active' ? auth()->id() : null,
            'status' => $request->status,
        ]);

        $message = $request->status === 'active'
            ? 'Kader berhasil diverifikasi'
            : 'Kader berhasil ditolak';

        return redirect()->route('admin.kader.index')
            ->with('success', $message);
    }
    public function toggleVerification(Kader $kader)
    {
        $kader->update([
            'is_verified' => !$kader->is_verified,
            'verified_at' => $kader->is_verified ? null : now(),
            'verified_by' => $kader->is_verified ? null : auth()->id(),
            'status' => $kader->is_verified ? 'pending' : 'active'
        ]);

        $message = $kader->is_verified ? 'Kader berhasil diverifikasi' : 'Verifikasi kader dibatalkan';
        return back()->with('success', $message);
    }

    public function toggleActive(Kader $kader)
    {
        $status = $kader->status === 'active' ? 'non_active' : 'active';
        $kader->update(['status' => $status]);

        $message = $status === 'active' ? 'Kader diaktifkan' : 'Kader dinonaktifkan';
        return back()->with('success', $message);
    }

    public function printCard(Kader $kader)
    {
        return view('admin.kader.print-card', compact('kader'));
    }

    public function getData(Kader $kader)
    {
        $kader->load(['dpc', 'dprt', 'verifier']);

        return response()->json([
            'id' => $kader->id,
            'name' => $kader->name,
            'nik' => $kader->nik,
            'email' => $kader->email,
            'phone' => $kader->phone,
            'gender' => $kader->gender,
            'birth_place' => $kader->birth_place,
            'birth_date' => $kader->birth_date,
            'address' => $kader->address,
            'rt' => $kader->rt,
            'rw' => $kader->rw,
            'kelurahan' => $kader->kelurahan,
            'kecamatan' => $kader->kecamatan,
            'profession' => $kader->profession,
            'education' => $kader->education,
            'photo_path' => $kader->photo_path,
            'status' => $kader->status,
            'join_date' => $kader->join_date,
            'skills' => $kader->skills,
            'position_in_party' => $kader->position_in_party,
            'is_verified' => $kader->is_verified,
            'verified_at' => $kader->verified_at,
            'verified_by' => $kader->verified_by,
            'created_at' => $kader->created_at,
            'updated_at' => $kader->updated_at,
            'dpc' => $kader->dpc ? [
                'id' => $kader->dpc->id,
                'kecamatan_name' => $kader->dpc->kecamatan_name,
                'kode_bps' => $kader->dpc->kode_bps,
            ] : null,
            'dprt' => $kader->dprt ? [
                'id' => $kader->dprt->id,
                'desa_name' => $kader->dprt->desa_name,
            ] : null,
            'verifier' => $kader->verifier ? [
                'id' => $kader->verifier->id,
                'name' => $kader->verifier->name,
            ] : null,
        ]);
    }

    
}
