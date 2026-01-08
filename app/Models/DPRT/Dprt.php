<?php

namespace App\Models\DPRT;

use App\Models\DPC\Dpc;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dprt extends Model
{
    use SoftDeletes;

    protected $table = 'dprt';
    
    protected $fillable = [
        'dpc_id',
        'desa_name',
        'slug',
        'address',
        'phone',
        'email',
        'ketua',
        'total_kader',
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

    public function dpc()
    {
        return $this->belongsTo(Dpc::class, 'dpc_id');
    }

    public function structures()
    {
        return $this->hasMany(DprtStructure::class, 'dprt_id');
    }

    public function kaders()
    {
        return $this->hasMany(\App\Models\Kader\Kader::class, 'dprt_id');
    }

    public function activeStructures()
    {
        return $this->structures()->where('is_active', true)->orderBy('order');
    }
}