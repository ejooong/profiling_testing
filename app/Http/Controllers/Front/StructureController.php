<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\DPD\Dpd;
use App\Models\DPC\Dpc;
use App\Models\DPRT\Dprt;
use App\Models\OrganizationStructure;

class StructureController extends Controller
{
    /**
     * Helper untuk mendapatkan URL foto
     */
    private function getPhotoUrl($photoPath)
    {
        if (!$photoPath) {
            return null;
        }

        // SEDERHANA: Gunakan cara yang sama seperti di admin
        return asset('storage/' . $photoPath);
    }

    public function index()
    {
        try {
            // Get active DPD
            $dpd = Dpd::where('is_active', true)->first();

            // Get DPD structures dari organization_structures
            $dpdStructures = [];
            if ($dpd) {
                $dpdStructures = OrganizationStructure::where('organization_type', 'dpd')
                    ->where('organization_id', $dpd->id)
                    ->where('is_active', true)
                    ->with(['position', 'kader'])
                    ->orderBy('order')
                    ->get();
            }

            // Get DPCs
            $dpcs = Dpc::where('is_active', true)->get();

            // Get DPC structures dari organization_structures
            $dpcStructures = [];
            foreach ($dpcs as $dpc) {
                $structures = OrganizationStructure::where('organization_type', 'dpc')
                    ->where('organization_id', $dpc->id)
                    ->where('is_active', true)
                    ->with(['position', 'kader'])
                    ->orderBy('order')
                    ->get();
                $dpcStructures[$dpc->id] = $structures;
            }

            // Get DPRTs
            $dprts = Dprt::where('is_active', true)->get();

            // Get DPRT structures dari organization_structures
            $dprtStructures = [];
            foreach ($dprts as $dprt) {
                $structures = OrganizationStructure::where('organization_type', 'dprt')
                    ->where('organization_id', $dprt->id)
                    ->where('is_active', true)
                    ->with(['position', 'kader'])
                    ->orderBy('order')
                    ->get();
                $dprtStructures[$dprt->id] = $structures;
            }

            return view('front.structure', compact(
                'dpd',
                'dpdStructures',
                'dpcs',
                'dpcStructures',
                'dprts',
                'dprtStructures'
            ));
        } catch (\Exception $e) {
            \Log::error('StructureController error: ' . $e->getMessage());

            return view('front.structure', [
                'dpd' => null,
                'dpdStructures' => collect(),
                'dpcs' => collect(),
                'dpcStructures' => [],
                'dprts' => collect(),
                'dprtStructures' => []
            ]);
        }
    }
}
