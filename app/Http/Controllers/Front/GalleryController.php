<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');

        $galleries = Gallery::withCount('images')
            ->where('is_published', true)
            ->when($category && $category !== 'all', function ($query) use ($category) {
                return $query->where('category', $category);
            })
            ->orderBy('event_date', 'desc')
            ->paginate(9);

        $totalGalleries = Gallery::where('is_published', true)->count();
        $totalImages = \DB::table('gallery_images')
            ->join('galleries', 'gallery_images.gallery_id', '=', 'galleries.id')
            ->where('galleries.is_published', true)
            ->count();

        return view('front.gallery', compact('galleries', 'category', 'totalGalleries', 'totalImages'));
    }

    public function show($slug)
    {
        $gallery = Gallery::with('images')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment view count
        $gallery->increment('views');

        // Get related galleries
        $relatedGalleries = Gallery::where('category', $gallery->category)
            ->where('id', '!=', $gallery->id)
            ->where('is_published', true)
            ->withCount('images')
            ->latest()
            ->take(4)
            ->get();

        return view('front.gallery-detail', compact('gallery', 'relatedGalleries'));
    }

    private function storeImage($image)
    {
        // Buat folder berdasarkan tahun/bulan
        $year = date('Y');
        $month = date('m');
        $path = "galleries/{$year}/{$month}";

        // Buat folder jika belum ada
        $fullPath = storage_path("app/public/{$path}");
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        // Generate nama file unik
        $filename = Str::random(20) . '_' . time() . '.' . $image->getClientOriginalExtension();

        // Simpan gambar
        $image->storeAs($path, $filename, 'public');

        return "{$path}/{$filename}";
    }
}
