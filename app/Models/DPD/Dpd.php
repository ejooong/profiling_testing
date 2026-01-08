<?php

namespace App\Models\DPD;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DPC\Dpc; // TAMBAHKAN INI
class Dpd extends Model
{
    use SoftDeletes;

    protected $table = 'dpd';

    protected $fillable = [
        'name',
        'slug',
        'address',
        'phone',
        'email',
        'ketua',
        'sekretaris',
        'bendahara',
        'total_kader',
        'total_dpc',
        'logo_path',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function structures()
    {
        return $this->hasMany(DpdStructure::class, 'dpd_id');
    }

    public function dpc()
    {
        return $this->hasMany(\App\Models\DPC\Dpc::class, 'dpd_id');
    }

    public function activeStructures()
    {
        return $this->structures()->where('is_active', true)->orderBy('order');
    }
}
