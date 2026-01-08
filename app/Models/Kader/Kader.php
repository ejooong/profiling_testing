<?php

namespace App\Models\Kader;

use App\Models\User;
use App\Models\DPC\Dpc;
use App\Models\DPRT\Dprt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Kader extends Model
{
    use SoftDeletes;

    protected $table = 'kaders';
    
    protected $fillable = [
        'user_id',
        'dpc_id',
        'dprt_id',
        'nik',
        'name',
        'email',
        'phone',
        'gender',
        'birth_place',
        'birth_date',
        'address',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'profession',
        'education',
        'photo_path',
        'status',
        'join_date',
        'skills',
        'position_in_party',
        'is_verified',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'birth_date' => 'date',
        'join_date' => 'date',
        'verified_at' => 'datetime',
        'skills' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dpc()
    {
        return $this->belongsTo(Dpc::class, 'dpc_id');
    }

    public function dprt()
    {
        return $this->belongsTo(Dprt::class, 'dprt_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    public function scopeVerified(Builder $query)
    {
        return $query->where('is_verified', true);
    }

    public function scopePending(Builder $query)
    {
        return $query->where('status', 'pending');
    }
    public function getFullNameAttribute()
{
    return $this->name;
}

}