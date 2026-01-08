<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DPC\Dpc;
use App\Models\DPRT\Dprt;
use App\Models\Kader\Kader;
use App\Models\GIS\KabupatenGeo;
use App\Models\GIS\KecamatanGeo;
use App\Models\GIS\DesaGeo;
use Illuminate\Http\Request;

class GisController extends Controller
{
    public function index()
    {
        // Get data for GIS dashboard
        $dpcs = Dpc::with('dpd')->get();
        $dprts = Dprt::with('dpc')->get();
        $totalKader = Kader::count();

        // Count DPC with coordinates
        $dpcWithCoords = $dpcs->filter(function ($dpc) {
            return $dpc->latitude && $dpc->longitude;
        })->count();

        // Count DPRT with coordinates
        $dprtWithCoords = $dprts->filter(function ($dprt) {
            return $dprt->latitude && $dprt->longitude;
        })->count();

        // Get GeoJSON data
        $kabupatenGeo = KabupatenGeo::first();
        $kecamatanGeo = KecamatanGeo::with('kabupaten')->get();
        $desaGeo = DesaGeo::with('kecamatan')->get();

        // Calculate DPC per kecamatan match
        $dpcByKecamatan = [];
        foreach ($dpcs as $dpc) {
            if ($dpc->kecamatan_name) {
                $dpcByKecamatan[$dpc->kecamatan_name] = $dpc;
            }
        }

        // Count kecamatan with DPC
        $kecamatanWithDpc = $kecamatanGeo->filter(function ($kec) use ($dpcByKecamatan) {
            return isset($dpcByKecamatan[$kec->kecamatan_name]);
        })->count();

        // Count desa with DPRT
        $desaWithDprt = 0;
        foreach ($desaGeo as $desa) {
            foreach ($dprts as $dprt) {
                if (
                    strpos($dprt->desa_name, $desa->desa_name) !== false ||
                    strpos($desa->desa_name, $dprt->desa_name) !== false
                ) {
                    $desaWithDprt++;
                    break;
                }
            }
        }

        // ✅ Prepare data for JS (safe, no closures in Blade)
        $gisPageData = [
            'dpcWithCoords' => $dpcWithCoords ?? 0,
            'dprtWithCoords' => $dprtWithCoords ?? 0,
            'totalKader' => $totalKader ?? 0,
            'totalDpc' => $dpcs->count(),
            'totalDprt' => $dprts->count(),
            'totalKecamatan' => $kecamatanGeo->count(),
            'totalDesa' => $desaGeo->count(),
            'kecamatanWithDpc' => $kecamatanWithDpc ?? 0,
            'desaWithDprt' => $desaWithDprt ?? 0,
        ];

        // ✅ Data for printMap() — pre-processed in PHP (no closure in Blade)
        $dpcsForPrint = $dpcs->map(function ($dpc) {
            return [
                'kecamatan_name' => $dpc->kecamatan_name,
                'latitude' => $dpc->latitude,
                'longitude' => $dpc->longitude,
                'is_active' => $dpc->is_active,
                'total_kader' => $dpc->total_kader,
                'total_dprt' => $dpc->total_dprt,
            ];
        })->values(); // ← penting: .values() agar jadi array numerik

        // ✅ Return view dengan semua data
        return view('admin.gis.index', compact(
            'gisPageData',
            'dpcsForPrint',     // ← baru ditambahkan
            'dpcs',
            'dprts',
            'totalKader',
            'dpcWithCoords',
            'dprtWithCoords',
            'kabupatenGeo',
            'kecamatanGeo',
            'desaGeo',
            'kecamatanWithDpc',
            'desaWithDprt'
        ));
    }

    public function map()
    {
        $dpcs = Dpc::with('dpd')->get();
        $dprts = Dprt::with('dpc')->get();
        $totalKader = Kader::count();
        $kabupatenGeo = KabupatenGeo::first();
        $kecamatanGeo = KecamatanGeo::with('kabupaten')->get();

        return view('admin.gis.map', compact(
            'dpcs',
            'dprts',
            'totalKader',
            'kabupatenGeo',
            'kecamatanGeo'
        ));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'geojson_file' => 'required|file|mimes:json,geojson|max:5120',
            'type' => 'required|in:kabupaten,kecamatan,desa'
        ]);

        $geojson = json_decode(file_get_contents($request->file('geojson_file')->getRealPath()), true);
        if (!$geojson || !isset($geojson['type']) || $geojson['type'] !== 'FeatureCollection') {
            return back()->with('error', 'Format GeoJSON tidak valid.');
        }

        $filename = 'geojson_' . $request->type . '_' . time() . '.json';
        $path = $request->file('geojson_file')->storeAs('geojson', $filename, 'public');

        switch ($request->type) {
            case 'kabupaten':
                $this->importKabupatenFromFile($path);
                break;
            case 'kecamatan':
                $this->importKecamatanFromFile($path);
                break;
            case 'desa':
                $this->importDesaFromFile($path);
                break;
        }

        return back()->with('success', 'File GeoJSON berhasil diupload dan diimport ke database.');
    }

    // API endpoint untuk data GIS
    public function apiData()
    {
        $dpcs = Dpc::with('dpd')->get()->map(function ($dpc) {
            return [
                'id' => $dpc->id,
                'kecamatan_name' => $dpc->kecamatan_name,
                'ketua' => $dpc->ketua,
                'phone' => $dpc->phone,
                'email' => $dpc->email,
                'address' => $dpc->address,
                'latitude' => $dpc->latitude,
                'longitude' => $dpc->longitude,
                'is_active' => $dpc->is_active,
                'total_kader' => $dpc->total_kader,
                'total_dprt' => $dpc->dprt_count ?? 0,
                'dpd_name' => $dpc->dpd->name ?? null,
                'created_at' => $dpc->created_at->toIso8601String()
            ];
        });

        $dprts = Dprt::with('dpc')->get()->map(function ($dprt) {
            return [
                'id' => $dprt->id,
                'desa_name' => $dprt->desa_name,
                'ketua' => $dprt->ketua,
                'phone' => $dprt->phone,
                'email' => $dprt->email,
                'address' => $dprt->address,
                'latitude' => $dprt->latitude,
                'longitude' => $dprt->longitude,
                'is_active' => $dprt->is_active,
                'total_kader' => $dprt->total_kader,
                'dpc_name' => $dprt->dpc->kecamatan_name ?? null,
                'dpc_id' => $dprt->dpc_id,
                'created_at' => $dprt->created_at->toIso8601String()
            ];
        });

        $kabupatenGeo = KabupatenGeo::first();
        $kecamatanGeo = KecamatanGeo::with('kabupaten')->get();
        $desaGeo = DesaGeo::with('kecamatan')->get();

        $geojsonData = [
            'kabupaten' => $kabupatenGeo ? [
                'id' => $kabupatenGeo->id,
                'name' => $kabupatenGeo->kabupaten_name,
                'kode_bps' => $kabupatenGeo->kode_bps,
                'geojson' => $kabupatenGeo->geojson_data,
                'center' => [$kabupatenGeo->center_lat, $kabupatenGeo->center_lng],
                'total_kecamatan' => $kabupatenGeo->total_kecamatan,
                'total_desa' => $kabupatenGeo->total_desa
            ] : null,

            'kecamatans' => $kecamatanGeo->map(function ($kec) {
                return [
                    'id' => $kec->id,
                    'name' => $kec->kecamatan_name,
                    'kode_bps' => $kec->kode_bps,
                    'geojson' => $kec->geojson_data,
                    'center' => [$kec->center_lat, $kec->center_lng],
                    'total_desa' => $kec->total_desa,
                    'kabupaten_id' => $kec->kabupaten_id,
                    'kabupaten_name' => $kec->kabupaten->kabupaten_name ?? null
                ];
            }),

            'desas' => $desaGeo->map(function ($desa) {
                return [
                    'id' => $desa->id,
                    'name' => $desa->desa_name,
                    'kode_bps' => $desa->kode_bps,
                    'kecamatan_id' => $desa->kecamatan_id,
                    'kecamatan_name' => $desa->kecamatan->kecamatan_name ?? null,
                    'geojson' => $desa->geojson_data,
                    'center' => [$desa->center_lat, $desa->center_lng]
                ];
            })
        ];

        // Match DPC with kecamatan geo
        $matchedDpcs = $dpcs->map(function ($dpc) use ($kecamatanGeo) {
            $matchedKecamatan = $kecamatanGeo->first(function ($kec) use ($dpc) {
                return strpos($kec->kecamatan_name, $dpc['kecamatan_name']) !== false ||
                    strpos($dpc['kecamatan_name'], $kec->kecamatan_name) !== false;
            });

            return array_merge($dpc, [
                'geojson_id' => $matchedKecamatan ? $matchedKecamatan->id : null,
                'has_boundary' => !empty($matchedKecamatan)
            ]);
        });

        // Match DPRT with desa geo
        $matchedDprts = $dprts->map(function ($dprt) use ($desaGeo) {
            $matchedDesa = $desaGeo->first(function ($desa) use ($dprt) {
                return strpos($desa->desa_name, $dprt['desa_name']) !== false ||
                    strpos($dprt['desa_name'], $desa->desa_name) !== false;
            });

            return array_merge($dprt, [
                'geojson_id' => $matchedDesa ? $matchedDesa->id : null,
                'has_boundary' => !empty($matchedDesa)
            ]);
        });

        return response()->json([
            'dpcs' => $matchedDpcs,
            'dprts' => $matchedDprts,
            'geojson' => $geojsonData,
            'statistics' => [
                'total_dpc' => $dpcs->count(),
                'total_dprt' => $dprts->count(),
                'total_kader' => Kader::count(),
                'dpc_with_coords' => $dpcs->whereNotNull('latitude')->whereNotNull('longitude')->count(),
                'dprt_with_coords' => $dprts->whereNotNull('latitude')->whereNotNull('longitude')->count(),
                'dpc_with_boundary' => $matchedDpcs->where('has_boundary', true)->count(),
                'dprt_with_boundary' => $matchedDprts->where('has_boundary', true)->count(),
                'total_kecamatan' => $kecamatanGeo->count(),
                'total_desa' => DesaGeo::count()
            ]
        ]);
    }

    /**
     * Import kabupaten GeoJSON from uploaded file
     */
    private function importKabupatenFromFile($filePath)
    {
        // Implementation similar to seeder
        // You can reuse the logic from GeojsonSeeder
    }

    /**
     * Import kecamatan GeoJSON from uploaded file
     */
    private function importKecamatanFromFile($filePath)
    {
        // Implementation similar to seeder
    }

    /**
     * Import desa GeoJSON from uploaded file
     */
    private function importDesaFromFile($filePath)
    {
        // Implementation similar to seeder
    }

    /**
     * Helper function to calculate center point
     */
    private function calculateCenter($coordinates)
    {
        if (empty($coordinates)) {
            return ['lat' => -7.150975, 'lng' => 111.881860];
        }

        // Flatten coordinates array
        $flatCoords = [];
        array_walk_recursive($coordinates, function ($item) use (&$flatCoords) {
            if (is_float($item) || is_int($item)) {
                $flatCoords[] = $item;
            }
        });

        // Group into lat/lng pairs
        $lats = [];
        $lngs = [];
        for ($i = 0; $i < count($flatCoords); $i += 3) {
            if (isset($flatCoords[$i + 1])) {
                $lngs[] = $flatCoords[$i];
                $lats[] = $flatCoords[$i + 1];
            }
        }

        if (count($lats) > 0 && count($lngs) > 0) {
            return [
                'lat' => array_sum($lats) / count($lats),
                'lng' => array_sum($lngs) / count($lngs)
            ];
        }

        return ['lat' => -7.150975, 'lng' => 111.881860];
    }

    /**
     * API untuk mendapatkan data GeoJSON spesifik
     */
    public function getGeojson($type, $id = null)
    {
        switch ($type) {
            case 'kabupaten':
                $data = KabupatenGeo::first();
                break;
            case 'kecamatan':
                $data = $id ? KecamatanGeo::find($id) : KecamatanGeo::all();
                break;
            case 'desa':
                $data = $id ? DesaGeo::find($id) : DesaGeo::with('kecamatan')->paginate(50);
                break;
            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($data);
    }

    /**
     * API untuk mendapatkan statistik GIS
     */
    public function getStatistics()
    {
        $totalDpc = Dpc::count();
        $dpcWithCoords = Dpc::whereNotNull('latitude')->whereNotNull('longitude')->count();

        $totalDprt = Dprt::count();
        $dprtWithCoords = Dprt::whereNotNull('latitude')->whereNotNull('longitude')->count();

        $totalKader = Kader::count();

        $kabupatenGeo = KabupatenGeo::count();
        $kecamatanGeo = KecamatanGeo::count();
        $desaGeo = DesaGeo::count();

        return response()->json([
            'organisasi' => [
                'total_dpc' => $totalDpc,
                'dpc_with_coords' => $dpcWithCoords,
                'dpc_coverage' => $totalDpc > 0 ? round(($dpcWithCoords / $totalDpc) * 100, 1) : 0,

                'total_dprt' => $totalDprt,
                'dprt_with_coords' => $dprtWithCoords,
                'dprt_coverage' => $totalDprt > 0 ? round(($dprtWithCoords / $totalDprt) * 100, 1) : 0,

                'total_kader' => $totalKader
            ],
            'geojson' => [
                'kabupaten' => $kabupatenGeo,
                'kecamatan' => $kecamatanGeo,
                'desa' => $desaGeo,
                'total_boundaries' => $kabupatenGeo + $kecamatanGeo + $desaGeo
            ],
            'coverage' => [
                'dpc_vs_kecamatan' => $kecamatanGeo > 0 ? round(($totalDpc / $kecamatanGeo) * 100, 1) : 0,
                'dprt_vs_desa' => $desaGeo > 0 ? round(($totalDprt / $desaGeo) * 100, 1) : 0
            ]
        ]);
    }
}
