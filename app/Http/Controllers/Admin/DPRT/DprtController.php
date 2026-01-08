<?php

namespace App\Http\Controllers\Admin\DPRT;

use App\Http\Controllers\Controller;
use App\Models\DPC\Dpc;
use App\Models\DPRT\Dprt;
use App\Models\DPRT\DprtStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // TAMBAHKAN INI

class DprtController extends Controller
{
public function index(Request $request)
{
    $query = Dprt::with('dpc');
    
    // Filter berdasarkan DPC jika ada parameter
    if ($request->has('dpc_id')) {
        $query->where('dpc_id', $request->dpc_id);
    }
    
    // Filter berdasarkan status jika ada parameter
    if ($request->has('status')) {
        if ($request->status == 'active') {
            $query->where('is_active', true);
        } elseif ($request->status == 'inactive') {
            $query->where('is_active', false);
        }
    }
    
    // Filter pencarian
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('desa_name', 'like', "%{$search}%")
              ->orWhere('ketua', 'like', "%{$search}%")
              ->orWhere('address', 'like', "%{$search}%");
        });
    }
    
    $dprts = $query->paginate(20);
    $dpcs = Dpc::where('is_active', true)->get();
    
    // Hitung statistik (jika diperlukan)
    $totalDprt = Dprt::count();
    $activeDprt = Dprt::where('is_active', true)->count();
    $inactiveDprt = Dprt::where('is_active', false)->count();
    $totalKader = \App\Models\Kader\Kader::count(); // atau hubungan lain jika ada
    
    return view('admin.dprt.index', compact(
        'dprts', 
        'dpcs',
        'totalDprt',
        'activeDprt',
        'inactiveDprt',
        'totalKader'
    ));
}
    
    public function create()
    {
        $dpcs = Dpc::where('is_active', true)->get();
        return view('admin.dprt.create', compact('dpcs'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dpc_id' => 'required|exists:dpc,id',
            'desa_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'ketua' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);
        
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['desa_name']);
        $validated['is_active'] = true;
        
        Dprt::create($validated);
        
        return redirect()->route('admin.dprt.index')
            ->with('success', 'DPRT berhasil dibuat.');
    }
    
    public function show(Dprt $dprt)
    {
        return view('admin.dprt.show', compact('dprt'));
    }
    
    public function edit(Dprt $dprt)
    {
        $dpcs = Dpc::where('is_active', true)->get();
        return view('admin.dprt.edit', compact('dprt', 'dpcs'));
    }
    
    public function update(Request $request, Dprt $dprt)
    {
        $validated = $request->validate([
            'dpc_id' => 'required|exists:dpc,id',
            'desa_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'ketua' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['desa_name']);
        
        $dprt->update($validated);
        
        return redirect()->route('admin.dprt.index')
            ->with('success', 'DPRT berhasil diperbarui.');
    }
    
    public function destroy(Dprt $dprt)
    {
        $dprt->delete();
        
        return redirect()->route('admin.dprt.index')
            ->with('success', 'DPRT berhasil dihapus.');
    }
    
public function structure(Dprt $dprt)
{
    $structures = $dprt->structures()->orderBy('order')->get();
    
    // Hitung statistik
    $totalPengurus = $structures->where('level', 'pengurus')->count();
    $totalAnggota = $structures->where('level', 'anggota')->count();
    $activeCount = $structures->where('is_active', true)->count();
    
    return view('admin.dprt.structure.index', compact(
        'dprt', 
        'structures',
        'totalPengurus',
        'totalAnggota',
        'activeCount'
    ));
}
// Tambahkan method-method berikut di DprtController:

public function structureCreate(Dprt $dprt)
{
    return view('admin.dprt.structure.create', compact('dprt'));
}

public function structureStore(Request $request, Dprt $dprt)
{
    $validated = $request->validate([
        'position_name' => 'required|string|max:255',
        'person_name' => 'required|string|max:255',
        'person_photo' => 'nullable|image|max:2048',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email',
        'order' => 'required|integer',
        'level' => 'required|in:pengurus,anggota',
        'responsibilities' => 'nullable|string',
        'is_active' => 'boolean',
    ]);
    
    // Upload foto jika ada
    if ($request->hasFile('person_photo')) {
        $validated['person_photo'] = $request->file('person_photo')->store('dprt-structures', 'public');
    }
    
    $validated['dprt_id'] = $dprt->id;
    
    DprtStructure::create($validated);
    
    return redirect()->route('admin.dprt.structure', $dprt)
        ->with('success', 'Pengurus berhasil ditambahkan.');
}

public function structureEdit(Dprt $dprt, DprtStructure $structure)
{
    return view('admin.dprt.structure.edit', compact('dprt', 'structure'));
}

public function structureUpdate(Request $request, Dprt $dprt, DprtStructure $structure)
{
    $validated = $request->validate([
        'position_name' => 'required|string|max:255',
        'person_name' => 'required|string|max:255',
        'person_photo' => 'nullable|image|max:2048',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email',
        'order' => 'required|integer',
        'level' => 'required|in:pengurus,anggota',
        'responsibilities' => 'nullable|string',
        'is_active' => 'boolean',
    ]);
    
    // Upload foto baru jika ada
    if ($request->hasFile('person_photo')) {
        // Hapus foto lama jika ada
        if ($structure->person_photo) {
            Storage::disk('public')->delete($structure->person_photo);
        }
        $validated['person_photo'] = $request->file('person_photo')->store('dprt-structures', 'public');
    }
    
    $structure->update($validated);
    
    return redirect()->route('admin.dprt.structure', $dprt)
        ->with('success', 'Pengurus berhasil diperbarui.');
}

public function structureDestroy(Dprt $dprt, DprtStructure $structure)
{
    // Hapus foto jika ada
    if ($structure->person_photo) {
        Storage::disk('public')->delete($structure->person_photo);
    }
    
    $structure->delete();
    
    return redirect()->route('admin.dprt.structure', $dprt)
        ->with('success', 'Pengurus berhasil dihapus.');
}

public function restore(Dprt $dprt)
{
    $dprt->restore();
    
    return redirect()->route('admin.dprt.index')
        ->with('success', 'DPRT berhasil dipulihkan.');
}

public function structureExport(Dprt $dprt)
{
    // Implementasi export Excel (gunakan package seperti Laravel Excel)
    // Untuk sementara, redirect ke struktur
    return redirect()->route('admin.dprt.structure', $dprt);
}

public function data(Dprt $dprt)
{
    // Load relationships
    $dprt->load('dpc.dpd', 'structures');
    
    // Calculate statistics
    $totalStructures = $dprt->structures->count();
    $activeStructures = $dprt->structures->where('is_active', true)->count();
    $structurePengurus = $dprt->structures->where('level', 'pengurus')->count();
    
    return response()->json([
        'id' => $dprt->id,
        'dpc_id' => $dprt->dpc_id,
        'desa_name' => $dprt->desa_name,
        'slug' => $dprt->slug,
        'address' => $dprt->address,
        'phone' => $dprt->phone,
        'email' => $dprt->email,
        'ketua' => $dprt->ketua,
        'total_kader' => $dprt->total_kader,
        'latitude' => $dprt->latitude,
        'longitude' => $dprt->longitude,
        'description' => $dprt->description,
        'is_active' => $dprt->is_active,
        'created_at' => $dprt->created_at,
        'updated_at' => $dprt->updated_at,
        'deleted_at' => $dprt->deleted_at,
        
        // Relationships
        'dpc' => $dprt->dpc ? [
            'id' => $dprt->dpc->id,
            'kecamatan_name' => $dprt->dpc->kecamatan_name,
            'dpd' => $dprt->dpc->dpd ? [
                'id' => $dprt->dpc->dpd->id,
                'name' => $dprt->dpc->dpd->name
            ] : null
        ] : null,
        
        // Statistics
        'total_structures' => $totalStructures,
        'active_structures' => $activeStructures,
        'structure_pengurus' => $structurePengurus,
        'structure_anggota' => $totalStructures - $structurePengurus
    ]);
}

public function toggleStatus(Request $request, Dprt $dprt)
{
    $dprt->update([
        'is_active' => !$dprt->is_active
    ]);
    
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Status DPRT berhasil diperbarui.',
            'is_active' => $dprt->is_active
        ]);
    }
    
    return back()->with('success', 'Status DPRT berhasil diperbarui.');
}
public function structureNew(Dpd $dpd) // atau Dpc $dpc, Dprt $dprt
{
    return redirect()->route('admin.organization-structures.create', [
        'organization_type' => 'dpd',
        'organization_id' => $dpd->id
    ]);
}
}