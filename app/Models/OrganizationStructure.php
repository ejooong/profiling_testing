<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Kader\Kader;
use App\Models\DPD\Dpd;
use App\Models\DPC\Dpc;
use App\Models\DPRT\Dprt;

class OrganizationStructure extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'organization_structures';

    protected $fillable = [
        'organization_type',
        'organization_id',
        'position_id',
        'kader_id',
        'external_name',
        'external_photo',
        'external_phone',
        'external_email',
        'period_start',
        'period_end',
        'order',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'is_active' => 'boolean',
    ];

    // Relasi ke posisi referensi
    public function position()
    {
        return $this->belongsTo(PositionReference::class, 'position_id');
    }

    // Relasi ke kader
    public function kader()
    {
        return $this->belongsTo(Kader::class, 'kader_id');
    }

    // Relasi ke organisasi (DPD, DPC, DPRT) - PERBAIKI DISINI
    public function organization()
    {
        return $this->morphTo(__FUNCTION__, 'organization_type', 'organization_id');
    }

    // Scope untuk aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk organisasi tertentu
    public function scopeForOrganization($query, $type, $id)
    {
        return $query->where('organization_type', $type)
            ->where('organization_id', $id);
    }

    // Scope untuk periode aktif saat ini
    public function scopeCurrentPeriod($query)
    {
        $now = now()->format('Y-m-d');
        return $query->where(function ($q) use ($now) {
            $q->whereNull('period_start')
                ->orWhere('period_start', '<=', $now);
        })->where(function ($q) use ($now) {
            $q->whereNull('period_end')
                ->orWhere('period_end', '>=', $now);
        });
    }

    // Helper untuk mendapatkan nama orang
    public function getPersonNameAttribute()
    {
        if ($this->kader_id) {
            return $this->kader->name ?? null;
        }
        return $this->external_name;
    }

    // Helper untuk mendapatkan foto
    public function getPersonPhotoAttribute()
    {
        if ($this->kader_id && $this->kader->photo_path) {
            return $this->kader->photo_path;
        }
        return $this->external_photo;
    }
}
