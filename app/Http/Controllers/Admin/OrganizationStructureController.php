<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationStructure;
use App\Models\PositionReference;
use App\Models\DPD\Dpd;
use App\Models\DPC\Dpc;
use App\Models\DPRT\Dprt;
use App\Models\Kader\Kader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OrganizationStructure::with(['position', 'kader', 'organization'])
            ->orderBy('organization_type')
            ->orderBy('organization_id')
            ->orderBy('order');

        // Filter berdasarkan tipe organisasi
        if ($request->filled('organization_type')) {
            $query->where('organization_type', $request->organization_type);
        }

        // Filter berdasarkan organisasi tertentu
        if ($request->filled('organization_id') && $request->filled('organization_type')) {
            $query->where('organization_id', $request->organization_id)
                ->where('organization_type', $request->organization_type);
        }

        // Filter berdasarkan status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $structures = $query->paginate(20);

        // Data untuk filter
        $dpds = Dpd::where('is_active', true)->get();
        $dpcs = Dpc::where('is_active', true)->get();
        $dprts = Dprt::where('is_active', true)->get();

        return view('admin.organization-structures.index', compact(
            'structures',
            'dpds',
            'dpcs',
            'dprts'
        ));
    }

    /**
     * Show form for selecting organization type
     */
    public function selectOrganization()
    {
        $dpds = Dpd::where('is_active', true)->orderBy('name')->get();
        $dpcs = Dpc::where('is_active', true)->orderBy('kecamatan_name')->get();
        $dprts = Dprt::where('is_active', true)->orderBy('desa_name')->get();

        return view('admin.organization-structures.select-organization', compact(
            'dpds',
            'dpcs',
            'dprts'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'organization_type' => 'required|in:dpd,dpc,dprt',
            'organization_id' => 'required|integer'
        ]);

        // Get organization
        $organization = $this->getOrganization(
            $request->organization_type,
            $request->organization_id
        );

        if (!$organization) {
            return redirect()->route('admin.organization-structures.index')
                ->with('error', 'Organisasi tidak ditemukan.');
        }

        // Get available positions for this organization level
        $positions = PositionReference::where(function ($query) use ($request) {
            $query->where('organization_level', $request->organization_type)
                ->orWhere('organization_level', 'all');
        })
            ->where('is_active', true)
            ->orderBy('category')
            ->orderBy('order')
            ->get()
            ->groupBy('category');

        // Get available kaders from this organization
        $kaders = Kader::where(function ($q) use ($request, $organization) {
            switch ($request->organization_type) {
                case 'dprt':
                    $q->where('dprt_id', $organization->id);
                    break;
                case 'dpc':
                    $q->where('dpc_id', $organization->id);
                    break;
                case 'dpd':
                    $dpcIds = $organization->dpc()->pluck('id');
                    $q->whereIn('dpc_id', $dpcIds);
                    break;
            }
        })
            ->orderBy('name')
            ->get();

        return view('admin.organization-structures.create', compact(
            'organization',
            'positions',
            'kaders'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'organization_type' => 'required|in:dpd,dpc,dprt',
            'organization_id' => 'required|integer',
            'position_id' => 'required|exists:position_references,id',
            'kader_id' => 'nullable|exists:kaders,id',
            'external_name' => 'nullable|string|max:255|required_without:kader_id',
            'external_photo' => 'nullable|image|max:2048',
            'external_phone' => 'nullable|string|max:20',
            'external_email' => 'nullable|email|max:255',
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date|after_or_equal:period_start',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        // Check if position already exists for this organization
        $existing = OrganizationStructure::where('organization_type', $request->organization_type)
            ->where('organization_id', $request->organization_id)
            ->where('position_id', $request->position_id)
            ->where('is_active', true)
            ->exists();

        if ($existing && $request->is_active) {
            return back()->withInput()
                ->with('error', 'Posisi ini sudah diisi oleh orang lain yang aktif.');
        }

        $data = $request->except(['external_photo']);

        // Handle external photo upload
        if ($request->hasFile('external_photo')) {
            $path = $request->file('external_photo')->store(
                'organization-structures/external',
                'public'
            );
            $data['external_photo'] = $path;
        }

        OrganizationStructure::create($data);

        return redirect()->route('admin.organization-structures.index', [
            'organization_type' => $request->organization_type,
            'organization_id' => $request->organization_id
        ])->with('success', 'Struktur organisasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrganizationStructure $organizationStructure)
    {
        $organizationStructure->load(['position', 'kader', 'organization']);

        return view('admin.organization-structures.show', compact('organizationStructure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrganizationStructure $organizationStructure)
    {
        $organizationStructure->load(['position', 'kader', 'organization']);

        // Get organization
        $organization = $organizationStructure->organization;

        // Get available positions
        $positions = PositionReference::where(function ($query) use ($organizationStructure) {
            $query->where('organization_level', $organizationStructure->organization_type)
                ->orWhere('organization_level', 'all');
        })
            ->where('is_active', true)
            ->orderBy('category')
            ->orderBy('order')
            ->get();

        // Get available kaders
        $kaders = Kader::where(function ($q) use ($organizationStructure, $organization) {
            switch ($organizationStructure->organization_type) {
                case 'dprt':
                    $q->where('dprt_id', $organization->id);
                    break;
                case 'dpc':
                    $q->where('dpc_id', $organization->id);
                    break;
                case 'dpd':
                    $dpcIds = $organization->dpc()->pluck('id');
                    $q->whereIn('dpc_id', $dpcIds);
                    break;
            }
        })
            ->orderBy('name')
            ->get();

        return view('admin.organization-structures.edit', compact(
            'organizationStructure',
            'positions',
            'kaders'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrganizationStructure $organizationStructure)
    {
        $request->validate([
            'position_id' => 'required|exists:position_references,id',
            'kader_id' => 'nullable|exists:kaders,id',
            'external_name' => 'nullable|string|max:255|required_without:kader_id',
            'external_photo' => 'nullable|image|max:2048',
            'external_phone' => 'nullable|string|max:20',
            'external_email' => 'nullable|email|max:255',
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date|after_or_equal:period_start',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
            'remove_photo' => 'boolean'
        ]);

        // Check if position already exists (excluding current one)
        if ($request->is_active) {
            $existing = OrganizationStructure::where('organization_type', $organizationStructure->organization_type)
                ->where('organization_id', $organizationStructure->organization_id)
                ->where('position_id', $request->position_id)
                ->where('id', '!=', $organizationStructure->id)
                ->where('is_active', true)
                ->exists();

            if ($existing) {
                return back()->withInput()
                    ->with('error', 'Posisi ini sudah diisi oleh orang lain yang aktif.');
            }
        }

        $data = $request->except(['external_photo', 'remove_photo']);

        // Handle photo removal
        if ($request->has('remove_photo') && $request->remove_photo) {
            if ($organizationStructure->external_photo) {
                Storage::disk('public')->delete($organizationStructure->external_photo);
            }
            $data['external_photo'] = null;
        }

        // Handle new photo upload
        if ($request->hasFile('external_photo')) {
            // Delete old photo if exists
            if ($organizationStructure->external_photo) {
                Storage::disk('public')->delete($organizationStructure->external_photo);
            }

            $path = $request->file('external_photo')->store(
                'organization-structures/external',
                'public'
            );
            $data['external_photo'] = $path;
        }

        $organizationStructure->update($data);

        return redirect()->route('admin.organization-structures.index', [
            'organization_type' => $organizationStructure->organization_type,
            'organization_id' => $organizationStructure->organization_id
        ])->with('success', 'Struktur organisasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrganizationStructure $organizationStructure)
    {
        // Delete photo if exists
        if ($organizationStructure->external_photo) {
            Storage::disk('public')->delete($organizationStructure->external_photo);
        }

        $organizationType = $organizationStructure->organization_type;
        $organizationId = $organizationStructure->organization_id;

        $organizationStructure->delete();

        return redirect()->route('admin.organization-structures.index', [
            'organization_type' => $organizationType,
            'organization_id' => $organizationId
        ])->with('success', 'Struktur organisasi berhasil dihapus.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(OrganizationStructure $organizationStructure)
    {
        if ($organizationStructure->is_active) {
            $organizationStructure->update(['is_active' => false]);
            $message = 'Struktur organisasi dinonaktifkan.';
        } else {
            // Check if position is already occupied by active person
            $existing = OrganizationStructure::where('organization_type', $organizationStructure->organization_type)
                ->where('organization_id', $organizationStructure->organization_id)
                ->where('position_id', $organizationStructure->position_id)
                ->where('id', '!=', $organizationStructure->id)
                ->where('is_active', true)
                ->exists();

            if ($existing) {
                return back()->with('error', 'Posisi ini sudah diisi oleh orang lain yang aktif.');
            }

            $organizationStructure->update(['is_active' => true]);
            $message = 'Struktur organisasi diaktifkan.';
        }

        return back()->with('success', $message);
    }

    /**
     * Get organization by type and ID
     */
    private function getOrganization($type, $id)
    {
        switch ($type) {
            case 'dpd':
                return Dpd::find($id);
            case 'dpc':
                return Dpc::find($id);
            case 'dprt':
                return Dprt::find($id);
            default:
                return null;
        }
    }
}
