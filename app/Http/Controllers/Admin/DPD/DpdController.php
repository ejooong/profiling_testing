<?php

namespace App\Http\Controllers\Admin\DPD;

use App\Http\Controllers\Controller;
use App\Models\DPD\Dpd;
use App\Models\DPD\DpdStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DpdController extends Controller
{
    public function index()
    {
        $dpd = Dpd::first();
        return view('admin.dpd.index', compact('dpd'));
    }

    public function create()
    {
        return view('admin.dpd.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'ketua' => 'required|string|max:255',
            'sekretaris' => 'required|string|max:255',
            'bendahara' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        $validated['is_active'] = true;

        Dpd::create($validated);

        return redirect()->route('admin.dpd.index')
            ->with('success', 'DPD berhasil dibuat.');
    }

    public function show(Dpd $dpd)
    {
        return view('admin.dpd.show', compact('dpd'));
    }

    public function edit(Dpd $dpd)
    {
        return view('admin.dpd.edit', compact('dpd'));
    }

    public function update(Request $request, Dpd $dpd)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'ketua' => 'required|string|max:255',
            'sekretaris' => 'required|string|max:255',
            'bendahara' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);

        $dpd->update($validated);

        return redirect()->route('admin.dpd.index')
            ->with('success', 'DPD berhasil diperbarui.');
    }

    public function destroy(Dpd $dpd)
    {
        $dpd->delete();

        return redirect()->route('admin.dpd.index')
            ->with('success', 'DPD berhasil dihapus.');
    }

    public function structure(Dpd $dpd)
    {
        // Ambil struktur utama DPD (bukan list structures)
        $structure = $dpd->structures()->first();

        // Jika tidak ada struktur, buat dummy untuk view
        if (!$structure) {
            $structure = (object) [
                'id' => null,
                'ketua' => $dpd->ketua,
                'sekretaris' => $dpd->sekretaris,
                'bendahara' => $dpd->bendahara,
                'periode_mulai' => now()->format('Y-m-d'),
                'periode_selesai' => now()->addYears(5)->format('Y-m-d'),
                'departemen' => [],
                'panitia' => [],
                'visi' => '',
                'misi' => '',
                'catatan' => '',
                'ketua_photo' => null,
                'sekretaris_photo' => null,
                'bendahara_photo' => null,
            ];
        } else {
            // KARENA SUDAH ADA CASTING DI MODEL, tidak perlu json_decode()!
            // Casting otomatis akan mengubah JSON menjadi array
            // Cukup pastikan nilai tidak null

            $structure->departemen = $structure->departemen ?? [];
            $structure->panitia = $structure->panitia ?? [];
        }

        return view('admin.dpd.structure.index', compact('dpd', 'structure'));
    }

    public function storeStructure(Request $request, Dpd $dpd)
    {
        $validated = $request->validate([
            'position_name' => 'required|string|max:255',
            'person_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'order' => 'required|integer',
            'level' => 'required|in:pengurus,bpo,departemen',
            'responsibilities' => 'nullable|string',
        ]);

        $validated['dpd_id'] = $dpd->id;
        $validated['is_active'] = true;

        DpdStructure::create($validated);

        return redirect()->route('admin.dpd.structure', $dpd)
            ->with('success', 'Struktur berhasil ditambahkan.');
    }

    public function updateStructure(Request $request, Dpd $dpd, DpdStructure $structure)
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

        return redirect()->route('admin.dpd.structure', $dpd)
            ->with('success', 'Struktur berhasil diperbarui.');
    }

    public function destroyStructure(Dpd $dpd, DpdStructure $structure)
    {
        $structure->delete();

        return redirect()->route('admin.dpd.structure', $dpd)
            ->with('success', 'Struktur berhasil dihapus.');
    }




    public function editStructure(Dpd $dpd)
    {
        // Cari struktur utama DPD
        $structure = $dpd->structures()->first();

        // Jika tidak ada struktur, buat yang baru dengan data DPD
        if (!$structure) {
            $structure = new DpdStructure([
                'dpd_id' => $dpd->id,
                'position_name' => 'Struktur DPD',
                'person_name' => $dpd->ketua,
                'level' => 'pengurus',
                'order' => 1,
                'is_active' => true,
                // Field baru
                'ketua' => $dpd->ketua,
                'sekretaris' => $dpd->sekretaris,
                'bendahara' => $dpd->bendahara,
                'periode_mulai' => now()->format('Y-m-d'),
                'periode_selesai' => now()->addYears(5)->format('Y-m-d'),
                'departemen' => [], // Casting akan otomatis mengubahnya ke JSON
                'panitia' => [],    // Casting akan otomatis mengubahnya ke JSON
                'visi' => '',
                'misi' => '',
                'catatan' => '',
            ]);
        } else {
            // Karena sudah ada casting, tidak perlu decode
            // Cukup pastikan nilai default
            $structure->departemen = $structure->departemen ?? [];
            $structure->panitia = $structure->panitia ?? [];
        }

        return view('admin.dpd.structure.edit', compact('dpd', 'structure'));
    }

    // Method baru untuk update struktur utama DPD
    // Method baru untuk update struktur utama DPD
    public function updateStructureMain(Request $request, Dpd $dpd)
    {
        $validated = $request->validate([
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date',
            'ketua' => 'required|string|max:255',
            'sekretaris' => 'required|string|max:255',
            'bendahara' => 'required|string|max:255',
            'ketua_photo' => 'nullable|image|max:2048',
            'sekretaris_photo' => 'nullable|image|max:2048',
            'bendahara_photo' => 'nullable|image|max:2048',
            'departemen' => 'nullable|array',
            'departemen.*.name' => 'required|string',
            'departemen.*.coordinator' => 'required|string',
            'departemen.*.members' => 'nullable|integer',
            'departemen.*.description' => 'nullable|string',
            'panitia' => 'nullable|array',
            'panitia.*.name' => 'required|string',
            'panitia.*.chairman' => 'required|string',
            'panitia.*.task' => 'required|string',
            'panitia.*.members_list' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        // Cari atau buat struktur DPD
        $structure = $dpd->structures()->firstOrNew([]);

        // Jika baru, set default values
        if (!$structure->exists) {
            $structure->dpd_id = $dpd->id;
            $structure->position_name = 'Struktur DPD';
            $structure->level = 'pengurus';
            $structure->order = 1;
            $structure->is_active = true;
        }

        // Handle file uploads
        $photoFields = ['ketua_photo', 'sekretaris_photo', 'bendahara_photo'];

        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('dpd-structure', 'public');
            } elseif (!$structure->exists || !$structure->$field) {
                // Jika file tidak diupload dan tidak ada data lama
                $validated[$field] = null;
            } else {
                // Pertahankan file lama jika ada
                unset($validated[$field]); // Biarkan Eloquent handle sendiri
            }
        }

        // Set person_name dan person_photo untuk kompatibilitas
        $validated['person_name'] = $validated['ketua'];
        if (isset($validated['ketua_photo'])) {
            $validated['person_photo'] = $validated['ketua_photo'];
        } elseif ($structure->ketua_photo) {
            $validated['person_photo'] = $structure->ketua_photo;
        }

        // Pastikan array tidak null
        $validated['departemen'] = $validated['departemen'] ?? [];
        $validated['panitia'] = $validated['panitia'] ?? [];

        // Update data
        $structure->fill($validated);
        $structure->save();

        return redirect()->route('admin.dpd.structure', $dpd)
            ->with('success', 'Struktur berhasil diperbarui.');
    }
    public function structureNew(Dpd $dpd) // atau Dpc $dpc, Dprt $dprt
    {
        return redirect()->route('admin.organization-structures.create', [
            'organization_type' => 'dpd',
            'organization_id' => $dpd->id
        ]);
    }
}
