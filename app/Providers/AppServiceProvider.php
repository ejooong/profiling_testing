<?php

namespace App\Providers;

use App\Models\Gallery;
use App\Models\Berita\Berita;
use App\Models\Berita\BeritaCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
                // TAMBAHKAN MORPH MAP DISINI
        Relation::morphMap([
            'dpd' => \App\Models\DPD\Dpd::class,
            'dpc' => \App\Models\DPC\Dpc::class,
            'dprt' => \App\Models\DPRT\Dprt::class,
        ]);

        // Share popular news dengan semua view front
        View::composer('front.*', function ($view) {
            $view->with('popularNews', Berita::published()
                ->orderBy('views', 'desc')
                ->take(5)
                ->get());

            $view->with('categories', BeritaCategory::where('is_active', true)->get());

            // Share recent galleries
            $view->with('recentGalleries', Gallery::where('is_published', true)
                ->withCount('images')
                ->orderBy('event_date', 'desc')
                ->take(6)
                ->get());

            // Share gallery stats
            $view->with('galleryStats', [
                'total' => Gallery::where('is_published', true)->count(),
                'images' => \DB::table('gallery_images')
                    ->join('galleries', 'gallery_images.gallery_id', '=', 'galleries.id')
                    ->where('galleries.is_published', true)
                    ->count(),
                'views' => Gallery::where('is_published', true)->sum('views'),
            ]);
        });
    }
}
