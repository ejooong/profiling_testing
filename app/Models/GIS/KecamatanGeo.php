<?php

namespace App\Models\GIS;

use Illuminate\Database\Eloquent\Model;

class KecamatanGeo extends Model
{
    protected $table = 'kecamatan_geo';
    
    protected $fillable = [
        'kabupaten_id',
        'kecamatan_name',
        'kode_bps',
        'geojson_data',
        'center_lat',
        'center_lng',
        'total_desa',
    ];
    
    protected $casts = [
        'geojson_data' => 'array',
        'center_lat' => 'decimal:8',
        'center_lng' => 'decimal:8',
    ];
    
    public function kabupaten()
    {
        return $this->belongsTo(KabupatenGeo::class, 'kabupaten_id');
    }
    
    public function desas()
    {
        return $this->hasMany(DesaGeo::class, 'kecamatan_id');
    }
}