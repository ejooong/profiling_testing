<?php

namespace App\Http\Controllers\Admin\DPC;

use App\Http\Controllers\Controller;
use App\Models\DPD\Dpd;
use App\Models\DPC\Dpc;
use App\Models\DPC\DpcStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DpcController extends Controller
{
    public function index(Request $request) // <-- Tambahkan parameter Request
    {
        // Ambil semua DPD untuk filter
        $dpds = Dpd::all();

        // Query dasar
        $query = Dpc::with('dpd');

        // Filter berdasarkan DPD jika ada
        if ($request->filled('dpd_id')) {
            $query->where('dpd_id', $request->dpd_id);
        }

        // Filter berdasarkan status jika ada
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter berdasarkan pencarian jika ada
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kecamatan_name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('ketua', 'like', "%{$search}%")
                    ->orWhere('sekretaris', 'like', "%{$search}%")
                    ->orWhere('bendahara', 'like', "%{$search}%");
            });
        }

        $dpcs = $query->paginate(20)->withQueryString();

        // Hitung statistik
        $totalDpc = Dpc::count();
        $activeDpc = Dpc::where('is_active', true)->count();
        $inactiveDpc = Dpc::where('is_active', false)->count();
        $totalKader = Dpc::sum('total_kader');

        return view('admin.dpc.index', compact(
            'dpcs',
            'dpds',
            'totalDpc',
            'activeDpc',
            'inactiveDpc',
            'totalKader'
        ));
    }

    public function create()
    {
        $dpds = Dpd::all(); // <-- Ganti menjadi all() untuk dropdown
        return view('admin.dpc.create', compact('dpds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dpd_id' => 'required|exists:dpd,id',
            'kecamatan_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'ketua' => 'nullable|string|max:255',
            'sekretaris' => 'nullable|string|max:255',
            'bendahara' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['kecamatan_name']);
        $validated['is_active'] = true;

        Dpc::create($validated);

        return redirect()->route('admin.dpc.index')
            ->with('success', 'DPC berhasil dibuat.');
    }

    public function show(Dpc $dpc)
    {
        return view('admin.dpc.show', compact('dpc'));
    }

    public function edit(Dpc $dpc)
    {
        $dpds = Dpd::all(); // <-- Ganti menjadi all() untuk dropdown
        return view('admin.dpc.edit', compact('dpc', 'dpds'));
    }

    public function update(Request $request, Dpc $dpc)
    {
        $validated = $request->validate([
            'dpd_id' => 'required|exists:dpd,id', // <-- TAMBAHKAN INI
            'kecamatan_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'ketua' => 'nullable|string|max:255',
            'sekretaris' => 'nullable|string|max:255',
            'bendahara' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['kecamatan_name']);

        $dpc->update($validated);

        return redirect()->route('admin.dpc.index')
            ->with('success', 'DPC berhasil diperbarui.');
    }

    public function destroy(Dpc $dpc)
    {
        $dpc->delete();

        return redirect()->route('admin.dpc.index')
            ->with('success', 'DPC berhasil dihapus.');
    }

    public function structure(Dpc $dpc)
    {
        $structures = $dpc->structures()->orderBy('order')->get();
        return view('admin.dpc.structure.index', compact('dpc', 'structures'));
    }

    public function editStructure(Dpc $dpc, DpcStructure $structure = null)
    {
        // Jika tidak ada struktur yang diberikan, buat objek baru
        if (!$structure) {
            $structure = new DpcStructure();
        }

        return view('admin.dpc.structure.edit', compact('dpc', 'structure'));
    }

    public function storeStructure(Request $request, Dpc $dpc)
    {
        $validated = $request->validate([
            'position_name' => 'required|string|max:255',
            'person_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'order' => 'required|integer',
            'level' => 'required|in:pengurus,bpo,departemen',
            'responsibilities' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['dpc_id'] = $dpc->id;

        DpcStructure::create($validated);

        return redirect()->route('admin.dpc.structure', $dpc)
            ->with('success', 'Struktur berhasil ditambahkan.');
    }

    public function updateStructure(Request $request, Dpc $dpc, DpcStructure $structure)
    {
        $validated = $request->validate([
            'position_name' => 'required|string|max:255',
            'person_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'order' => 'required|integer',
            'level' => 'required|in:pengurus,bpo,departemen',
            'responsibilities' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $structure->update($validated);

        return redirect()->route('admin.dpc.structure', $dpc)
            ->with('success', 'Struktur berhasil diperbarui.');
    }

    public function destroyStructure(Dpc $dpc, DpcStructure $structure)
    {
        $structure->delete();

        return redirect()->route('admin.dpc.structure', $dpc)
            ->with('success', 'Struktur berhasil dihapus.');
    }


    public function data(Dpc $dpc)
    {
        $dpc->load('dpd');

        $data = [
            'id' => $dpc->id,
            'kecamatan_name' => $dpc->kecamatan_name,
            'address' => $dpc->address,
            'phone' => $dpc->phone,
            'email' => $dpc->email,
            'latitude' => $dpc->latitude,
            'longitude' => $dpc->longitude,
            'ketua' => $dpc->ketua,
            'sekretaris' => $dpc->sekretaris,
            'bendahara' => $dpc->bendahara,
            'total_kader' => $dpc->total_kader,
            'total_dprt' => $dpc->total_dprt,
            'description' => $dpc->description,
            'is_active' => $dpc->is_active,
            'created_at' => $dpc->created_at,
            'dpd' => $dpc->dpd ? [
                'id' => $dpc->dpd->id,
                'name' => $dpc->dpd->name,
            ] : null,
            'dprt_count' => $dpc->dprt()->count(),
            'total_dprt_kader' => $dpc->dprt()->sum('total_kader'),
        ];

        return response()->json($data);
    }

    public function toggleStatus(Dpc $dpc)
    {
        $dpc->is_active = !$dpc->is_active;
        $dpc->save();

        $status = $dpc->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.dpc.show', $dpc)
            ->with('success', "DPC {$dpc->kecamatan_name} berhasil {$status}");
    }
    public function structureNew(Dpd $dpd) // atau Dpc $dpc, Dprt $dprt
    {
        return redirect()->route('admin.organization-structures.create', [
            'organization_type' => 'dpd',
            'organization_id' => $dpd->id
        ]);
    }
}
