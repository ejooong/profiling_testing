<?php

namespace App\Models\GIS;

use Illuminate\Database\Eloquent\Model;

class KabupatenGeo extends Model
{
    protected $table = 'kabupaten_geo';
    
    protected $fillable = [
        'kabupaten_name',
        'kode_bps',
        'geojson_data',
        'center_lat',
        'center_lng',
        'total_kecamatan',
        'total_desa',
    ];
    
    protected $casts = [
        'geojson_data' => 'array',
        'center_lat' => 'decimal:8',
        'center_lng' => 'decimal:8',
    ];
    
    public function kecamatans()
    {
        return $this->hasMany(KecamatanGeo::class, 'kabupaten_id');
    }
}