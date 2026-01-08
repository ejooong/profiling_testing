<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'event_date',
        'event_time',
        'location',
        'participant_count',
        'views',
        'is_published',
        'created_at',  // Tambahkan ini jika belum ada
        'updated_at'   // Tambahkan ini jika belum ada
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_published' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gallery) {
            $gallery->slug = \Str::slug($gallery->title);
        });

        static::updating(function ($gallery) {
            $gallery->slug = \Str::slug($gallery->title);
        });
    }

    public function images()
    {
        return $this->hasMany(GalleryImage::class)->orderBy('sort_order');
    }

    public function getImageCountAttribute()
    {
        return $this->images()->count();
    }

    public function getFeaturedImageAttribute()
    {
        return $this->images()->first();
    }

    public function getCategoryLabelAttribute()
    {
        $labels = [
            'pelantikan' => 'Pelantikan',
            'sosial' => 'Bakti Sosial',
            'rapat' => 'Rapat Kerja',
            'kunjungan' => 'Kunjungan',
            'pelatihan' => 'Pelatihan',
            'kerjasama' => 'Kerjasama',
            'lainnya' => 'Lainnya'
        ];

        return $labels[$this->category] ?? 'Lainnya';
    }

    public function getCategoryColorAttribute()
    {
        $colors = [
            'pelantikan' => 'bg-[#001F3F]',
            'sosial' => 'bg-green-600',
            'rapat' => 'bg-blue-600',
            'kunjungan' => 'bg-purple-600',
            'pelatihan' => 'bg-yellow-600',
            'kerjasama' => 'bg-indigo-600',
            'lainnya' => 'bg-gray-600'
        ];

        return $colors[$this->category] ?? 'bg-gray-600';
    }
}
