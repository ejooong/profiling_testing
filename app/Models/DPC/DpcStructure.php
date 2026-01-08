<?php

namespace App\Models\DPC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DpcStructure extends Model
{
    use SoftDeletes;

    protected $table = 'dpc_structures';
    
    protected $fillable = [
        'dpc_id',
        'position_name',
        'person_name',
        'person_photo',
        'phone',
        'email',
        'order',
        'level',
        'responsibilities',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function dpc()
    {
        return $this->belongsTo(Dpc::class, 'dpc_id');
    }
}