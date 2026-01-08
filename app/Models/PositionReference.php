<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PositionReference extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'position_references';

    protected $fillable = [
        'code',
        'name',
        'organization_level',
        'category',
        'order',
        'description',
        'responsibilities',
        'is_required',
        'is_active',
    ];

    protected $casts = [
        'responsibilities' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Scope untuk filter berdasarkan level organisasi
    public function scopeForOrganizationLevel($query, $level)
    {
        return $query->where(function ($q) use ($level) {
            $q->where('organization_level', $level)
                ->orWhere('organization_level', 'all');
        });
    }

    // Scope untuk posisi aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk posisi wajib
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    // Relasi ke struktur organisasi
    public function organizationStructures()
    {
        return $this->hasMany(OrganizationStructure::class, 'position_id');
    }
}
