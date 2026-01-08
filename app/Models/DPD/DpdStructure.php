<?php

namespace App\Models\DPD;

use Illuminate\Database\Eloquent\Model;

class DpdStructure extends Model
{
    protected $table = 'dpd_structures';

    protected $fillable = [
        'dpd_id',
        'position_reference_id', // TAMBAHKAN
        'kader_id', // TAMBAHKAN
        'position_name',
        'person_name',
        'person_photo',
        'phone',
        'email',
        'order',
        'level',
        'responsibilities',
        'is_active',
        // Tambahkan field baru
        'periode_mulai',
        'periode_selesai',
        'ketua',
        'sekretaris',
        'bendahara',
        'ketua_photo',
        'sekretaris_photo',
        'bendahara_photo',
        'departemen',
        'panitia',
        'visi',
        'misi',
        'catatan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'departemen' => 'array',    // ← Cast JSON ke array
        'panitia' => 'array',       // ← Cast JSON ke array
    ];
    // Tambahkan relasi baru
    public function positionReference()
    {
        return $this->belongsTo(\App\Models\PositionReference::class, 'position_reference_id');
    }
    public function kader()
    {
        return $this->belongsTo(\App\Models\Kader\Kader::class, 'kader_id');
    }
    public function dpd()
    {
        return $this->belongsTo(Dpd::class, 'dpd_id');
    }
}
