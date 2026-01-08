<?php

namespace App\Models\GIS;

use Illuminate\Database\Eloquent\Model;

class DesaGeo extends Model
{
    protected $table = 'desa_geo';
    
    protected $fillable = [
        'kecamatan_id',
        'desa_name',
        'kode_bps',
        'geojson_data',
        'center_lat',
        'center_lng',
    ];
    
    protected $casts = [
        'geojson_data' => 'array',
        'center_lat' => 'decimal:8',
        'center_lng' => 'decimal:8',
    ];
    
    public function kecamatan()
    {
        return $this->belongsTo(KecamatanGeo::class, 'kecamatan_id');
    }
}