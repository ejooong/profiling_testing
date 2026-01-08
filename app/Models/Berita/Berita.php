<?php

namespace App\Models\Berita;

use App\Models\User;
use App\Models\DPC\Dpc;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Berita extends Model
{
    use SoftDeletes;

    protected $table = 'beritas';
    
    protected $fillable = [
        'user_id',
        'category_id',
        'dpc_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'gallery_images',
        'author_name',
        'author_photo',
        'views',
        'status',
        'published_at',
        'meta_keywords',
        'meta_description',
        'is_featured',
        'is_headline',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'meta_keywords' => 'array',
        'is_featured' => 'boolean',
        'is_headline' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(BeritaCategory::class, 'category_id');
    }

    public function dpc()
    {
        return $this->belongsTo(Dpc::class, 'dpc_id');
    }

    // Scope untuk berita yang sudah dipublikasikan
    public function scopePublished(Builder $query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeHeadline(Builder $query)
    {
        return $query->where('is_headline', true);
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}