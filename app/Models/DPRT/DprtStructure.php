<?php

namespace App\Models\DPRT;

use Illuminate\Database\Eloquent\Model;

class DprtStructure extends Model
{
    protected $table = 'dprt_structures';
    
    protected $fillable = [
        'dprt_id',
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
    ];

    public function dprt()
    {
        return $this->belongsTo(Dprt::class, 'dprt_id');
    }
}