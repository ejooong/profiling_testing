<?php

namespace App\Models\Berita;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BeritaCategory extends Model
{
    use SoftDeletes;

    protected $table = 'berita_categories';
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function beritas()
    {
        return $this->hasMany(Berita::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}