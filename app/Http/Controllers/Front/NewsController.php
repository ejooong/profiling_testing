<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Berita\Berita;
use App\Models\Berita\BeritaCategory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function index()
    {
        $news = Berita::published()
            ->latest('published_at')
            ->paginate(9);
        
        $categories = BeritaCategory::where('is_active', true)->get();
        
        $popularNews = Berita::published()
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();
        
        // Tambahkan statistik
        $totalNews = Berita::published()->count();
        $totalViews = Berita::published()->sum('views');
        $recentNewsCount = Berita::published()
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->count();
        
        return view('front.news.index', compact(
            'news', 
            'categories', 
            'popularNews',
            'totalNews',
            'totalViews',
            'recentNewsCount'
        ));
    }
    
    public function show($slug)
    {
        $news = Berita::where('slug', $slug)
            ->published()
            ->firstOrFail();
        
        // Increment views
        $news->incrementViews();
        
        $relatedNews = Berita::published()
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->take(3)
            ->get();
        
        // Tambahkan popularNews
        $popularNews = Berita::published()
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();
        
        // Tambahkan categories untuk sidebar
        $categories = BeritaCategory::where('is_active', true)->get();
        
        return view('front.news.show', compact('news', 'relatedNews', 'popularNews', 'categories'));
    }
    
    public function byCategory($slug)
    {
        $category = BeritaCategory::where('slug', $slug)->firstOrFail();
        
        $news = Berita::published()
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(9);
        
        $categories = BeritaCategory::where('is_active', true)->get();
        
        return view('front.news.category', compact('news', 'category', 'categories'));
    }
}