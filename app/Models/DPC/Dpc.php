<?php

namespace App\Models\DPC;

use App\Models\DPD\Dpd;
use App\Models\DPRT\Dprt; // Ini sudah benar
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dpc extends Model
{
    use SoftDeletes;

    protected $table = 'dpc';
    
    protected $fillable = [
        'dpd_id',
        'kecamatan_name',
        'slug',
        'address',
        'phone',
        'email',
        'ketua',
        'sekretaris',
        'bendahara',
        'total_kader',
        'total_dprt',
        'latitude',
        'longitude',
        'geojson_path',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function dpd()
    {
        return $this->belongsTo(Dpd::class, 'dpd_id');
    }

    public function structures()
    {
        return $this->hasMany(DpcStructure::class, 'dpc_id');
    }

    public function dprt()
    {
        // PERBAIKAN: Gunakan Dprt::class (bukan DPRT\Dprt::class)
        return $this->hasMany(Dprt::class, 'dpc_id');
    }

    public function kaders()
    {
        return $this->hasMany(Kader\Kader::class, 'dpc_id');
    }

    public function beritas()
    {
        return $this->hasMany(Berita\Berita::class, 'dpc_id');
    }

    public function activeStructures()
    {
        return $this->structures()->where('is_active', true)->orderBy('order');
    }
}